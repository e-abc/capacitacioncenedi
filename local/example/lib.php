<?php

function local_example_extend_navigation(global_navigation $navigation) {   
    
    $url = new moodle_url('/local/example/view.php');
    $node = navigation_node::create(
        get_string('pluginname', 'local_example'),
        $url,
        navigation_node::TYPE_SETTING,
        null,
        null,
        new pix_icon('i/settings', '')
    );
    $node->showinflatnavigation = true;
    $node->classes = array('localexample');
    $node->key = 'localexample';

    if (isset($node)) {
        $navigation->add_node($node);
    }
    
}