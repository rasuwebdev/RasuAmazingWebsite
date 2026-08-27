<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIN Cheker with Rasu</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="phone">

    <div class="top-bar">
        <span class="brand">PIN LOCK</span>
        <span class="status">●</span>
    </div>

    <div class="screen">

        <div class="lock-icon">🔐</div>

        <h1>Enter PIN</h1>
        <p class="subtitle">Enter your 4–6 digit PIN</p>

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

    <button id="enterButton" class="enter-button" onclick="submitPin()">
        ENTER
    </button>

</div>

<script src="script.js"></script>

</body>
</html>
