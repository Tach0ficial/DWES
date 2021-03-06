<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1d2df34c5bc3ae289f8dc7588e77b90d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1d2df34c5bc3ae289f8dc7588e77b90d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1d2df34c5bc3ae289f8dc7588e77b90d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1d2df34c5bc3ae289f8dc7588e77b90d::$classMap;

        }, null, ClassLoader::class);
    }
}
