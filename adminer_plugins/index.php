<?php
require './vendor/autoload.php';

function adminer_object()
{
    require_once('./plugins/database-hide.php');
    require_once('./plugins/oneclick-login.php');
    require_once('./AdminerBootstrapLike.php');


    $plugins = [];
    foreach (glob("plugins-enabled/*.php") as $filename) {
        include_once "./$filename";
    }
    $plugins = [
        new AdminerDatabaseHide([
            'mysql',
            'information_schema',
            'performance_schema',
            'sys',
        ]),
        new AdminerEditForeign(),
        new AdminerEnumOption(),
        new AdminerSqlLog(),
        new AdminerEditCalendar(),
        new AdminerEditTextarea(),
        new OneClickLogin(include 'server.php'),
        new AdminerTableStructure(),
        new AdminerTableIndexesStructure(),
        new AdminerTablesFilter(),
        new AdminerDumpJson(),
        new AdminerLoginPasswordLess("Megaron08")
    ];

    return new AdminerPlugin($plugins);
}
include './adminer.php';
