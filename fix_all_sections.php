<?php
$file = 'd:\\APLIKASI RUNNING\\XAMPP\\htdocs\\APLIKASI\\LPK\\resources\\views\\landing.blade.php';
$lines = file($file);
$out = [];
$i = 0;
$n = count($lines);

while ($i < $n) {
    $line = $lines[$i];

    // Fix 1: Line 110 — broken <!-- comment closing immediately followed by <section
    // Pattern: <!-- ===...===>  <section  (no newline between comment close and section)
    // The raw line looks like: <!-- === --><section id="sec-tentang"...
    if (preg_match('/^(<!--[^>]*-->)(\s*)(<section\b.*)$/s', $line, $m)) {
        $out[] = $m[1] . "\n";  // keep the comment line
        $out[] = "    " . $m[3]; // put section on next line
        $i++;
        continue;
    }

    // Fix 2: Line 633 — </    <!-- === --> (closing div then comment merged together)
    // Pattern:  </   <!-- SECTION...
    if (preg_match('/^(\s*<\/)(\s*)(<!--.*)$/s', $line, $m)) {
        $out[] = "</section>\n";        // proper section close
        $out[] = "\n";
        $out[] = $m[3];               // the comment line
        $i++;
        continue;
    }

    // Fix 3: Lines like <!-- =====    <section  (from the regex fix earlier -- they may still exist)
    // Pattern: <!-- ===...===    <section  (spaces between --> and <section, or merged)
    if (preg_match('/^(\s*<!--[^>]*-->\s*)(<section\b.*)$/s', $line, $m)) {
        $out[] = $m[1] . "\n";
        $out[] = "    " . $m[2];
        $i++;
        continue;
    }

    $out[] = $line;
    $i++;
}

file_put_contents($file, implode('', $out));
echo "Pass 1 done. Lines: " . count($out) . "\n";

// Now check what we have
$content = file_get_contents($file);
preg_match_all('/<section\b/', $content, $secOpen);
preg_match_all('/<\/section>/', $content, $secClose);
preg_match_all('/@for\(/', $content, $forOpen);
preg_match_all('/@endfor\b/', $content, $forClose);
echo "<section opens:  " . count($secOpen[0]) . "\n";
echo "</section closes: " . count($secClose[0]) . "\n";
echo "@for( opens:  " . count($forOpen[0]) . "\n";
echo "@endfor closes: " . count($forClose[0]) . "\n";

// Find the @for at line 732 area (fasilitas section) that has no @endfor
$lines2 = explode("\n", $content);
foreach ($lines2 as $idx => $l) {
    if (strpos($l, '@for(') !== false || strpos($l, '@endfor') !== false) {
        echo "Line " . ($idx+1) . ": " . trim($l) . "\n";
    }
}
