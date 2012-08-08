<?php/* *  * SP_Birthday_Widget.php *  * Licensed under the Apache License, Version 2.0 (the "License"); * you may not use this file except in compliance with the License. * You may obtain a copy of the License at * *      http://www.apache.org/licenses/LICENSE-2.0 * * Unless required by applicable law or agreed to in writing, software * distributed under the License is distributed on an "AS IS" BASIS, * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. * See the License for the specific language governing permissions and * limitations under the License. *  * Plugin Name: SP Html * Plugin URI: http://www.schoolportal.be * Description: custom HTML widget * Version: 0.2 * Author: Dieter Deramoudt  */include_once 'SP_Widget.php';class SP_HTML_Widget extends SP_Widget {    public $w_name = 'SP_HTML_Widget';    public $w_id = 'SP_HTML_Widget';    public $portlet_styles = array("orange" => "Oranje", "green" => "Groen", "white" => "Wit/Geen");    public $style_name = "white";    public $style_arg_name = "dvm_portlet_style";    public $html_arg_name = "dvm_portlet_html";    public $html_name = "TEST";    public $title_arg_name = "dvm_portlet_title";    public $title_name = "Titel";    public $current_style = "white";    public $current_html = "Test";    public $current_title = "Titel";    function DvmHtmlWidget() {        parent::WP_Widget(false, $name = 'SP_HTML_Widget');    }    function form($instance) {        $this->style_name = strip_tags($instance[$this->style_arg_name]);        $this->html_name = $instance[$this->html_arg_name];        $this->title_name = strip_tags($instance[$this->title_arg_name]);        ?>        <p><label for="<?php echo $this->get_field_id($this->style_arg_name); ?>">                 Portlet Stijl :</label>            <select name="<?php echo $this->get_field_name($this->style_arg_name); ?>"                    id="<?php echo $this->get_field_id($this->style_arg_name); ?>">                <?php                foreach ($this->portlet_styles as $key => $value) {                    $selected = "";                    if ($key == $this->style_name) {                        $selected = "SELECTED";                    }                    ?>                    <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $value ?></option>                    <?php                }                ?>            </select>        </p>        <p><label for="<?php echo $this->get_field_id($this->title_arg_name); ?>">                 Titel : </label>            <input type="text" width="50"                    name="<?php echo $this->get_field_name($this->title_arg_name); ?>"                   id="<?php echo $this->get_field_id($this->title_arg_name); ?>"                    value="<?php echo $this->title_name ?>"                    >        </p>        <p><label for="<?php echo $this->get_field_id($this->html_arg_name); ?>" >                 HTML : </label>            <textarea cols="50" rows="10" type="text"                      name="<?php echo $this->get_field_name($this->html_arg_name); ?>"                      id="<?php echo $this->get_field_id($this->html_arg_name); ?>"                      ><?php echo format_to_edit($this->html_name) ?>            </textarea>        </p>        <input type="hidden" id="<?php echo $this->w_id . '-submit' ?>" name="<?php echo $this->w_id . '-submit' ?>" value="1" />        <?php    }    function update($new_instance, $old_instance) {        $instance = $old_instance;        $instance[$this->style_arg_name] = strip_tags($new_instance[$this->style_arg_name]);        $instance[$this->title_arg_name] = strip_tags($new_instance[$this->title_arg_name]);        $instance[$this->html_arg_name] = $new_instance[$this->html_arg_name];        $this->current_style = strip_tags($new_instance[$this->style_arg_name]);        $this->current_title = strip_tags($new_instance[$this->title_arg_name]);        $this->current_html = $new_instance[$this->html_arg_name];        return $instance;    }    function widget($args, $instance) {        extract($args);        $style = apply_filters($this->style_arg_name, $instance[$this->style_arg_name]);        $html = apply_filters($this->html_arg_name, $instance[$this->html_arg_name]);        $title = apply_filters($this->title_arg_name, $instance[$this->title_arg_name]);        parent::doWidgetHeader($title, $style);        echo $html;        parent::doWidgetFooter();    }}add_action('widgets_init', create_function('', 'return register_widget("SP_HTML_Widget");'));?>