# Embed-Files

Prepare files to be written on Arduino flash.

## Usage:

```
php embed-files mbedos src-dir/ flashfiles.h
```

Where `src-dir` is the directory containing all the files to be encoded. So far,
it is not recursive. And `flashfile.h` is the C header file that will contain
the files, in binary format.

If `src-dir/` contains a file name `jquery.min.js`, the that file will be
availeble on the variable named `JQUERY_MIN_JS`.

## Accessing strings on Arduino and ESP8266

Due to the fact that Arduino/ESP8266 flash can only be fetched in chunks of 32
bits. You need be carefull accessing that data. Refer to
[http://arduino-esp8266.readthedocs.io/en/latest/PROGMEM.html]() to get the
details.
