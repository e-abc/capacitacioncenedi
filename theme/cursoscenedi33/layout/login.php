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
 * Login Layout
 * @package    theme_cursoscenedi33
 * @copyright  2015 onwards LMSACE Dev Team (http://www.lmsace.com)
 * @author    LMSACE Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes();
require_once(dirname(__FILE__) .'/includes/header.php');
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes
];


    // Theme bootstrap carousel js files are added into moodle.
    $PAGE->requires->js('/theme/cursoscenedi33/javascript/bootstrap-carousel.js');
    $PAGE->requires->js('/theme/cursoscenedi33/javascript/bootstrap-transition.js');
?>
<!--=========== Slideshow section start here ===========-->
<div>
<?php
    $toggleslideshow = theme_cursoscenedi33_get_setting('toggleslideshow');
if ($toggleslideshow == 1) {
    require_once(dirname(__FILE__) . '/includes/slideshow.php');
} else {
    echo "<br/><br/>";
}
?>
</div>
<!--=========== Slideshow section start here ===========-->
<!--Slider-->

<?php
echo $OUTPUT->render_from_template('theme_cursoscenedi33/login', $templatecontext);
echo ($flatnavbar) ? $flatnavbar : "";
require_once(dirname(__FILE__) .'/includes/footer.php');