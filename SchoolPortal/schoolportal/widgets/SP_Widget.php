<?php

/**
  Plugin Name: Schoolportal framework
  Plugin URI: http://www.schoolportal.be
  Description: Enables the schoolportal classes and functions
  Version: 1.0
  Author: Dieter Deramoudt
 
 */


// sets the include path to include the current Generic framework directory

if (strpos(__FILE__, ':') !== false) {
	$path_delimiter = ';';
} else {
	$path_delimiter = ':';
}

class SP_Widget extends WP_Widget {

    public $portlet_styles = array("orange" => "Oranje", "green" => "Groen", "white" => "Wit/Geen");
    public $style_name = "white";
    public $style_arg_name = "sp_portlet_style";
    public $w_id = "0";
    public $w_name = "SP_Widget";
    public $current_style = "white";

    function SP_Widget() {
        parent::WP_Widget(false, $name = $w_name);
    }

    function widget($args, $instance) {

        echo "This should not be exectuted";
    }

    function doWidgetHeader($title,$style) {
        ?>
        
        <table class="portlet<?php echo $style ?>">
            <tr><th class="portlet<?php echo $style ?>_th"><?php echo $title ?></th></tr>
            <tr><td class="portlet<?php echo $style ?>_td">
                    <?php
                }

    function doWidgetFooter() {
                    ?>
        </td></tr>
        </table>
        
        <?php
    }

    function form($instance) {

        $this->style_name = strip_tags($instance[$this->style_arg_name]);
        ?>

        <p><label for="<?php echo $this->get_field_id($this->style_arg_name); ?>"> 
                Portlet Stijl :</label> </p>

        <select name="<?php echo $this->get_field_name($this->style_arg_name); ?>"
                id="<?php echo $this->get_field_id($this->style_arg_name); ?>">


            <?php
            foreach ($this->portlet_styles as $key => $value) {

                $selected = "";
                if ($key == $this->style_name) {
                    $selected = "SELECTED";
                }
                ?>
                <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php
            }
            ?>
        </select>

        </p>

        <input type="hidden" id="<?php echo $this->w_id . '-submit' ?>" name="<?php echo $this->w_id . '-submit' ?>" value="1" />
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance[$this->style_arg_name] = strip_tags($new_instance[$this->style_arg_name]);
        $this->currentstyle = strip_tags($new_instance[$this->style_arg_name]);
        return $instance;
    }

}
?>
