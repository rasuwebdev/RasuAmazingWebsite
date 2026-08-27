(() => {
    "use strict";

    let pin = "";
    const MAX = 6;
    const MIN = 4;

    const dots = document.getElementById("dots");
    const status = document.getElementById("status");
    const statusText = document.getElementById("statusText");
    const checkBtn = document.getElementById("checkBtn");
    const clearBtn = document.getElementById("clearBtn");
    const backBtn = document.getElementById("backBtn");
    const result = document.getElementById("result");
    const resultIcon = document.getElementById("resultIcon");
    const resultTitle = document.getElementById("resultTitle");
    const resultMessage = document.getElementById("resultMessage");

    function renderDots() {
        dots.innerHTML = "";
        for (let i = 0; i < MAX; i++) {
            const dot = document.createElement("span");
            dot.className = "dot" + (i < pin.length ? " filled" : "");
            dots.appendChild(dot);
        }

        checkBtn.disabled = pin.length < MIN;
        result.classList.add("hidden");

        if (pin.length === 0) {
            status.dataset.level = "idle";
            statusText.textContent = "Enter 4–6 digits";
        } else if (pin.length < MIN) {
            status.dataset.level = "idle";
            statusText.textContent = `${MIN - pin.length} more digit${MIN - pin.length === 1 ? "" : "s"} needed`;
        } else {
            status.dataset.level = "idle";
            statusText.textContent = "Ready to check";
        }
    }

    function addDigit(digit) {
        if (pin.length >= MAX) return;
        pin += digit;
        renderDots();
        navigator.vibrate?.(12);
    }

    function removeDigit() {
        if (!pin.length) return;
        pin = pin.slice(0, -1);
        renderDots();
        navigator.vibrate?.(8);
    }

    function clearPin() {
        pin = "";
        renderDots();
    }

    function isSequential(value) {
        const digits = value.split("").map(Number);
        const ascending = digits.every((n, i) => i === 0 || n === digits[i - 1] + 1);
        const descending = digits.every((n, i) => i === 0 || n === digits[i - 1] - 1);
        return ascending || descending;
    }

    function allSame(value) {
        return /^(\d)\1+$/.test(value);
    }

    function repeatedPair(value) {
        return /^(\d\d)\1+$/.test(value);
    }

    function hasManyRepeatedDigits(value) {
        const counts = {};
        for (const digit of value) counts[digit] = (counts[digit] || 0) + 1;
        return Math.max(...Object.values(counts)) >= Math.ceil(value.length * 0.67);
    }

    function scorePin(value) {
        // This is a simple educational heuristic, not a cryptographic password meter.
        const common = new Set([
            "0000", "1111", "2222", "3333", "4444", "5555",
            "6666", "7777", "8888", "9999", "1234", "4321",
            "1212", "2121", "1122", "1221", "2580", "0852",
            "12345", "54321", "123456", "654321", "111111",
            "000000", "121212", "112233"
        ]);

        let score = 0;

        if (value.length === 4) score += 1;
        if (value.length >= 5) score += 2;
        if (value.length === 6) score += 2;

        if (!common.has(value)) score += 2;
        else score -= 4;

        if (!isSequential(value)) score += 2;
        else score -= 2;

        if (!allSame(value)) score += 2;
        else score -= 3;

        if (!repeatedPair(value)) score += 1;
        else score -= 2;

        if (!hasManyRepeatedDigits(value)) score += 1;
        else score -= 1;

        if (score <= 2) return "Weak";
        if (score <= 5) return "Medium";
        return "Strong";
    }

    async function checkPin() {
        if (pin.length < MIN) return;

        const strength = scorePin(pin);

        status.dataset.level = strength.toLowerCase();
        statusText.textContent =
            strength === "Strong" ? "Good PIN pattern" :
            strength === "Medium" ? "Could be stronger" :
            "Easy-to-guess pattern";

        result.classList.remove("hidden");

        if (strength === "Strong") {
            resultIcon.textContent = "✓";
            resultTitle.textContent = "Strong";
            resultMessage.textContent = "No obvious weak pattern detected.";
        } else if (strength === "Medium") {
            resultIcon.textContent = "!";
            resultTitle.textContent = "Medium";
            resultMessage.textContent = "Consider using a less predictable PIN.";
        } else {
            resultIcon.textContent = "×";
            resultTitle.textContent = "Weak";
            resultMessage.textContent = "This PIN contains an easy-to-guess pattern.";
        }

        // Only the strength label is sent. The PIN is never sent to PHP.
        try {
            await fetch(window.location.href, {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({strength})
            });
        } catch (_) {
            // The checker still works if the optional endpoint is unavailable.
        }

        pin = "";
        renderDots();
    }

    document.querySelectorAll("[data-key]").forEach(button => {
        button.addEventListener("click", () => addDigit(button.dataset.key));
    });

    clearBtn.addEventListener("click", clearPin);
    backBtn.addEventListener("click", removeDigit);
    checkBtn.addEventListener("click", checkPin);

    document.addEventListener("keydown", event => {
        if (/^\d$/.test(event.key)) addDigit(event.key);
        else if (event.key === "Backspace") removeDigit();
        else if (event.key === "Escape") clearPin();
        else if (event.key === "Enter") checkPin();
    });

    renderDots();
})();
