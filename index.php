<?php
declare(strict_types=1);

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');

$apiResponse = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $raw = file_get_contents('php://input');
    $data = json_decode($raw ?: '', true);

    // Intentionally do NOT accept or store the PIN.
    // Only anonymous strength metadata may be sent here.
    $strength = isset($data['strength']) && is_string($data['strength'])
        ? $data['strength']
        : '';

    $allowed = ['Weak', 'Medium', 'Strong'];

    if (!in_array($strength, $allowed, true)) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Invalid result']);
        exit;
    }

    // Optional anonymous event endpoint. The actual PIN never reaches PHP.
    echo json_encode(['ok' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Mobile PIN strength checker. Your PIN is analyzed locally and never stored.">
    <title>PIN Strength Checker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="app">
    <section class="phone-card" aria-label="PIN strength checker">
        <div class="top-bar">
            <span class="brand-dot"></span>
            <span>PIN CHECK</span>
            <span class="secure">PRIVATE</span>
        </div>

        <div class="screen">
            <div class="lock-icon" aria-hidden="true">⌁</div>
            <h1>Enter your PIN</h1>
            <p class="subtitle">Your PIN is checked on this device.</p>

            <div id="dots" class="pin-dots" aria-label="PIN entry" aria-live="polite"></div>

            <div id="status" class="status" data-level="idle">
                <span class="status-light"></span>
                <span id="statusText">Enter 4–6 digits</span>
            </div>
        </div>

        <div class="keypad" id="keypad">
            <button class="key" data-key="1">1</button>
            <button class="key" data-key="2">2<span>ABC</span></button>
            <button class="key" data-key="3">3<span>DEF</span></button>

            <button class="key" data-key="4">4<span>GHI</span></button>
            <button class="key" data-key="5">5<span>JKL</span></button>
            <button class="key" data-key="6">6<span>MNO</span></button>

            <button class="key" data-key="7">7<span>PQRS</span></button>
            <button class="key" data-key="8">8<span>TUV</span></button>
            <button class="key" data-key="9">9<span>WXYZ</span></button>

            <button class="key key-action" id="clearBtn" aria-label="Clear PIN">C</button>
            <button class="key" data-key="0">0</button>
            <button class="key key-action" id="backBtn" aria-label="Delete last digit">⌫</button>
        </div>

        <button class="check-btn" id="checkBtn" disabled>CHECK PIN</button>

        <div id="result" class="result hidden">
            <div id="resultIcon" class="result-icon">✓</div>
            <div>
                <strong id="resultTitle">Strong</strong>
                <p id="resultMessage">Good PIN.</p>
            </div>
        </div>

        <p class="privacy">🔒 Nothing is saved. The PIN stays in your browser.</p>
    </section>
</main>

<script src="script.js"></script>
</body>
</html>
