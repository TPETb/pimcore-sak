<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 05.09.14
 * Time: 09:11
 */

include(dirname(__FILE__) . "/../../pimcore/cli/startup.php");

$classesList = new Object_Class_List();
$classesList->setOrderKey("name");
$classesList->setOrder("asc");
$classes = $classesList->load();

$files = glob('extra/classes/*'); // get all file names
foreach($files as $file){ // iterate files
    if(is_file($file))
        unlink($file); // delete file
}

/** @var Object_Class $class */
foreach($classes as $class) {
    $json = Object_Class_Service::generateClassDefinitionJson($class);
    $handle = fopen('extra/classes/'.$class->getName().'.json', 'w');
    fwrite($handle, $json);
    fclose($handle);
}

$classesList = new Object_Fieldcollection_Definition_List();
$classes = $classesList->load();

$files = glob('extra/fieldcollections/*'); // get all file names
foreach($files as $file){ // iterate files
    if(is_file($file))
        unlink($file); // delete file
}

/** @var Object_Fieldcollection_Definition $class */
foreach($classes as $class) {
    $key = $class->getKey();
    $json = Object_Class_Service::generateFieldCollectionJson($class);

    $handle = fopen('extra/fieldcollections/'.$key.'.json', 'w');
    fwrite($handle, $json);
    fclose($handle);
}