<?php
/**
 * Created by PhpStorm.
 * User: jplaskonka
 * Date: 15.07.15
 * Time: 14:51
 */

include(dirname(__FILE__) . "/../../pimcore/cli/startup.php");

$tables = array(
    'users',
    'users_permission_definitions',
    'users_workspaces_asset',
    'users_workspaces_document',
    'users_workspaces_object'
);

$fileName = dirname(__FILE__)."/users/users.sql";

$config = new Zend_Config_Xml(PIMCORE_CONFIGURATION_SYSTEM, 'database');
$username = $config->params->username;
$host = $config->params->host;
$password = $config->params->password;
$dbName = $config->params->dbname;

if(strlen($password) > 0) {
    $password = "-p".$password;
}

shell_exec("mysql -u $username $password -h $host $dbName < $fileName");    