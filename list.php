<?php

# List Files

foreach(glob("*.{txt,html,json}", GLOB_BRACE) as $file) {
    $filenames[] = basename($file);
}

if (empty($filenames)) {
    exit('Nothing to show...');
}

rsort($filenames);

foreach($filenames as $filename) {
    echo '<a href="' . $filename . '" target="_blank">' . $filename . '</a><br>';
}
