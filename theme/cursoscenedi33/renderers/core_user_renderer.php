<?php

defined('MOODLE_INTERNAL') || die();

class theme_cursoscenedi33_core_user_myprofile_renderer extends core_user\output\myprofile\renderer {

	public function render_category(core_user\output\myprofile\category $category) {
        $classes = $category->classes;

        if($category->name == "miscellaneous" or $category->name == "reports"){
        	return '';
        }


        if (empty($classes)) {
            $return = \html_writer::start_tag('section', array('class' => 'node_category'));
        } else {
            $return = \html_writer::start_tag('section', array('class' => 'node_category ' . $classes));
        }
        $return .= \html_writer::tag('h3', $category->title);
        $nodes = $category->nodes;
        if (empty($nodes)) {
            // No nodes, nothing to render.
            return '';
        }
        $return .= \html_writer::start_tag('ul');
        foreach ($nodes as $node) {
            $return .= $this->render($node);
        }
        $return .= \html_writer::end_tag('ul');
        $return .= \html_writer::end_tag('section');
        return $return;
    }
}