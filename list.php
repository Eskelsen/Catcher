<?php

# List Files

foreach(glob(__DIR__ . '/logs/' . "*.{txt,html,json}", GLOB_BRACE) as $file) {
    $filenames[] = basename($file);
}

if (empty($filenames)) {
    exit('Nothing to show...');
}

rsort($filenames);

foreach($filenames as $filename) {
    echo '<a href="logs/' . $filename . '" target="_blank">' . $filename . '</a>';
    echo ' &nbsp; <a href="?excluir=logs/' . $filename . '">excluir</a><br>';
}
