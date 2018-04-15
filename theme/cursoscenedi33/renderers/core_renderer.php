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
 * @package    theme_cursoscenedi33
 * @copyright  2015 onwards LMSACE Dev Team (http://www.lmsace.com)
 * @author    LMSACE Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * cursoscenedi33 core renderer renderer from the moodle core renderer
 * @copyright  2015 onwards LMSACE Dev Team (http://www.lmsace.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_cursoscenedi33_core_renderer extends theme_boost\output\core_renderer {
    /**
     * Custom menu in header.
     * @param custom_menu $menu
     * @return type
     */
    

    /**
     * Constructor
     *
     * @param moodle_page $page the page we are doing output for.
     * @param string $target one of rendering target constants
     */
    public function __construct(moodle_page $page, $target) {
        parent::__construct($page, $target);
        $this->themeconfig = array(\theme_config::load('cursoscenedi33'));
        $this->left = !\right_to_left();
    }


    public function custom_menu_render(custom_menu $menu) {
        global $CFG;

        $langs = get_string_manager()->get_list_of_translations();
        $haslangmenu = $this->lang_menu() != '';

        if (!$menu->has_children() && !$haslangmenu) {
            return '';
        }

        $content = '';
        foreach ($menu->get_children() as $item) {
            $context = $item->export_for_template($this);
            $content .= $this->render_from_template('theme_cursoscenedi33/custom_menu_item', $context);
        }

        return $content;
    }

    public function main_content(){
        global $DB,$CFG,$USER,$PAGE,$OUTPUT;
        $isprofile = strpos($_SERVER['REQUEST_URI'] , '/user/profile.php?id=');
        $iseditprofile = strpos($_SERVER['REQUEST_URI'] , '/theme/cursoscenedi33/editprofile.php?id=');
        if($isprofile !== false ){

            require_once(__DIR__ . '/../../../config.php');
            require_once($CFG->dirroot . '/my/lib.php');
            require_once($CFG->dirroot . '/user/profile/lib.php');
            require_once($CFG->dirroot . '/user/lib.php');
            require_once($CFG->libdir.'/filelib.php');

            $userid         = optional_param('id', 0, PARAM_INT);
            $edit           = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off.
            $reset          = optional_param('reset', null, PARAM_BOOL);

            $content = '';
            $this->unique_main_content_token = '';
            $this->unique_main_content_token = '<span id="maincontent"></span>';
            $content .= '<div role="main">'.$this->unique_main_content_token.'</div>';
            
            $content .= '
            <script>
            $( ".userprofile" ).remove();
            </script>

            ';
            
            
            $PAGE->set_url('/user/profile.php', array('id' => $userid));

            if (!empty($CFG->forceloginforprofiles)) {
                require_login();
                if (isguestuser()) {
                    $PAGE->set_context(context_system::instance());
                    echo $OUTPUT->header();
                    echo $OUTPUT->confirm(get_string('guestcantaccessprofiles', 'error'),
                                          get_login_url(),
                                          $CFG->wwwroot);
                    echo $OUTPUT->footer();
                    die;
                }
            } else if (!empty($CFG->forcelogin)) {
                require_login();
            }


            ////////////////////////////////////////////////////////////////////////
            // Codigo agregado para que genere la informacion del perfil de usuario 
            /*
            $content .= $OUTPUT->header();
            $content .= '<P>TEST e-ABC 1</P>';
            $content .= $OUTPUT->footer();
            */
           
            $userid = $userid ? $userid : $USER->id;       // Owner of the page.
            if ((!$user = $DB->get_record('user', array('id' => $userid))) || ($user->deleted)) {
                $PAGE->set_context(context_system::instance());
                $content .= $OUTPUT->header();
                if (!$user) {
                    $content .= $OUTPUT->notification(get_string('invaliduser', 'error'));
                } else {
                    $content .= $OUTPUT->notification(get_string('userdeleted'));
                }
                $content .= $OUTPUT->footer();
                die;
            }

            $currentuser = ($user->id == $USER->id);
            $context = $usercontext = context_user::instance($userid, MUST_EXIST);

            if (!user_can_view_profile($user, null, $context)) {

                // Course managers can be browsed at site level. If not forceloginforprofiles, allow access (bug #4366).
                $struser = get_string('user');
                $PAGE->set_context(context_system::instance());
                $PAGE->set_title("$SITE->shortname: $struser");  // Do not leak the name.
                $PAGE->set_heading($struser);
                $PAGE->set_pagelayout('mypublic');
                $PAGE->set_url('/user/profile.php', array('id' => $userid));
                $PAGE->navbar->add($struser);
                $content .= $OUTPUT->header();
                $content .= $OUTPUT->notification(get_string('usernotavailable', 'error'));
                $content .= $OUTPUT->footer();
                exit;
            }

            // Get the profile page.  Should always return something unless the database is broken.
            if (!$currentpage = my_get_page($userid, MY_PAGE_PUBLIC)) {
                print_error('mymoodlesetup');
            }

            $PAGE->set_context($context);
            $PAGE->set_pagelayout('mypublic');
            $PAGE->set_pagetype('user-profile');

            // Set up block editing capabilities.
            if (isguestuser()) {     // Guests can never edit their profile.
                $USER->editing = $edit = 0;  // Just in case.
                $PAGE->set_blocks_editing_capability('moodle/my:configsyspages');  // unlikely :).
            } else {
                if ($currentuser) {
                    $PAGE->set_blocks_editing_capability('moodle/user:manageownblocks');
                } else {
                    $PAGE->set_blocks_editing_capability('moodle/user:manageblocks');
                }
            }

            // Start setting up the page.
            $strpublicprofile = get_string('publicprofile');

            //$PAGE->blocks->add_region('content');
            $PAGE->set_subpage($currentpage->id);
            $PAGE->set_title(fullname($user).": $strpublicprofile");
            $PAGE->set_heading(fullname($user));

            if (!$currentuser) {
                $PAGE->navigation->extend_for_user($user);
                if ($node = $PAGE->settingsnav->get('userviewingsettings'.$user->id)) {
                    $node->forceopen = true;
                }
            } else if ($node = $PAGE->settingsnav->get('dashboard', navigation_node::TYPE_CONTAINER)) {
                $node->forceopen = true;
            }
            if ($node = $PAGE->settingsnav->get('root')) {
                $node->forceopen = false;
            }


            // Toggle the editing state and switches.
            if ($PAGE->user_allowed_editing()) {
                if ($reset !== null) {
                    if (!is_null($userid)) {
                        if (!$currentpage = my_reset_page($userid, MY_PAGE_PUBLIC, 'user-profile')) {
                            print_error('reseterror', 'my');
                        }
                        redirect(new moodle_url('/user/profile.php', array('id' => $userid)));
                    }
                } else if ($edit !== null) {             // Editing state was specified.
                    $USER->editing = $edit;       // Change editing state.
                } else {                          // Editing state is in session.
                    if ($currentpage->userid) {   // It's a page we can edit, so load from session.
                        if (!empty($USER->editing)) {
                            $edit = 1;
                        } else {
                            $edit = 0;
                        }
                    } else {
                        // For the page to display properly with the user context header the page blocks need to
                        // be copied over to the user context.
                        if (!$currentpage = my_copy_page($userid, MY_PAGE_PUBLIC, 'user-profile')) {
                            print_error('mymoodlesetup');
                        }
                        $PAGE->set_context($usercontext);
                        $PAGE->set_subpage($currentpage->id);
                        // It's a system page and they are not allowed to edit system pages.
                        $USER->editing = $edit = 0;          // Disable editing completely, just to be safe.
                    }
                }

                // Add button for editing page.
                $params = array('edit' => !$edit, 'id' => $userid);

                $resetbutton = '';
                $resetstring = get_string('resetpage', 'my');
                $reseturl = new moodle_url("$CFG->wwwroot/user/profile.php", array('edit' => 1, 'reset' => 1, 'id' => $userid));

                if (!$currentpage->userid) {
                    // Viewing a system page -- let the user customise it.
                    $editstring = get_string('updatemymoodleon');
                    $params['edit'] = 1;
                } else if (empty($edit)) {
                    $editstring = get_string('updatemymoodleon');
                    $resetbutton = $OUTPUT->single_button($reseturl, $resetstring);
                } else {
                    $editstring = get_string('updatemymoodleoff');
                    $resetbutton = $OUTPUT->single_button($reseturl, $resetstring);
                }

                $url = new moodle_url("$CFG->wwwroot/user/profile.php", $params);
                $button = $OUTPUT->single_button($url, $editstring);
                $PAGE->set_button($resetbutton . $button);

            } else {
                $USER->editing = $edit = 0;
            }

            // Trigger a user profile viewed event.
            profile_view($user, $usercontext);

            // TODO WORK OUT WHERE THE NAV BAR IS!
            //$content .= $OUTPUT->header();
            $content .= '<div class="userprofile">';

            if ($user->description && !isset($hiddenfields['description'])) {
                $content .= '<div class="description">';
                if (!empty($CFG->profilesforenrolledusersonly) && !$currentuser &&
                    !$DB->record_exists('role_assignments', array('userid' => $user->id))) {
                    $content .= get_string('profilenotshown', 'moodle');
                } else {
                    $user->description = file_rewrite_pluginfile_urls($user->description, 'pluginfile.php', $usercontext->id, 'user',
                                                                      'profile', null);
                    $content .= format_text($user->description, $user->descriptionformat);
                }
                $content .= '</div>';
            }

            $content .= $OUTPUT->custom_block_region('content');

            // Render custom blocks.
            $renderer = $PAGE->get_renderer('core_user', 'myprofile');
            //$tree = core_user\output\myprofile\manager::build_tree($user, $currentuser);

            require_once($CFG->dirroot.'/theme/cursoscenedi33/managercenedi.php');
            $tree = managercenedi::build_tree($user, $currentuser);

            /*
            echo "<pre>";
            //var_dump($tree->nodes['editprofile']->url);
            var_dump($tree->nodes);
            exit;
            echo "<pre>";
            $test = $tree->__get('nodes');
            var_dump($test);
            exit;

            $tree->nodes['editprofile']->url = '/theme/cursoscenedi33/editprofile.php';
            */

            $content .= $renderer->render($tree);

            $content .= '</div>';  // Userprofile class.

            //$content .= $OUTPUT->footer();
            return $content;
        }
        elseif($iseditprofile !== false ){
                $content = '';
                $content .= '<div role="main">'.$this->unique_main_content_token.'</div>';
                $content .= '
                <script>
                $( "#id_moodle_picture" ).remove();
                </script>
                ';
                return $content;
        }
        else{
            $content  = '';
            $content .= '<div role="main">'.$this->unique_main_content_token.'</div>';
            return $content;
        }
    }
}
