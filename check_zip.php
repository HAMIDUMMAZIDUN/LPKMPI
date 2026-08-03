<?php
$zip = new ZipArchive();
if ($zip->open('LPK.zip') === TRUE) {
    $landing = $zip->getFromName('resources/views/landing.blade.php');
    if ($landing) {
        $count = substr_count(strtolower($landing), '<svg');
        echo "landing.blade.php in ZIP has $count SVG tags!\n";
    } else {
        echo "landing.blade.php not found in ZIP\n";
    }
    
    $login = $zip->getFromName('resources/views/auth/login.blade.php');
    if ($login) {
        $count = substr_count(strtolower($login), '<svg');
        echo "auth/login.blade.php in ZIP has $count SVG tags!\n";
    }

    $app = $zip->getFromName('resources/views/layouts/app.blade.php');
    if ($app) {
        $count = substr_count(strtolower($app), '<svg');
        echo "layouts/app.blade.php in ZIP has $count SVG tags!\n";
    }

    $zip->close();
} else {
    echo "Failed to open ZIP\n";
}
