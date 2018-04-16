<?php

namespace local_example;

class utils {
    public static function example_observer(){
        global $PAGE;
        $PAGE->requires->js_call_amd('local_example/index', 'init', array('data' => 'example ejecutado'));
    }
}