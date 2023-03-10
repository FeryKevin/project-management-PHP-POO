<?php

class Autoloader{
    public static function register(){
        spl_autoload_register(function ($class){
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';

            if (!str_contains($file, '\\App\\') && str_contains($file, 'App\\')) $file = str_replace("App", 'src', $file);

            if (file_exists($file)){
                require $file;
                return true;
            }else{
                require '../'.$file;
            }
            return false;
        });
    }
}

Autoloader::register();