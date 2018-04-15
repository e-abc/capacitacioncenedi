<?php

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
global $PAGE, $OUTPUT, $DB;

admin_externalpage_setup('test');

echo $OUTPUT->header();

$config = get_config('local_example', 'config');

$user = $DB->get_record('user', array('id' => 1));

var_dump($user);

echo $config;

echo $OUTPUT->footer();