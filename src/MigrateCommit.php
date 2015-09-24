<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 05.09.14
 * Time: 09:11
 */

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


$classesList = new Object_Class_List();
$classesList->setOrderKey("name");
$classesList->setOrder("asc");
$classes = $classesList->load();

$files = glob(PIMCORE_DOCUMENT_ROOT . '/data/classes/*'); // get all file names
foreach($files as $file){ // iterate files
    if(is_file($file))
        unlink($file); // delete file
}

/** @var Object_Class $class */
foreach($classes as $class) {
    $json = Object_Class_Service::generateClassDefinitionJson($class);
    $handle = fopen(PIMCORE_DOCUMENT_ROOT . '/data/classes/'.$class->getName().'.json', 'w');
    fwrite($handle, $json);
    fclose($handle);
}

$classesList = new Object_Fieldcollection_Definition_List();
$classes = $classesList->load();

$files = glob(PIMCORE_DOCUMENT_ROOT . '/data/fieldcollections/*'); // get all file names
foreach($files as $file){ // iterate files
    if(is_file($file))
        unlink($file); // delete file
}

/** @var Object_Fieldcollection_Definition $class */
foreach($classes as $class) {
    $key = $class->getKey();
    $json = Object_Class_Service::generateFieldCollectionJson($class);

    $handle = fopen(PIMCORE_DOCUMENT_ROOT . '/data/fieldcollections/'.$key.'.json', 'w');
    fwrite($handle, $json);
    fclose($handle);
}

$classesList = new Object_Objectbrick_Definition_List();
$classes = $classesList->load();

$files = glob(PIMCORE_DOCUMENT_ROOT . '/data/objectbricks/*'); // get all file names
foreach($files as $file){ // iterate files
    if(is_file($file))
        unlink($file); // delete file
}

/** @var Object_Objectbrick_Definition $class */
foreach($classes as $class) {
    $key = $class->getKey();
    $json = Object_Class_Service::generateObjectbrickJson($class);

    $handle = fopen(PIMCORE_DOCUMENT_ROOT . '/data/objectbricks/'.$key.'.json', 'w');
    fwrite($handle, $json);
    fclose($handle);
}

