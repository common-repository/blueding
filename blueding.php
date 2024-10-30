<?php 
/*
Plugin Name: Blueding
Plugin URI: http://wp.blueding.com
Description: Blueding automatically adds to your content, suitable for mobiles, a link to download the content onto mobile via bluetooth.
Version: 0.3.3
Author: MobiScanner S.L.
Author URI: http://www.blueding.com

Copyright 2009 MobiScanner S.L. contact@blueding.com
*/

$blueding_localversion="0.3.3";

$sfi_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
function blueding_add_pages(){
    add_options_page('Blueding options', 'Blueding', 8, __FILE__, 'blueding_options_page');
}

// Options Page
function blueding_options_page(){
    global $blueding_localversion;

    $status=blueding_getinfo();

    $theVersion = $status[1];
    $theMessage = $status[3];

    if( (version_compare(strval($theVersion), strval($blueding_localversion), '>') == 1) ) {
        $msg = 'Latest version available '.' <strong>'.$theVersion.'</strong><br />'.$theMessage;
        _e('<div id="message" class="updated fade"><p>' . $msg . '</p></div>');
    }

    // If form was submitted
    if (isset($_POST['submitted'])) {
        $blueding_images=(!isset($_POST['blueding_images'])? '': $_POST['blueding_images']);
        update_option('blueding_images',($blueding_images=='on') ? "on":"off");
        $blueding_mp3=(!isset($_POST['blueding_mp3'])? '': $_POST['blueding_mp3']);
        update_option('blueding_mp3',($blueding_mp3=='on') ? "on":"off");
        $blueding_3gp=(!isset($_POST['blueding_3gp'])? '': $_POST['blueding_3gp']);
        update_option('blueding_3gp',($blueding_3gp=='on') ? "on":"off");
        $blueding_mp4=(!isset($_POST['blueding_mp4'])? '': $_POST['blueding_mp4']);
        update_option('blueding_mp4',($blueding_mp4=='on') ? "on":"off");
        $blueding_jar=(!isset($_POST['blueding_jar'])? '': $_POST['blueding_jar']);
        update_option('blueding_jar',($blueding_jar=='on') ? "on":"off");
        $blueding_sis=(!isset($_POST['blueding_sis'])? '': $_POST['blueding_sis']);
        update_option('blueding_sis',($blueding_sis=='on') ? "on":"off");
        $blueding_sisx=(!isset($_POST['blueding_sisx'])? '': $_POST['blueding_sisx']);
        update_option('blueding_sisx',($blueding_sisx=='on') ? "on":"off");
        $blueding_cab=(!isset($_POST['blueding_cab'])? '': $_POST['blueding_cab']);
        update_option('blueding_cab',($blueding_cab=='on') ? "on":"off");
        $blueding_class=(!isset($_POST['blueding_class'])? '': $_POST['blueding_class']);
        update_option('blueding_class',($blueding_class=='on') ? "on":"off");

        if ($blueding_mp3=='off' && $blueding_3gp=='off'&& $blueding_mp4=='off' && $blueding_jar=='off' && $blueding_sis=='off' && $blueding_sisx=='off' && $blueding_cab=='off'){
            update_option('blueding_links','off');
        }else {
            update_option('blueding_links','on');
        }
        $msg_status = 'Blueding options saved.';

        // Show message
        _e('<div id="message" class="updated fade"><p>' . $msg_status . '</p></div>');

    }

    $blueding_images =( get_option('blueding_images')=='on' ) ? "checked":"";
    $blueding_3gp =( get_option('blueding_3gp')=='on' ) ? "checked":"";
    $blueding_mp4 =( get_option('blueding_mp4')=='on' ) ? "checked":"";
    $blueding_mp3 =( get_option('blueding_mp3')=='on' ) ? "checked":"";
    $blueding_jar =( get_option('blueding_jar')=='on' ) ? "checked":"";
    $blueding_sis =( get_option('blueding_sis')=='on' ) ? "checked":"";
    $blueding_sisx =( get_option('blueding_sisx')=='on' ) ? "checked":"";
    $blueding_cab =( get_option('blueding_cab')=='on' ) ? "checked":"";
    $blueding_class =( get_option('blueding_class')=='on' ) ? "checked":"";

    global $sfi_plugin_url;
    $imgpath=$sfi_plugin_url.'/images';
    $actionurl=$_SERVER['REQUEST_URI'];

    // Configuration Page
    echo <<<END
<div class="wrap" style="!important;">
    <h2>Blueding</h2>

    <div id="poststuff" style="margin-top:10px;">
        <div id="sideblock" style="float:right;width:220px;margin-left:10px;">
            <h2>Information</h2>
            <div id="dbx-content" style="text-decoration:none;">
                <img src="$imgpath/blueding.png"><a  href="http://wp.blueding.com"> Blueding pluggin home</a><br /><br />
                <img src="$imgpath/rate.png"><a href="http://wordpress.org/extend/plugins/blueding/"> Rate this plugin</a><br /><br />
            </div>
        </div>

        <div id="mainblock">
            <div class="dbx-content">
                <form action="$action_url" method="post">
                    <input type="hidden" name="submitted" value="1" />
                    <h2>General Options</h2>
                    <p>Blueding automatically adds to your content, suitable for mobiles, a link to download the content onto mobile via bluetooth.</p>
                    <div>
                        <input type="checkbox" name="blueding_images" $blueding_images /> Images<br/>
                        <input type="checkbox" name="blueding_3gp" $blueding_3gp /> Videos (.3gp)<br/>
                        <input type="checkbox" name="blueding_mp4" $blueding_mp4 /> Videos (.mp4)<br/>
                        <input type="checkbox" name="blueding_mp3" $blueding_mp3 /> Music (.mp3)<br/>
                        <input type="checkbox" name="blueding_jar" $blueding_jar /> J2ME (.jar)<br/>
                        <input type="checkbox" name="blueding_sis" $blueding_sis /> Symbian apps (.sis)<br/>
                        <input type="checkbox" name="blueding_sisx" $blueding_sisx /> Symbian apps (.sisx)<br/>
                        <input type="checkbox" name="blueding_cab" $blueding_cab /> Windows Mobile apps (.cab)<br/>
                        <br/>
                        <input type="checkbox" name="blueding_class" $blueding_class /> Only images or links with the class blueding<br/>
                        <br/>
                        You can change the look and feel of the blueding download zone in the blueding.css file.
                    </div>
                    <br>
                    <div class="submit"><input type="submit" name="Submit" value="Update options" /></div>
                </form>
            </div>
         </div>
    </div>
</div>
END;

}

