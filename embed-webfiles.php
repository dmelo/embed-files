<?php

function printUsage()
{
    echo "Usage: php embed-webfiles PLATFORM SOURCE_DIR OUTPUT_H" . PHP_EOL . PHP_EOL;
    echo "    PLATFORM - Possible values are \"arduino\" and \"mbedos\"" . PHP_EOL;
    echo "    SOURCE_DIR - Directory that contains all files to be encoded" . PHP_EOL;
    echo "    OUTPUT_H - Output C header file name where the encoded failes will be stored" . PHP_EOL;
    echo PHP_EOL;

}

function strToIntArray($str)
{
    $arr = str_split($str);
    $intArray = [];
    foreach ($arr as $char) {
        $intArray[] = ord($char);
    }
    $intArray []= 0;

    return implode(', ', $intArray);
}

if (4 != count($argv)) {
    printUsage();
    return 4;
}

$platform = $argv[1];

if (!in_array($platform, ["arduino", "mbedos"])) {
    printUsage();
    return 5;
}

$dirname = $argv[2];
$outputFile = $argv[3];

if (!is_dir($dirname)) {
    echo "Not a directory: $dirname" . PHP_EOL;
    printUsage();
    return 1;
}

if (false === ($handle = opendir($dirname))) {
    echo "Could not open dir: $dirname" . PHP_EOL;
    printUsage();
    return 2;
}

if (false === ($fd = fopen($outputFile, "w"))) {
    echo "Could not open output file: $outputFile" . PHP_EOL;
    printUsage();
    return 3;
}

fwrite($fd, "#ifndef EMBED_WEBFILES_H" . PHP_EOL);
fwrite($fd, "#define EMBED_WEBFILES_H" . PHP_EOL . PHP_EOL);

while ($entry = readdir($handle)) {
    $filename = $dirname . '/' . $entry;
    $define = strtoupper(str_replace('.', '_', $entry));
    if (!is_file($filename) || preg_match('/^\./', $entry)) {
        continue;
    }

    echo "Importing: $filename to define $define" . PHP_EOL;
    $content = file_get_contents($filename);
    $fileContent = strToIntArray($content);
    $variable = "arduino" === $platform ?
        "static const char {$define}[] ICACHE_RODATA_ATTR":
        "static const char {$define}[]";

    fwrite($fd, "$variable = {" . $fileContent . "};" . PHP_EOL);
}

fwrite($fd, PHP_EOL . "#endif");

fclose($fd);
closedir($handle);
