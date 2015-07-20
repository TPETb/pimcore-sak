<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 05.09.14
 * Time: 09:11
 */

include(dirname(__FILE__) . "/../../pimcore/cli/startup.php");


// MIGRACJA KOLEKCJI

$classesList = new Object_Fieldcollection_Definition_List();
$classes = $classesList->load();

$classes_array = array(); // array of existing collections

/** @var Object_Fieldcollection_Definition $class */
foreach($classes as $class)
    $classes_array[ $class->getKey() ] = true;

$files = glob('extra/fieldcollections/*'); // get all file names

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

$files = glob('extra/classes/*'); // get all file names

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
