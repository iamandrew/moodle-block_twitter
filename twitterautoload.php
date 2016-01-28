<?php
/**
 * Use to autoload needed classes without Composer.
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    $prefix = 'Abraham\\TwitterOAuth\\';
    $basedir = __DIR__ . '/twitter/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeclass = substr($class, $len);
    $file = $basedir . str_replace('\\', '/', $relativeclass) . '.php';
    if (file_exists($file)) {
        require($file);
    }
});
