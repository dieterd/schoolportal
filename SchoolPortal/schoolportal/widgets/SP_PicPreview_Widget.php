<?php
/*
  Plugin Name: DVM Laatste foto's
  Plugin URI: http://www.vanmonckhoven.be
  Description: Toont laatste x foto sets van flickr.
  Version: 0.1
  Author: Dieter Deramoudt
  Author URI: http://www.deramoudt.com
 */

include_once 'SP_Widget.php';
require_once("phpFlickr/phpFlickr.php");

// configuration 
$username = "vanmonckhoven";
$apiKey = "6d52f2455cb6b25827cd01f8ee7247dc";
$apiSecret = "808aab183d0d534f";

$aantal = 8;
$perrij = 2;

class SP_PicPreview_Widget extends SP_Widget {

    public $w_name = 'SP_PicPreview_Widget';
    public $w_id = 'SP_PicPreview_Widget';

    function DvmLaatsteFotosWidget() {
        parent::WP_Widget(false, $name = 'SP_PicPreview_Widget');
    }

    function widget($args, $instance) {

        extract($args);

        $style = apply_filters($this->style_arg_name, $instance[$this->style_arg_name]);

        global $ec3;
        $ec3->nocss = true;

        parent::doWidgetHeader("Nieuwste fotoreeksen", $style);



        $f = new phpFlickr($apiKey, $apiSecret);
        $nsidarray = $f->people_findByUsername($username);
        $nsid = $nsidarray['nsid'];

        $photosets = $f->photosets_getList($nsid);

        if (!empty($photosets)) {

            $i = 0;
            $rij = 0;
            ?>

            <table border=0 align="center">
                <tr>

                    <?php
                    foreach ($photosets['photoset'] as $set) {
                        ?>

                        <td align="center">
                            <a target="_blank"  href="http://www.vanmonckhoven.be/wp-content/plugins/dvm_widgets/FlickrViewerSet.php?set=<?php echo $set['id']; ?>">
                                <img width="95" border=0 alt="<?php echo $set['title']; ?>" title="<?php echo $set['title']; ?>" src="http://farm<?php echo $set['farm']; ?>.static.flickr.com/<?php echo $set['server']; ?>/<?php echo $set['primary']; ?>_<?php echo $set['secret']; ?>_t.jpg">
                            </a>


                        </td>

                        <?php
                        $i = $i + 1;
                        if ($i >= $aantal) {
                            break;
                        }

                        $rij = $rij + 1;
                        if ($rij >= $perrij) {
                            $rij = 0;
                            ?>
                        </tr>
                        <tr>

                            <?php
                        }
                    }
                    ?>

                </tr>
            </table>
            <?php
        } else {
            echo "<!--GEEN SETS-->";
        }
        
        parent::doWidgetFooter() ;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("SP_PicPreview_Widget");'));
?>