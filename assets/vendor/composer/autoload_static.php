<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit118e84ee864fe1f6a66e3077432ba885
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit118e84ee864fe1f6a66e3077432ba885::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit118e84ee864fe1f6a66e3077432ba885::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit118e84ee864fe1f6a66e3077432ba885::$classMap;

        }, null, ClassLoader::class);
    }
}
