<?php

class managercenedi extends \core_user\output\myprofile\manager {
    /**
     * Parse all callbacks and builds the tree.
     *
     * @param integer   $user ID of the user for which the profile is displayed.
     * @param bool      $iscurrentuser true if the profile being viewed is of current user, else false.
     * @param \stdClass $course Course object
     *
     * @return tree Fully build tree to be rendered on my profile page.
     */
    public static function build_tree($user, $iscurrentuser, $course = null) {
        global $CFG;
        $tree = new \core_user\output\myprofile\tree();

        // Add core nodes.

        require_once($CFG->dirroot."/theme/cursoscenedi33/myprofilelib.php");
        core_myprofile_navigation_cenedi($tree, $user, $iscurrentuser, $course);

        // Core components.
        $components = \core_component::get_core_subsystems();
        foreach ($components as $component => $directory) {
            if (empty($directory)) {
                continue;
            }
            $file = $directory . "/lib.php";
            if (is_readable($file)) {
                require_once($file);
                $function = "core_" . $component . "_myprofile_navigation";
                if (function_exists($function)) {
                    $function($tree, $user, $iscurrentuser, $course);
                }
            }
        }

        // Plugins.
        $pluginswithfunction = get_plugins_with_function('myprofile_navigation', 'lib.php');
        foreach ($pluginswithfunction as $plugins) {
            foreach ($plugins as $function) {
                $function($tree, $user, $iscurrentuser, $course);
            }
        }

        $tree->sort_categories();
        return $tree;
    }
}