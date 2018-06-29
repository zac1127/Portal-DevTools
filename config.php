<?php

use Portal\Tools\App;

/*
* Inserting file paths into DI container.
*/

//env
App::add('file_editor', file_exists('C:\\Program Files (x86)\\Notepad++\\notepad++.exe') ? 'C:\\Program Files (x86)\\Notepad++\\notepad++.exe' : 'C:\\Windows\\notepad.exe');
App::add('ssms', 'C:\\Program Files (x86)\\Microsoft SQL Server\\140\\Tools\\Binn\\ManagementStudio\\Ssms.exe');

//portal
App::add('database_prefix', 'orange');
App::add('build_view_path', 'D:/Development/Portal/developer-tools/build-view/build.ps1');
App::add('database_restore_path', 'D:/Development/Portal/portal-service/test/database/orange');
App::add('portal_view_path', 'D:/Development/Portal/portal-view');
App::add('portal_service_path', 'D:/Development/Portal/portal-service');
App::add('portal_service_logs', 'D:/Logs/Mattersight Portal Service/PHP/PHP_errors.log');
App::add('redis', 'C:/Program Files/Mattersight/Mattersight Portal Service Redis');
App::add('az_database_path', 'D:/Development/Portal/component-az-service-db/database/src/AzServiceDatabase/bin/Debug');
App::add('user_database_path', 'D:/Development/Portal/component-user-service-db/database/src/MattersightUserServiceDatabaseTest/bin/Debug');
App::add('wam_database_path', 'D:/Development/Portal/component-wam-service-db/database/src/Mattersight.Portal.WamServiceDatabaseTest/bin/Debug');