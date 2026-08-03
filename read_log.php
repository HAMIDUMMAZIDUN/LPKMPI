<?php
$logPath = "C:\\Users\\HAMIDUN\\.gemini\\antigravity\\brain\\21ee70e1-2ea0-44b9-8d47-39ef2c4c7989\\.system_generated\\logs\\overview.txt";
$content = file_get_contents($logPath);

// Convert UTF-16 to UTF-8 if necessary
if (substr($content, 0, 2) === "\xFF\xFE" || substr($content, 0, 2) === "\xFE\xFF") {
    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16');
}

echo "Length: " . strlen($content) . "\n";
echo "First 500 chars:\n" . substr($content, 0, 500) . "\n";

// Search for keywords
$keywords = ['ai', 'artificial', 'intelligence', 'chatbot', 'kecerdasan', 'buatan', 'bot'];
foreach ($keywords as $kw) {
    if (preg_match_all('/\b' . preg_quote($kw, '/') . '\b/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
        echo "Found '$kw': " . count($matches[0]) . " times\n";
        foreach (array_slice($matches[0], 0, 5) as $m) {
            $start = max(0, $m[1] - 50);
            $len = min(strlen($content) - $start, 100);
            echo "  Context: ..." . str_replace("\n", " ", substr($content, $start, $len)) . "...\n";
        }
    }
}
