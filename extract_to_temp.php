<?php
$zip = new ZipArchive();
if ($zip->open('LPK.zip') === TRUE) {
    @mkdir('temp_views', 0777, true);
    
    $files = [
        'resources/views/pendaftaran.blade.php',
        'resources/views/auth/mock_google.blade.php',
        'resources/views/dashboard/asesor.blade.php',
        'resources/views/dashboard/admin.blade.php',
        'resources/views/dashboard/superadmin.blade.php',
        'resources/views/landing.blade.php',
        'resources/views/auth/login.blade.php',
        'resources/views/layouts/app.blade.php'
    ];
    
    foreach ($files as $file) {
        $content = $zip->getFromName($file);
        if ($content !== false) {
            $dest = 'temp_views/' . basename($file);
            file_put_contents($dest, $content);
            echo "Extracted $file to $dest\n";
        } else {
            echo "Could not find $file in ZIP\n";
        }
    }
    
    $zip->close();
} else {
    echo "Failed to open ZIP\n";
}
