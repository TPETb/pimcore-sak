<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 05.09.14
 * Time: 09:11
 * Migruje foldery assetów do pliku
 */
include(dirname(__FILE__) . "/../../../../pimcore/cli/startup.php");


function getFolderList(Asset_Folder $rootFolder, &$folderList = array()) {

    if($rootFolder->getParent()) {
        $folderList[] = array(
            "parent"    => $rootFolder->getParent()->getFullPath(),
            "key"       => $rootFolder->getKey()
        );
    }

    foreach($rootFolder->getChilds() as $childFolder) {

        if($childFolder instanceof Asset_Folder) {
            getFolderList($childFolder, $folderList);
        }

    }

}

$rootFolder = Asset_Folder::getByPath("/");

$folderList = array();
getFolderList($rootFolder, $folderList);

$file = fopen("folders/list.txt", "w");
fwrite($file, json_encode($folderList));
echo "Done\n";

