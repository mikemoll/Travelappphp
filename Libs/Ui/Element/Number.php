<?php

class Ui_Element_Number extends Ui_Element_Text {

     /**
     *
     * @param string $id
     * @param string $label
     */
    public function __construct($id, $label = '') {
        parent::__construct($id, '');

        $this->type = 'number';
        $this->label = $label;
    }
}
