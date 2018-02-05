<?php

function strToIntArray($str) {
    $arr = str_split($str);
    $intArray = [];
    foreach ($arr as $char) {
        $intArray[] = ord($char);
    }
    $intArray []= 0;

    return implode(', ', $intArray);
}

$dirname = $argv[1];
$outputFile = $argv[2];

if (!is_dir($dirname)) {
    echo "Not a directory: $dirname" . PHP_EOL;
    return 1;
}

if (false === ($handle = opendir($dirname))) {
    echo "Could not open dir: $dirname" . PHP_EOL;
    return 2;
}

if (false === ($fd = fopen($outputFile, "w"))) {
    echo "Could not open output file: $outputFile" . PHP_EOL;
    return 3;
}

fwrite($fd, "#ifndef EMBED_WEBFILES_H" . PHP_EOL);
fwrite($fd, "#define EMBED_WEBFILES_H" . PHP_EOL . PHP_EOL);

while ($entry = readdir($handle)) {
    $filename = $dirname . '/' . $entry;
    $define = strtoupper(str_replace('.', '_', $entry));
    if (!is_file($filename)) {
        continue;
    }

    echo "Importing: $filename to define $define" . PHP_EOL;
    $content = file_get_contents($filename);
    $fileContent = strToIntArray($content);
    fwrite($fd, "static const char {$define}[] ICACHE_RODATA_ATTR = {" . $fileContent . "};" . PHP_EOL);
}

fwrite($fd, PHP_EOL . "#endif");

fclose($fd);
closedir($handle);
