<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings configuration for admin setting section
 * @package    theme_cursoscenedi33
 * @copyright  2015 onwards LMSACE Dev Team (http://www.lmsace.com)
 * @author    LMSACE Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if (is_siteadmin()) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingcursoscenedi33', get_string('configtitle', 'theme_cursoscenedi33'));
    $ADMIN->add('themes', new admin_category('theme_cursoscenedi33', 'cursoscenedi33'));

    /* Header Settings */
    $temp = new admin_settingpage('theme_cursoscenedi33_header', get_string('headerheading', 'theme_cursoscenedi33'));

    // Logo file setting.
    $name = 'theme_cursoscenedi33/logo';
    $title = get_string('logo', 'theme_cursoscenedi33');
    $description = get_string('logodesc', 'theme_cursoscenedi33');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom CSS file.
    $name = 'theme_cursoscenedi33/customcss';
    $title = get_string('customcss', 'theme_cursoscenedi33');
    $description = get_string('customcssdesc', 'theme_cursoscenedi33');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    $settings->add($temp);

    /* Slideshow Settings Start */
    $temp = new admin_settingpage('theme_cursoscenedi33_slideshow', get_string('slideshowheading', 'theme_cursoscenedi33'));
    $temp->add(new admin_setting_heading('theme_cursoscenedi33_slideshow', get_string('slideshowheadingsub', 'theme_cursoscenedi33'),
    format_text(get_string('slideshowdesc', 'theme_cursoscenedi33'), FORMAT_MARKDOWN)));

    // Display Slideshow.
    $name = 'theme_cursoscenedi33/toggleslideshow';
    $title = get_string('toggleslideshow', 'theme_cursoscenedi33');
    $description = get_string('toggleslideshowdesc', 'theme_cursoscenedi33');
    $yes = get_string('yes');
    $no = get_string('no');
    $default = 1;
    $choices = array(1 => $yes , 0 => $no);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    // Number of slides.
    $name = 'theme_cursoscenedi33/numberofslides';
    $title = get_string('numberofslides', 'theme_cursoscenedi33');
    $description = get_string('numberofslides_desc', 'theme_cursoscenedi33');
    $default = 3;
    $choices = array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
    );
    $temp->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Slideshow settings.
    $numberofslides = get_config('theme_cursoscenedi33', 'numberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {

        // This is the descriptor for Slide One.
        $name = 'theme_cursoscenedi33/slide' . $i . 'info';
        $heading = get_string('slideno', 'theme_cursoscenedi33', array('slide' => $i));
        $information = get_string('slidenodesc', 'theme_cursoscenedi33', array('slide' => $i));
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // Slide Image.
        $name = 'theme_cursoscenedi33/slide' . $i . 'image';
        $title = get_string('slideimage', 'theme_cursoscenedi33');
        $description = get_string('slideimagedesc', 'theme_cursoscenedi33');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide' . $i . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Slide Caption.
        $name = 'theme_cursoscenedi33/slide' . $i . 'caption';
        $title = get_string('slidecaption', 'theme_cursoscenedi33');
        $description = get_string('slidecaptiondesc', 'theme_cursoscenedi33');
        $default = get_string('slidecaptiondefault', 'theme_cursoscenedi33', array('slideno' => sprintf('%02d', $i) ));
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
        $temp->add($setting);

        // Slide Description Text.
        $name = 'theme_cursoscenedi33/slide' . $i . 'desc';
        $title = get_string('slidedesc', 'theme_cursoscenedi33');
        $description = get_string('slidedesctext', 'theme_cursoscenedi33');
        $default = get_string('slidedescdefault', 'theme_cursoscenedi33');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $temp->add($setting);
    }
    $settings->add($temp);

    /* Slideshow Settings End*/

    /* Featured Courses Settings start - new tab */
    $temp = new admin_settingpage('theme_cursoscenedi33_featuredcourses', get_string('headingfeaturedcourses', 'theme_cursoscenedi33'));
    
    // Courses that display
    
    //general activate 
    $name = 'theme_cursoscenedi33/enable';
    $title = get_string('enable', 'theme_cursoscenedi33');
    $description = get_string('enabledesc', 'theme_cursoscenedi33');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $temp->add($setting);
    
    //type options
    $name = 'theme_cursoscenedi33/typefcourses';
    $title = get_string('typefcourses', 'theme_cursoscenedi33');
    $description = get_string('typefcoursesdesc', 'theme_cursoscenedi33');
    //options
    $myselection = get_string('myselection','theme_cursoscenedi33');
    $morevisited = get_string('morevisited','theme_cursoscenedi33');
    $moreuserenrol = get_string('moreuserenrol','theme_cursoscenedi33');
    $tagedcourses = get_string('tagedcourses','theme_cursoscenedi33');
    
    $default = 1;
    $choices = array(1 => $moreuserenrol , 2 => $morevisited , 3 => $myselection, 4 => $tagedcourses);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);
  
    //selection
    $name = 'theme_cursoscenedi33/selection';
    $title = get_string('selection', 'theme_cursoscenedi33');
    $description = get_string('selectiondesc', 'theme_cursoscenedi33');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $temp->add($setting);
    //$settings->add($temp);
    
    //tag courses
    $name = 'theme_cursoscenedi33/tagcourses';
    $title = get_string('tagedcourses', 'theme_cursoscenedi33');
    $description = get_string('tagedcoursesdesc', 'theme_cursoscenedi33');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);
    //$settings->add($temp);
    
    // how many courses to show
    $name = 'theme_cursoscenedi33/howmanyfcourses';
    $title = get_string('howmanyfcourses', 'theme_cursoscenedi33');
    $description = get_string('howmanyfcoursesdesc', 'theme_cursoscenedi33');
    $choices = array();
    $default = 3;
    for ($i = $default; $i <= 20; $i++) {
        $choices[$i] = $i;
    }
    //$choices = array(1 => $moreuserenrol , 2 => $morevisited , 3 => $myselection);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);
    $settings->add($temp);
    
    /* Featured Courses Settings end */


    /* Footer Settings start */
    $temp = new admin_settingpage('theme_cursoscenedi33_footer', get_string('footerheading', 'theme_cursoscenedi33'));

    /* Enable and Disable footer logo */
    $name = 'theme_cursoscenedi33/footlogo';
    $title = get_string('enable', 'theme_cursoscenedi33');
    $description = '';
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $temp->add($setting);

    /* Footer Content */
    $name = 'theme_cursoscenedi33/footnote';
    $title = get_string('footnote', 'theme_cursoscenedi33');
    $description = get_string('footnotedesc', 'theme_cursoscenedi33');
    $default = get_string('footnotedefault', 'theme_cursoscenedi33');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // INFO Link.
    $name = 'theme_cursoscenedi33/infolink';
    $title = get_string('infolink', 'theme_cursoscenedi33');
    $description = get_string('infolink_desc', 'theme_cursoscenedi33');
    $default = get_string('infolinkdefault', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $temp->add($setting);

    // Copyright.
    $name = 'theme_cursoscenedi33/copyright_footer';
    $title = get_string('copyright_footer', 'theme_cursoscenedi33');
    $description = '';
    $default = get_string('copyright_default', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    /* Address , Email , Phone No */
    $name = 'theme_cursoscenedi33/address';
    $title = get_string('address', 'theme_cursoscenedi33');
    $description = '';
    $default = get_string('defaultaddress', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_cursoscenedi33/emailid';
    $title = get_string('emailid', 'theme_cursoscenedi33');
    $description = '';
    $default = get_string('defaultemailid', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_cursoscenedi33/phoneno';
    $title = get_string('phoneno', 'theme_cursoscenedi33');
    $description = '';
    $default = get_string('defaultphoneno', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    /* Facebook, Pinterest, Twitter, Google+ Settings */
    $name = 'theme_cursoscenedi33/fburl';
    $title = get_string('fburl', 'theme_cursoscenedi33');
    $description = get_string('fburldesc', 'theme_cursoscenedi33');
    $default = get_string('fburl_default', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_cursoscenedi33/pinurl';
    $title = get_string('pinurl', 'theme_cursoscenedi33');
    $description = get_string('pinurldesc', 'theme_cursoscenedi33');
    $default = get_string('pinurl_default', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_cursoscenedi33/twurl';
    $title = get_string('twurl', 'theme_cursoscenedi33');
    $description = get_string('twurldesc', 'theme_cursoscenedi33');
    $default = get_string('twurl_default', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_cursoscenedi33/gpurl';
    $title = get_string('gpurl', 'theme_cursoscenedi33');
    $description = get_string('gpurldesc', 'theme_cursoscenedi33');
    $default = get_string('gpurl_default', 'theme_cursoscenedi33');
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $settings->add($temp);
     /*  Footer Settings end */
}
