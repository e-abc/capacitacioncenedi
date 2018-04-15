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
 * Frontpage Layout.
 * @package    theme_cursoscenedi33
 * @copyright  2015 onwards LMSACE Dev Team (http://www.lmsace.com)
 * @author    LMSACE Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

// Get the HTML for the settings bits.
$html = theme_cursoscenedi33_get_html_for_settings($OUTPUT, $PAGE);
if (right_to_left()) {
    $regionbsid = 'region-bs-main-and-post';
} else {
    $regionbsid = 'region-bs-main-and-pre';
}
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<?php
    // Header file included.
    require_once(dirname(__FILE__) . '/includes/header.php');
?>


<!-- Main Moodle Main Contents -->
<div id="page" class="container">

    <div class="container contactcenedi">
        <h4>Atención a alumnos</h4>
        <li class="cenedilist"><i class="fa fa-comments" aria-hidden="true"><span class="contactceneditext">Para contactarte por chat, click <a href="http://cenedi.com/atencion-al-alumno" target="_blank">aquí</a></span></i></li>
        <li class="cenedilist"><i class="fa fa-envelope " aria-hidden="true"><span class="contactceneditext">Por mail a:  <a href="mailto:alumnos@cenedi.com">alumnos@cenedi.com</a></span></i></li>
    </div>
    <div class="container contactcenedi">
        <h4>Tutorías</h4>
        <li class="cenedilist"><i class="fa fa-headphones" aria-hidden="true"><span class="contactceneditext">Por consultas a profesores relacionadas con el contenido del curso, click <a href="http://tutorias.cenedi.com/" target="_blank" >aquí</a></span></i></li>
    </div>
    <header id="page-header" class="clearfix">
        <?php echo $html->heading; ?>
        <div id="page-navbar" class="clearfix">
            <nav class="breadcrumb-nav" style="padding: 10px 0px 10px 20px;"><?php echo $OUTPUT->navbar(); ?></nav>
            <div style="height: auto; width: 100%; text-align: right; border: 1px solid #e1e1e1; padding: 10px; background: #ffffff; margin-bottom: 10px;">
            <a href="#" class="toogle-list-courses">
                <img src="/theme/cursoscenedi33/pix/bt_home_01.jpg" />
            </a>
            </div>
            <div class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></div>
        </div>
        <div id="course-header">
            <?php echo $OUTPUT->course_header(); ?>
        </div>
    </header>


    <div id="page-content" class="">

    <?php
    if (!empty($OUTPUT->blocks_for_region('side-pre'))) {
        $class = "col-md-9";
    } else {
        $class = "col-md-12";
    }
    ?>

    <div id="<?php echo $regionbsid ?>" class="<?php echo $class; ?>">
        <?php
                echo $OUTPUT->course_content_header();
                echo $OUTPUT->main_content();
                echo $OUTPUT->course_content_footer();
        ?>
    </div>
    <?php echo $OUTPUT->blocks('side-pre', 'col-md-3'); ?>
    </div>
    <?php echo (!empty($flatnavbar)) ? $flatnavbar : ""; ?>
</div>
<?php  require_once(dirname(__FILE__) . '/includes/footer.php');  ?>
</body>
</html>
