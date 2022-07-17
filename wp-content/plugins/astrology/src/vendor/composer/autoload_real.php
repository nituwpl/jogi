<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit6a88b6845a58df8520cf6b713d0a8bfa
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Prokerala_WP_Astrology_Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Prokerala_WP_Astrology_Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit6a88b6845a58df8520cf6b713d0a8bfa', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Prokerala_WP_Astrology_Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit6a88b6845a58df8520cf6b713d0a8bfa', 'loadClassLoader'));

        $useStaticLoader = PHP_VERSION_ID >= 50600 && !defined('HHVM_VERSION') && (!function_exists('zend_loader_file_encoded') || !zend_loader_file_encoded());
        if ($useStaticLoader) {
            require_once __DIR__ . '/autoload_static.php';

            call_user_func(\Prokerala_WP_Astrology_Composer\Autoload\ComposerStaticInit6a88b6845a58df8520cf6b713d0a8bfa::getInitializer($loader));
        } else {
            $classMap = require __DIR__ . '/autoload_classmap.php';
            if ($classMap) {
                $loader->addClassMap($classMap);
            }
        }

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        return $loader;
    }
}
