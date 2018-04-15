<?php

namespace local_example\output;

class renderer extends \renderer_base{
    public function print_hello() {
        $data = new \stdClass();
        $data->nombre = 'Daniel';
        $data->edad = 34;
        return $this->render_from_template('local_example/hello', $data);
    }
}