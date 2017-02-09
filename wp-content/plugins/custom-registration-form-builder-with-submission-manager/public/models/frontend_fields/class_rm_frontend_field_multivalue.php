<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RM_Frontend_Field_Multivalue extends RM_Frontend_Field_Base
{
    protected $field_value; //Choices from which user can select

    public function __construct($id, $type, $label, $options, $value, $page_no = 1, $is_primary = false, $extra_opts = null)
    {
        parent::__construct($id, $type, $label, $options, $page_no, $is_primary, $extra_opts);
        
        $this->field_value = $value;
    }
    
    public function get_pfbc_field()
    {
        if ($this->pfbc_field)
            return $this->pfbc_field;
        else
        {
            $class_name = "Element_" . $this->field_type;
            $label = $this->get_formatted_label();
            $this->pfbc_field = new $class_name($label, $this->field_name, $this->field_value, $this->field_options);            
            return $this->pfbc_field;
        }
    }
}
