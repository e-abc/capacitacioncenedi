<?php

namespace local_example\task;

class recordar_usuario extends \core\task\scheduled_task {
    public function get_name() {
        return 'tarea plugin example';
    }

    public function execute() {
        echo 'recordando usuario';
    }
}