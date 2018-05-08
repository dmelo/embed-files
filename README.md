# Embed-Files

Prepare files to be written on Arduino and MBed OS devices flash.

## Install:

```
composer require dmelo/embed-files
````

## Usage:

```
Usage: ./vendor/bin/embed-files PLATFORM SOURCE_DIR OUTPUT_H

    PLATFORM - Possible values are "arduino" and "mbedos"
    SOURCE_DIR - Directory that contains all files to be encoded
    OUTPUT_H - Output C header file name where the encoded failes will be stored
```

Where `SOURCE_DIR` is the directory containing all the files to be encoded. So far,
it is not recursive. And `OUTPUT_H` is the output C header file that will contain
the files, in binary format.

If `SOURCE_DIR` contains a file name `jquery.min.js`, then that file will be
availeble on the variable named `JQUERY_MIN_JS`.

## Accessing strings on Arduino and ESP8266

Due to the fact that Arduino/ESP8266 flash can only be fetched in chunks of 32
bits. You need be carefull accessing that data. Refer to
[http://arduino-esp8266.readthedocs.io/en/latest/PROGMEM.html]() to get the
details.
