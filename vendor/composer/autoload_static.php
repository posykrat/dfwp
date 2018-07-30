<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit560139920bccdb938ec2b3a4ef906654
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'D' => 
        array (
            'Ds\\' => 3,
            'Doublefou\\' => 10,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Ds\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-ds/php-ds/src',
        ),
        'Doublefou\\' => 
        array (
            0 => __DIR__ . '/..' . '/dfwp/doublefou',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit560139920bccdb938ec2b3a4ef906654::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit560139920bccdb938ec2b3a4ef906654::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}