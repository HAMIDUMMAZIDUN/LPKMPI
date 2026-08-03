<?php
$logPath = "C:\\Users\\HAMIDUN\\.gemini\\antigravity\\brain\\21ee70e1-2ea0-44b9-8d47-39ef2c4c7989\\.system_generated\\logs\\overview.txt";
$content = file_get_contents($logPath);

if (substr($content, 0, 2) === "\xFF\xFE" || substr($content, 0, 2) === "\xFE\xFF") {
    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16');
}

$output = "";

// Let's find all occurrences of JSON-like patterns in overview.txt
preg_match_all('/({[^{}]*"TargetContent"[^{}]*})/s', $content, $matches);

foreach ($matches[1] as $jsonBlock) {
    if (strpos($jsonBlock, 'svg') !== false || strpos($jsonBlock, 'SVG') !== false) {
        $decoded = json_decode($jsonBlock, true);
        if ($decoded) {
            $output .= "========================================\n";
            $output .= "TARGET FILE: " . ($decoded['TargetFile'] ?? 'unknown') . "\n";
            $output .= "========================================\n";
            $output .= "--- TARGET CONTENT ---\n" . ($decoded['TargetContent'] ?? '') . "\n";
            $output .= "--- REPLACEMENT CONTENT ---\n" . ($decoded['ReplacementContent'] ?? '') . "\n\n";
        }
    }
}

// Check for nested ReplacementChunks in arrays
preg_match_all('/("TargetFile"\s*:\s*"[^"]*").*?("ReplacementChunks"\s*:\s*\[.*?\])/s', $content, $matchesChunks);
foreach ($matchesChunks[0] as $match) {
    $wrapped = "{" . $match . "}";
    $decoded = json_decode($wrapped, true);
    if ($decoded && isset($decoded['ReplacementChunks'])) {
        $output .= "========================================\n";
        $output .= "BATCH CHUNKS FOR: " . ($decoded['TargetFile'] ?? 'unknown') . "\n";
        $output .= "========================================\n";
        foreach ($decoded['ReplacementChunks'] as $chunk) {
            if (strpos(json_encode($chunk), 'svg') !== false || strpos(json_encode($chunk), 'SVG') !== false) {
                $output .= "--- CHUNK TARGET CONTENT ---\n" . ($chunk['TargetContent'] ?? '') . "\n";
                $output .= "--- CHUNK REPLACEMENT CONTENT ---\n" . ($chunk['ReplacementContent'] ?? '') . "\n\n";
            }
        }
    }
}

file_put_to_file:
file_put_contents(__DIR__ . '/extracted_svgs.txt', $output);
echo "Written to extracted_svgs.txt. Length: " . strlen($output) . "\n";
