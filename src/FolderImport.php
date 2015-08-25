<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 05.09.14
 * Time: 09:11
 * Migruje foldery assetów do pliku
 */

include(dirname(__FILE__) . "/../../pimcore/cli/startup.php");

$file = file_get_contents(dirname(__FILE__) . "folders/list.txt");
if($file) {
    $folderList = json_decode($file);
    foreach($folderList as $folder) {
        $newFolder = new Asset_Folder();
        $newFolder->setParent(Asset_Folder::getByPath($folder->parent));
        $newFolder->setFilename($folder->key);

        try {
            $newFolder->save();
        } catch (Exception $e) {
            echo $folder->parent."/".$folder->key.": already exists\n";
        }

    }
}
