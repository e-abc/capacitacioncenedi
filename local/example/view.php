<?php

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
global $PAGE, $OUTPUT;

admin_externalpage_setup('test');

echo $OUTPUT->header();

$config = get_config('local_example', 'config');

echo $config;

echo $OUTPUT->footer();