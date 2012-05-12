<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$vendorDir = __DIR__.'/../../../../vendor';
$loader = require_once $vendorDir.'/autoload.php';

// intl
if (!function_exists('intl_get_error_code')) {
    require_once $vendorDir.'/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
    $loader->add(null, $vendorDir.'/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs');
}

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile($vendorDir.'/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
