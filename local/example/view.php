<?php

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
global $PAGE, $OUTPUT;

admin_externalpage_setup('test');

echo $OUTPUT->header();

echo 'hola mundo';

echo $OUTPUT->footer();