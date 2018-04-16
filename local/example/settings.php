<?php

$externalpage = new admin_externalpage('test', 'Enlace local example', $CFG->wwwroot.'/local/example/view.php', 'local/example:viewexample');

$ADMIN->add('frontpage', $externalpage);

if ($hassiteconfig) {

    $settings = new admin_settingpage('local_example', 'Configuración local example');
 
	// Create 
    $ADMIN->add('localplugins', $settings);
 
	// Add a setting field to the settings for this page
    $settings->add(new admin_setting_configtext(
 
		// This is the reference you will use to your configuration
        'local_example/config',
 
		// This is the friendly title for the config, which will be displayed
        'nombre',
 
		// This is helper text for this config field
        'ayuda nombre',
 
		// This is the default value
        'default value nombre',
 
		// This is the type of Parameter this config is
        PARAM_TEXT

    ));

}