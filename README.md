# Embed-Files

Prepare files to be written on Arduino flash.

## Usage:

```
php embed-webfiles.php src-dir/ flashfiles.h
```

Where `src-dir` is the directory containing all the files to be encoded. So far,
it is not recursive. And `flashfile.h` is the C header file that will contain
the files, in binary format.

If `src-dir/` contains a file name `jquery.min.js`, the that file will be
availeble on the variable named `JQUERY_MIN_JS`.
