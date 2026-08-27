let pin = "";

const MAX_LENGTH = 6;
const MIN_LENGTH = 4;

function pressKey(number) {

    if (pin.length >= MAX_LENGTH) {
        showMessage("Maximum 6 digits allowed", "error");
        return;
    }

    pin += number;

    updateDisplay();

    clearMessage();
}


function deleteLast() {

    if (pin.length > 0) {
        pin = pin.slice(0, -1);
    }

    updateDisplay();

    clearMessage();
}


function clearPin() {

    pin = "";

    updateDisplay();

    clearMessage();
}


function updateDisplay() {

    const dots = document.querySelectorAll("#pinDots span");

    dots.forEach((dot, index) => {

        if (index < pin.length) {
            dot.classList.add("active");
        } else {
            dot.classList.remove("active");
        }

    });
}


function submitPin() {

    if (pin.length < MIN_LENGTH) {

        showMessage(
            "PIN must contain at least 4 digits",
            "error"
        );

        return;
    }

    if (pin.length > MAX_LENGTH) {

        showMessage(
            "PIN cannot contain more than 6 digits",
            "error"
        );

        return;
    }

    const enterButton =
        document.getElementById("enterButton");

    enterButton.disabled = true;

    enterButton.textContent = "SAVING...";


    fetch("save.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            pin: pin
        })

    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            showMessage(
                "✓ PIN saved successfully",
                "success"
            );

            pin = "";

            updateDisplay();

        } else {

            showMessage(
                data.message || "Something went wrong",
                "error"
            );

        }

    })

    .catch(error => {

        console.error(error);

        showMessage(
            "Unable to save PIN",
            "error"
        );

    })

    .finally(() => {

        enterButton.disabled = false;

        enterButton.textContent = "ENTER";

    });
}


function showMessage(text, type) {

    const message =
        document.getElementById("message");

    message.textContent = text;

    if (type === "error") {
        message.style.color = "#ff6b6b";
    } else {
        message.style.color = "#42e695";
    }
}


function clearMessage() {

    const message =
        document.getElementById("message");

    message.textContent = "";
}


/* Keyboard support */

document.addEventListener("keydown", function(event) {

    if (event.key >= "0" && event.key <= "9") {

        pressKey(event.key);

    } else if (event.key === "Backspace") {

        deleteLast();

    } else if (event.key === "Escape") {

        clearPin();

    } else if (event.key === "Enter") {

        submitPin();

    }

});
