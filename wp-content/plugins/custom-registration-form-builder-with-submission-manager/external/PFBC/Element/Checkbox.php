<?php
class Element_Checkbox extends OptionElement {
	protected $_attributes = array("type" => "checkbox");
	protected $inline;
        
         public function jQueryDocumentReady(){
            if(isset($this->_attributes["rm_is_other_option"]) && $this->_attributes["rm_is_other_option"] == 1){
                echo <<<JS
            
                   
                   jQuery("input[name='{$this->_attributes['name']}']").change(function(){
                   var obj_op = jQuery("#{$this->_attributes['id']}_other_section");
                    if(jQuery(this).attr('id')=='{$this->_attributes["id"]}_other')
                    {
                        if(jQuery(this).prop('checked')){
                             obj_op.slideDown();
                             obj_op.children("input[type=text]").attr('disabled', false);
                            }
                        else{
                            obj_op.slideUp();
                            obj_op.children("input[type=text]").attr('disabled', true);
                        }  
                    } 
                    
                  
                 });
                 
                jQuery('#{$this->_attributes["id"]}_other_input').change(function(){
                    jQuery('#{$this->_attributes["id"]}_other').val(jQuery(this).val());
                }) ; 
               
JS;
            }
              
             
        }
        
	public function render() { 
		if(isset($this->_attributes["value"])) {
			if(!is_array($this->_attributes["value"]))
				$this->_attributes["value"] = array($this->_attributes["value"]);
		}
		else
			$this->_attributes["value"] = array();

		if(substr($this->_attributes["name"], -2) != "[]")
			$this->_attributes["name"] .= "[]";

		$labelClass = 'rmradio';//'rm'. $this->_attributes["type"];
		if(!empty($this->inline))
			$labelClass .= " inline";

		$count = 0;//Extract color attribute so that can be applied to text as well.
                $style_str = "";
                if(isset($this->_attributes["style"]))
                {
                    $al = explode(';',$this->_attributes["style"]);                    
                    foreach($al as $a)
                    {
                        if(strpos(trim($a),"color:")=== 0)
                        {
                            $style_str ='style="'.$a.'";'; 
                            break;
                        }
                    }
                }
                echo '<ul class="' .$labelClass. '" '.$style_str.'">';
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);
                        
                        echo '<li> <input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked")), ' value="', $this->filter($value), '"';
			//echo '<label class="', $labelClass, '"> <input id="', $this->_attributes["id"], '-', $count, '"', $this->getAttributes(array("id", "value", "checked", "required")), ' value="', $this->filter($value), '"';
			if($value && in_array($value, $this->_attributes["value"]))
				echo ' checked="checked"';
			//echo '/> ', $text, ' </label> ';
			echo '/> ', $text, ' </li> ';
			++$count;
		}
                if(isset($this->_attributes["rm_is_other_option"]) && $this->_attributes["rm_is_other_option"] == 1){                        
                   echo '<li>'.
                        '<input type="checkbox" value="" id="'.$this->_attributes["id"].'_other" name="'.$this->getAttribute("name").'" style="'.$this->getAttribute("style").'">Other</li>'.
                        '<li id="'.$this->_attributes["id"].'_other_section" style="display:none">'.
                        '<input style="'.$this->getAttribute("style").'" type="text" id="'.$this->_attributes["id"].'_other_input" disabled>'.
                        '</li>';
                }
                    echo '</ul>';
	}
}
