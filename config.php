<?php

use Portal\Tools\App;

/*
* Inserting file paths into DI container.
*/
App::add('portal_view_path', 'D:/Development/Portal/developer-tool/build-view/build.ps1');
App::add('database_restore_path', 'D:/Development/Portal/portal-service/test/database/orange');
App::add('file_editor', file_exists('C:/Program Files (x86)/Notepad++') ? 'C:/Program Files (x86)/Notepad++' : 'C:/Windows/notepad.exe');