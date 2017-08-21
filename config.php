<?php

use Portal\Tools\App;

/*
* Inserting file paths into DI container.
*/

//env
App::add('file_editor', file_exists('C:\\Program Files (x86)\\Notepad++\\notepad++.exe') ? 'C:\\Program Files (x86)\\Notepad++\\notepad++.exe' : 'C:\\Windows\\notepad.exe');
App::add('ssms', 'C:\\Program Files (x86)\\Microsoft SQL Server\\140\\Tools\\Binn\\ManagementStudio\\Ssms.exe');

//portal
App::add('portal_view_path', 'D:/Development/Portal/developer-tool/build-view/build.ps1');
App::add('database_restore_path', 'D:/Development/Portal/portal-service/test/database/orange');
