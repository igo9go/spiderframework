<?php


class AutoloaderInit
{
    private static $loader;

    public static function loadClassLoader($class)
    {

        set_include_path(
            join(
                PATH_SEPARATOR,
                array(
                    get_include_path(),
                    FRAMEWORK_ROOT.'/library',
                    FRAMEWORK_ROOT.'/core',
                )
            )
        );

        $file = $class . '.php';
        require($file);
//        die(print_r(get_include_path()));
//        $file = $class . '.php';
//        if (is_file($file)) {
//            require($file);
//        }
    }

    public static function getLoader()
    {
//        if (null !== self::$loader) {
//            return self::$loader;
//        }

        spl_autoload_register(['AutoloaderInit','loadClassLoader']);
    }
}


return AutoloaderInit::getLoader();
