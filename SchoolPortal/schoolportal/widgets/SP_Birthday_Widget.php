<?php
/*
 * SP_Birthday_Widget.php
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
 * Plugin Name: schoolportal birthday widget
 * Plugin URI: http://www.schoolportal.be
 * Description: show current birthday
 * Version: 1.1
 * Author: Dieter Deramoudt
 */

include_once 'SP_Widget.php';
include_once 'SP_DB.php';

// Configuration
$locale = 'nl_NL';
$timezone = 'Europe/Brussels';
$baseUrl = "/images/klassen400/" ;

class SP_Birthday_Widget extends SP_Widget {

    public $w_name = 'SP_Birthday_Widget';
    public $w_id = 'SP_Birthday_Widget';

    function SP_Birthday_Widget() {
        parent::WP_Widget(false, $name = 'SP_Birthday_Widget');
    }

    function widget($args, $instance) {


        extract($args);

        $style = apply_filters($this->style_arg_name, $instance[$this->style_arg_name]);

        setlocale(LC_ALL, $locale);

        date_default_timezone_set($timezone);
        $newstring = substr($oldstring, 0, 20);

        $month = substr(strftime("%B"), 0, 3);
        $day = strftime("%A");
        $daynumber = date("j");
        $year = date("Y");


        $query = 'SELECT naam,klas,year(now())-year(verjaardag),foto,voornaam FROM `vanmonckho_db`.`verjaardag` where day(verjaardag) = day(now()) and month(verjaardag) = month(now()) ';

        $result = doQuery($query);


        $num_rows = mysql_num_rows($result);

        if ($num_rows > 0) {

            parent::doWidgetHeader($title, $style);

            echo "<b>" . $day . ", " . $daynumber . "</b> " . $month . " " . $year;

            $i = 0;

            while ($line = @mysql_fetch_array($result, MYSQL_ASSOC)) {

                $i = $i + 1;

                $klas = $line["klas"];
                $voornaam = $line["voornaam"];
                $naam = $line["naam"];
                $fullname = $voornaam . ' ' . $naam;
                $verjaardag = $line["verjaardag"];
                $jaar = $line["year(now())-year(verjaardag)"];

                $foto = $line["foto"];


                if ($foto == "") {

                    $naam1 = str_replace(" ", "", $naam);

                    $foto = $klas . "_" . strtolower($naam1) . "_" . strtolower($voornaam);
                }

                $url = $baseUrl . $foto . ".JPG";
                ?>


                <p>
                    <a href="<?php echo $url; ?>" onclick="return hs.expand(this)" id="thumb1" class="highslide"> <?php echo $fullname; ?></a> van <?php echo $klas; ?>: <?php echo $jaar; ?> jaar !
                </p>

                <?php
            }

            if ($i > 0) {
                echo '<p><center><blink>Van harte proficiat !!</blink></center></p>';
            }

            parent::doWidgetFooter();
        } else {

            echo '<!-- geen verjaardagen vandaag --> ';
        }

// Free resultset
        @mysql_free_result($result);
    }

}

add_action('widgets_init', create_function('', 'return register_widget("DvmCalenderWidget");'));
?>