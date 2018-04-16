<?php

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
global $PAGE, $OUTPUT, $DB, $USER;

admin_externalpage_setup('test');

echo $OUTPUT->header();

$renderer = $PAGE->get_renderer('local_example');

$config = get_config('local_example', 'config');

$user = $DB->get_record('user', array('id' => 3));

echo $renderer->print_hello($user);

$PAGE->requires->js_call_amd('local_example/index', 'init', array('pais' => 'Argentina'));

echo $config;

$event = \local_example\event\example_viewed::create(
    array(
        'context' => context_system::instance(),
        'relateduserid' => $USER->id
    )
);
$event->trigger();

echo $OUTPUT->footer();