// Add Options Page
add_action('admin_menu', 'blueding_add_pages');

function fullUrl($relative) {
    $absolute="http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $p = parse_url($relative);
    if($p["scheme"])return $relative;

    extract(parse_url($absolute));

    $path = dirname($path);

    if($relative{0} == '/') {
        $cparts = array_filter(explode("/", $relative));
    }
    else {
        $aparts = array_filter(explode("/", $path));
        $rparts = array_filter(explode("/", $relative));
        $cparts = array_merge($aparts, $rparts);
        foreach($cparts as $i => $part) {
            if($part == '.') {
                $cparts[$i] = null;
            }
            if($part == '..') {
                $cparts[$i - 1] = null;
                $cparts[$i] = null;
            }
        }
        $cparts = array_filter($cparts);
    }
    $path = implode("/", $cparts);
    $url = "";
    if($scheme) {
        $url = "$scheme://";
    }
    if($user) {
        $url .= "$user";
        if($pass) {
            $url .= ":$pass";
        }
        $url .= "@";
    }
    if($host) {
        $url .= "$host/";
    }
    $url .= $path;
    return $url;
}

function blueding($content) {
    global $sfi_plugin_url;
    $imgpath=$sfi_plugin_url.'/images';

    $b_images='';

    if (get_option('blueding_images')=='on'){
        preg_match_all('/<img[^>]+/', $content, $images);
        foreach ($images[0] as $image){
            if(get_option('blueding_class')=='on'){
                $valid=false;
                if(preg_match('/<img[^>]+class[\\s=\'"]+([^"\'>]+)/is',$image,$match)){
                    $classes=split(' ', $match[1]);
                    foreach ($classes as $class){
                        if ($class=='blueding'){
                            $valid=true;
                            break;
                        }
                    }
                }
                if (!$valid){
                    continue;
                }
            }
            if(preg_match('/<img[^>]+src[\\s=\'"]+([^"\'>\\s]+)/is', $image, $match))    {
                $src=fullUrl($match[1]);
                $b_images.='<a href="http://do.blueding.com/?url='.urlencode($src).'" target="blueding"><img src="'.$src.'"/></a>';
            }
        }
    }

    $b_links='';
    if (get_option('blueding_links')=='on'){
        preg_match_all('/<a[^>]+/', $content, $links);
        foreach ($links[0] as $link){
            if(get_option('blueding_class')=='on'){
                $valid=false;
                if(preg_match('/<a[^>]+class[\\s=\'"]+([^"\'>]+)/is',$link,$match)){
                    $classes=split(' ', $match[1]);
                    foreach ($classes as $class){
                        if ($class=='blueding'){
                            $valid=true;
                            break;
                        }
                    }
                }
                if (!$valid){
                    continue;
                }
            }
            if(preg_match('/<a[^>]+href[\\s=\'"]+([^"\'>\\s]+)/is',$link,$match))    {
                $src=fullUrl($match[1]);
                $name=substr($src,strrpos($src,'/'));
                $term3=substr($src, -4);
                $term4=substr($src, -5);
                $ct='';
                if (get_option('blueding_3gp')=='on' && $term3=='.3gp'){
                    $ct='video/3gpp';
                }else if (get_option('blueding_mp4')=='on' && $term3=='.mp4'){
                    $ct='video/mp4';
                } else if (get_option('blueding_mp3')=='on' && $term3=='.mp3'){
                    $ct='audio/mpeg';
                } else if (get_option('blueding_jar')=='on' && $term3=='.jar'){
                    $ct='application/x-java-jar';
                } else if (get_option('blueding_sis')=='on' && $term3=='.sis'){
                    $ct='application/vnd.symbian.install';
                } else if (get_option('blueding_sisx')=='on' && $term4=='.sisx'){
                    $ct='x-epoc/x-sisx-app';
                } else if (get_option('blueding_cab')=='on' && $term3=='.cab'){
                    $ct='application/vnd.ms-cab-compressed';
                }

                if ($ct!=''){
                    $b_links.='<a href="http://do.blueding.com/?ct='.$ct.'&url='.urlencode($src).'" target="blueding">'.$name.'</a><br/>';
                }
            }
        }
    }

    $extra='';
    if ($b_images!='' || $b_links!=''){
        $extra='<div class="blueding_zone"><div class="blueding_title"><img src="'.$imgpath.'/blueding.png" /> Blueding - download to your mobile</div>';
        $extra.='<div class="blueding_images">'.$b_images.'</div>';
        $extra.='<div class="blueding_links">'.$b_links.'</div>';
        $extra.='</div>';
    }
    return $content.$extra;
}

