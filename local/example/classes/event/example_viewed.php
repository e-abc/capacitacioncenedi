<?php

namespace local_example\event;

class example_viewed extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    public function get_description() {
        return 'usuario vio la página de local example';
    }

    public static function get_name() {
        return 'example plugin visto';
    }

    public function get_url() {
        return new \moodle_url('/local/example/view.php');
    }
}