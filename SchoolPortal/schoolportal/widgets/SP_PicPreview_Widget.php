<?php
/*
  Plugin Name: Schoolportal Flickr previews
  Plugin URI: http://www.schoolportal.be
  Description: Show x number of last photosets from flickr
  Version: 0.2
  Author: Dieter Deramoudt

 */

include_once 'SP_Widget.php';

// configuration 
$username = "vanmonckhoven";
$apiKey = "6d52f2455cb6b25827cd01f8ee7247dc";
$apiSecret = "808aab183d0d534f";

$aantal = 8;
$perrij = 2;

class SP_PicPreview_Widget extends SP_Widget {

    public $w_name = 'SP_PicPreview_Widget';
    public $w_id = 'SP_PicPreview_Widget';

    function SP_PicPreview_Widget() {
        parent::WP_Widget(false, $name = 'SP_PicPreview_Widget');
    }

    function widget($args, $instance) {

        extract($args);

        $style = apply_filters($this->style_arg_name, $instance[$this->style_arg_name]);

        global $ec3;
        $ec3->nocss = true;

        parent::doWidgetHeader("Nieuwste fotoreeksen", $style);

        ?>

  <script>
      
    var xmlHttp = null;
    var theUrl = "http://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=6d52f2455cb6b25827cd01f8ee7247dc&user_id=21240450@N07&format=json&page=1&per_page=8&nojsoncallback=1" ;

    xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false );
    xmlHttp.send( null );
        
    var sets = eval ("(" + xmlHttp.responseText + ")");
    
    $perrij = 2 ;
    $rij = 0 ;
        
    for (var i=0; i < sets.photosets.photoset.length; i++) {
      photoset = sets.photosets.photoset[i];
     
       t_url = "http://farm" + photoset.farm + ".static.flickr.com/" + 
        photoset.server + "/" + photoset.primary + "_" + photoset.secret + "_t.jpg";
    
       title =  photoset.title._content.replace(/['"]/g,'');
              
      s = "<img width=\"95\" border=0 src=\""+t_url+"\" alt=\""+title+"\" title=\""+title+"\"   >" ;
      
      document.writeln("<a target=\"_blank\" href=\"/wp-content/plugins/dvm_widgets/FlickrViewerSet.php?set="+photoset.id+"\">") ;
      document.writeln(s);
      document.writeln("</a>") ;
      $rij = $rij + 1;
      if ($rij >= $perrij) { $rij = 0; document.writeln("<br>") ; }
          

     
    }

  
  </script>
 

<?php
        
        parent::doWidgetFooter() ;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("SP_PicPreview_Widget");'));
?>