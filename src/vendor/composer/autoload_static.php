<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit178a279eddf57a796a768267175c1780
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
        'D' => 
        array (
            'Ds\\' => 3,
            'Doublefou\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Ds\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-ds/php-ds/src',
        ),
        'Doublefou\\' => 
        array (
            0 => __DIR__ . '/..' . '/Doublefou',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit178a279eddf57a796a768267175c1780::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit178a279eddf57a796a768267175c1780::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}