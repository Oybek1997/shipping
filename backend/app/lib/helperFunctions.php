<?php

if (!function_exists('recursive_directory')) {

    /**
     * return the factorial of a number
     *
     * @param $number
     * @return string
     */
    function recursive_directory($dirname, $maxdepth = 10, $depth = 0)
    {
        if ($depth >= $maxdepth) {
            return false;
        }
        $subdirectories = array();
        $files = array();
        if (is_dir($dirname) && is_readable($dirname)) {
            $d = dir($dirname);
            while (false !== ($f = $d->read())) {
                $file = $d->path . '/' . $f;
                // skip . and ..
                if (('.' == $f) || ('..' == $f)) {
                    continue;
                };
                if (is_dir($dirname . '/' . $f)) {
                    array_push($subdirectories, $dirname . '/' . $f);
                } else {
                    array_push($files, $dirname . '/' . $f);
                };
            };
            $d->close();
            foreach ($subdirectories as $subdirectory) {
                $files = array_merge($files, recursive_directory($subdirectory, $maxdepth, $depth + 1));
            };
        }
        dd($files);
    }
}
