<?php

include(dirname(__FILE__) . "/../../../../pimcore/cli/startup.php");

// todo move to composer's post install scripts
if (!is_dir(PIMCORE_DOCUMENT_ROOT . '/data')) {
    mkdir(PIMCORE_DOCUMENT_ROOT . '/data');
}
if (!is_dir(PIMCORE_DOCUMENT_ROOT . '/data/classes')) {
    mkdir(PIMCORE_DOCUMENT_ROOT . '/data/classes');
}
if (!is_dir(PIMCORE_DOCUMENT_ROOT . '/data/fieldcollections')) {
    mkdir(PIMCORE_DOCUMENT_ROOT . '/data/fieldcollections');
}
if (!is_dir(PIMCORE_DOCUMENT_ROOT . '/data/objectbricks')) {
    mkdir(PIMCORE_DOCUMENT_ROOT . '/data/objectbricks');
}


$routesJson = [];

$routes = new Pimcore\Model\Staticroute\Listing();
foreach ($routes->load() as $route) {
    $routesJson[] = [
        'name' => $route->getName(),
        'pattern' => $route->getPattern(),
        'reverse' => $route->getReverse(),
        'module' => $route->getModule(),
        'controller' => $route->getController(),
        'action' => $route->getAction(),
        'variables' => $route->getVariables(),
        'defaults' => $route->getDefaults(),
        'priority' => $route->getPriority()
    ];
}

$file = fopen(PIMCORE_DOCUMENT_ROOT . '/data/routes.json', 'w');
fwrite($file, json_encode($routesJson));