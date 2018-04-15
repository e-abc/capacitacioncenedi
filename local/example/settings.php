<?php

$externalpage = new admin_externalpage('test', 'Enlace local example', $CFG->wwwroot.'/local/example/view.php');

$ADMIN->add('frontpage', $externalpage);