add_filter('the_content', 'blueding', 50);

add_action( 'after_plugin_row', 'blueding_check_plugin_version' );

function blueding_getinfo(){
    $checkfile = "http://svn.wp-plugins.org/blueding/trunk/blueding.chk";

    $status=array();
    return $status;
    $vcheck = wp_remote_fopen($checkfile);

    if($vcheck) {
        $status = explode('@', $vcheck);
        return $status;
    }
}

function blueding_check_plugin_version($plugin){
    global $plugindir, $blueding_localversion;

    if( strpos($plugin,'blueding.php')!==false ) {
        $status=blueding_getinfo();

        $theVersion = $status[1];
        $theMessage = $status[3];

        if( (version_compare(strval($theVersion), strval($blueding_localversion), '>') == 1) ) {
            $msg = 'Latest version available '.' <strong>'.$theVersion.'</strong><br />'.$theMessage;
            echo '<td colspan="5" class="plugin-update" style="line-height:1.2em;">'.$msg.'</td>';
        } else {
            return;
        }
    }
}

function blueding_install(){
    if(!get_option('blueding_images')){
        add_option('blueding_images', 'on');
    }
    if(!get_option('blueding_3gp')){
        add_option('blueding_3gp', 'on');
    }
    if(!get_option('blueding_mp4')){
        add_option('blueding_mp4', 'on');
    }
    if(!get_option('blueding_mp3')){
        add_option('blueding_mp3', 'on');
    }
    if(!get_option('blueding_jar')){
        add_option('blueding_jar', 'on');
    }
    if(!get_option('blueding_sis')){
        add_option('blueding_sis', 'off');
    }
    if(!get_option('blueding_sisx')){
        add_option('blueding_sisx', 'off');
    }
    if(!get_option('blueding_cab')){
        add_option('blueding_cab', 'off');
    }
    if(!get_option('blueding_links')){
        add_option('blueding_links', 'off');
    }
    if(!get_option('blueding_class')){
        add_option('blueding_class', 'off');
    }
}

add_action('plugins_loaded', 'blueding_install' );

function blueding_css() {
    echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') .'/wp-content/plugins/blueding/blueding.css" />' . "\n";
}

add_action('wp_head', 'blueding_css');
?>