<?php

spl_autoload_register(function($class) {
    $classPath = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    require_once($classPath);
});
