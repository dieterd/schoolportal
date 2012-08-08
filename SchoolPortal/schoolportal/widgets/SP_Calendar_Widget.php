<?php

/*
 * SP_Calendar_Widget.php
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
  Plugin Name: Schoolportal activities
  Plugin URI: http://www.schoolportal.be
  Description: Shows the calender and next activities
  Version: 1.2
  Author: Dieter Deramoudt
 */

include_once 'SP_Widget.php';

class SP_Calendar_Widget extends SP_Widget {

    public $w_name = 'SP_Calendar_Widget';
    public $w_id = 'SP_Calendar_Widget';

    function SP_Calendar_Widget() {
        parent::WP_Widget(false, $name = 'SP_Calendar_Widget');
    }

    function widget($args, $instance) {

        extract($args);

        $style = apply_filters($this->style_arg_name, $instance[$this->style_arg_name]);

        global $ec3;
        $ec3->nocss = true;

        $title = 'Nabije Activiteiten' ;
               
        parent::doWidgetHeader($title,$style);

        ec3_get_events(5);
        ec3_get_calendar();

        parent::doWidgetFooter();
    }

}

add_action('widgets_init', create_function('', 'return register_widget("SP_Calendar_Widget");'));
?>