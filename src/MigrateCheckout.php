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

// MIGRACJA KOLEKCJI

$classesList = new Object_Fieldcollection_Definition_List();
$classes = $classesList->load();

$classes_array = array(); // array of existing collections

/** @var Object_Fieldcollection_Definition $class */
foreach($classes as $class)
    $classes_array[ $class->getKey() ] = true;

$files = glob(PIMCORE_DOCUMENT_ROOT . '/data/fieldcollections/*'); // get all file names

// tworzenie kolekcji na podstawie plików
foreach($files as $file){ // iterate files
    if(is_file($file)) {
        $string = file_get_contents($file);
        $classname = basename($file, ".json");
        unset( $classes_array[$classname] );
        try {
            $class = Object_Fieldcollection_Definition::getByKey($classname);
            Object_Class_Service::importFieldCollectionFromJson($class, $string);
        } catch (Exception $e) {
            $newClass = new Object_Fieldcollection_Definition();
            $newClass->setKey($classname);
            Object_Class_Service::importFieldCollectionFromJson($newClass, $string);
        }
    }
}

// usuwanie kolekcji
/** @var Object_Fieldcollection_Definition $class */
foreach( $classes_array as $classname => $tmp ) {
    $class = Object_Fieldcollection_Definition::getByKey($classname);
    $class->delete();
    echo "Delete collection: " . $classname . "\n";
}

// MIGRACJA KLAS

$classesList = new Object_Class_List();
$classesList->setOrderKey("name");
$classesList->setOrder("asc");
$classes = $classesList->load();

$classes_array = array(); // array of existing classes

/** @var Object_Class $class */
foreach($classes as $class)
    $classes_array[ $class->getName() ] = true;

$files = glob(PIMCORE_DOCUMENT_ROOT . '/data/classes/*'); // get all file names

// tworzenie klas na podstawie plików
foreach($files as $file){ // iterate files
    if(is_file($file)) {
        $string = file_get_contents($file);
        $classname =  basename($file, ".json");
        $class = Object_Class::getByName($classname);
        unset( $classes_array[$classname] );
        if($class)
            Object_Class_Service::importClassDefinitionFromJson($class, $string);
        else {
            $newClass = Object_Class::create(array(
                "name" => $classname
            ));
            Object_Class_Service::importClassDefinitionFromJson($newClass, $string);
        }
    }
}

// usuwanie klas
foreach( $classes_array as $classname => $tmp ) {
    $class = Object_Class::getByName($classname);
    $class->delete();
    echo "Delete class: " . $classname . "\n";
}


// Objectbricks migration

$classesList = new Object_Objectbrick_Definition_List();
$classes = $classesList->load();

$classes_array = array(); // array of existing collections

/** @var Object_Objectbrick_Definition $class */
foreach($classes as $class)
    $classes_array[ $class->getKey() ] = true;

$files = glob(PIMCORE_DOCUMENT_ROOT . '/data/objectbricks/*'); // get all file names

// tworzenie kolekcji na podstawie plików
foreach($files as $file){ // iterate files
    if(is_file($file)) {
        $string = file_get_contents($file);
        $classname = basename($file, ".json");
        unset( $classes_array[$classname] );
        try {
            $class = Object_Objectbrick_Definition::getByKey($classname);
            Object_Class_Service::importObjectbrickFromJson($class, $string);
        } catch (Exception $e) {
            $newClass = new Object_Objectbrick_Definition();
            $newClass->setKey($classname);
            Object_Class_Service::importObjectbrickFromJson($newClass, $string);
        }
    }
}

// usuwanie kolekcji
/** @var Object_Objectbrick_Definition $class */
foreach( $classes_array as $classname => $tmp ) {
    $class = Object_Objectbrick_Definition::getByKey($classname);
    $class->delete();
    echo "Delete objectbrick: " . $classname . "\n";
}