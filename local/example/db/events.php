<?php
$observers = array( 
    array(
        'eventname'   => '\local_example\event\example_viewed',
        'callback'    => '\local_example\utils::example_observer',
        'priority'    => 200,
        'internal'    => false
    ) 
);
