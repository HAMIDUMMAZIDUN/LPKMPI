<?php
$dir = new RecursiveDirectoryIterator("resources/views");
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, "/.*\.blade\.php$/", RegexIterator::GET_MATCH);

$patterns = [
    "/text-slate-850/" => "text-slate-800",
    "/text-slate-455/" => "text-slate-400",
    "/text-slate-705/" => "text-slate-700",
    "/text-slate-355/" => "text-slate-400",
    "/text-slate-655/" => "text-slate-600",
    "/text-slate-905/" => "text-slate-900",
    "/text-slate-105/" => "text-slate-100",
    "/text-slate-555/" => "text-slate-500",
    "/text-slate-805/" => "text-slate-800",
    "/text-slate-450/" => "text-slate-400",
    "/text-slate-505/" => "text-slate-500",
    "/text-slate-250/" => "text-slate-200",
    "/text-slate-650/" => "text-slate-600",
    "/blue-650/" => "blue-600",
    "/blue-850/" => "blue-800",
    "/emerald-455/" => "emerald-400",
    "/amber-455/" => "amber-400",
    "/amber-450/" => "amber-400",
    "/rose-455/" => "rose-400",
    "/bg-slate-105/" => "bg-slate-100",
    "/bg-slate-150/" => "bg-slate-100",
    "/border-slate-150/" => "border-slate-200",
    "/slate-955/" => "slate-950",
    "/dark:text-slate-150/" => "dark:text-slate-200",
    "/dark:text-slate-350/" => "dark:text-slate-300",
    "/border-slate-850/" => "border-slate-800",
    "/bg-slate-850/" => "bg-slate-800",
    "/dark:border-slate-850/" => "dark:border-slate-800",
    "/dark:bg-slate-850/" => "dark:bg-slate-800"
];

foreach ($files as $file) {
    $f = $file[0];
    $c = file_get_contents($f);
    
    foreach ($patterns as $pattern => $replacement) {
        $c = preg_replace($pattern, $replacement, $c);
    }
    
    // Also inject dark:text-slate-400 to text-slate-500 that miss it
    $c = preg_replace_callback("/class=\"([^\"]*)text-slate-500([^\"]*)\"/", function($m) {
        if (strpos($m[0], "dark:text-") === false) {
            return "class=\"" . $m[1] . "text-slate-500 dark:text-slate-400" . $m[2] . "\"";
        }
        return $m[0];
    }, $c);
    
    file_put_contents($f, $c);
}
echo "Done";

