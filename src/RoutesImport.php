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

if (!file_exists(PIMCORE_DOCUMENT_ROOT . '/data/routes.json')) {
    echo 'No rotes export file found';
    exit(1);
}

// Clean current routes
$routes = new Pimcore\Model\Staticroute\Listing();
foreach ($routes->load() as $route) {
    $route->delete();
}

$routesJson = json_decode(file_get_contents(PIMCORE_DOCUMENT_ROOT . '/data/routes.json'), true);
foreach ($routesJson as $routeJson) {
    $route = new \Pimcore\Model\Staticroute();
    $route->setValues($routeJson);
    $route->save();
}