<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Plugin main class that will control the whole skeleton and common functions
 *
 * PHP version 5
 *
 * @category   Main
 * @package    Customization for imthestory.com
 * @author     Muhammad Atiq
 * @version    1.0.0
 * @since      File available since Release 1.0.0
*/

class IMTHESTORY
{
     
    //Plugin starting point. Will call appropriate actions
    public function __construct() {

        add_action( 'plugins_loaded', array( $this, 'imthestory_init' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'imthestory_enqueue_scripts' ), 10 );
        add_action( 'admin_enqueue_scripts', array( $this, 'imthestory_enqueue_scripts' ), 10 );
    }

    //Plugin initialization
    public function imthestory_init() {

        do_action('imthestory_before_init');

        if(is_admin()){            
            require_once IMTHESTORY_PLUGIN_PATH.'imthestory_admin.php';            
        }

        require_once IMTHESTORY_PLUGIN_PATH.'imthestory_front.php';
        
        do_action('imthestory_after_init');
    }
    
    //Function will add CSS and JS files
    public function imthestory_enqueue_scripts() {
        
        do_action('imthestory_before_enqueue_scripts');
        
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'imthestory_js', IMTHESTORY_PLUGIN_URL.'js/imthestory.js', array( 'jquery' ), time() );
        wp_enqueue_style( 'imthestory_css', IMTHESTORY_PLUGIN_URL.'css/imthestory.css', array(), time() );
        wp_enqueue_style( 'imthestory_google_css', 'https://fonts.googleapis.com/css?family=Fenix', array('imthestory_css'), time() );
        
        do_action('imthestory_after_enqueue_scripts');
    }
    
    public function imthestory_add_record( $table = '', $data = array() ) {
        
        if( empty($data) || empty($table) ) {
            return false;
        }
        
        global $wpdb;
        $exclude = array( 'btnsave' );
        $attr = "";
        $attr_val = "";
        foreach( $data as $k=>$val ) {
            $val = $this->make_safe($val);
            if(is_array($val)) {
                $val = maybe_serialize($val);
            }
            $should_insert = true;
            foreach( $exclude as $v ) {
                $pos = strpos($k, $v);
                if ($pos !== false) {
                    $should_insert = false;
                    break;
                }
            }
            if( $should_insert ) {
                if( $attr == "" ) {
                    $attr.="`".$k."`";
                    $attr_val.="'".$val."'";
                }else{
                    $attr.=", `".$k."`";
                    $attr_val.=", '".$val."'";
                }                
            }
        }
        $sql = "INSERT INTO `".$wpdb->prefix.$table."` (".$attr.") VALUES (".$attr_val.")";
        $wpdb->query($sql);
        
        return true;
    }
    
    public function imthestory_update_record( $table = '', $data = array(), $id = '' ) {
        
        if( !is_numeric($id) || empty($data) || empty($table) ) {
            return false;
        }
        
        global $wpdb;
        $exclude = array( 'id','btnsave' );
        $attr = "";
        foreach( $data as $k=>$val ) {
            $val = $this->make_safe($val);
            if(is_array($val)) {
                $val = maybe_serialize($val);
            }
            $should_insert = true;
            foreach( $exclude as $v ) {
                $pos = strpos($k, $v);
                if ($pos !== false) {
                    $should_insert = false;
                    break;
                }
            }
            if( $should_insert ) {
                if( $attr == "" ) {
                    $attr.="`".$k."` = '".$val."'";                    
                }else{
                    $attr.=", `".$k."` = '".$val."'";
                }                
            }
        }
        $sql = "UPDATE `".$wpdb->prefix.$table."` SET ".$attr." WHERE id = '".$id."'";
        $wpdb->query($sql);
        
        return true;
    }
    
    public function imthestory_del_record( $table = '', $id = '' ) {
        
        if( !is_numeric($id) || empty($table) ) {
            return false;
        }
        
        global $wpdb;
        $sql = "DELETE FROM `".$wpdb->prefix.$table."` WHERE id = '".$id."'";
        $wpdb->query($sql);
        return true;
    }
    
    public function imthestory_get_data( $table = '', $where = "1", $get_row = false ) {
        
        if( empty($table) ) {
            return false;
        }
        
        global $wpdb;
        
        $sql = "SELECT * FROM `".$wpdb->prefix.$table."` WHERE ".$where;
        if( $get_row ) {
            $data = $wpdb->get_row($sql);
        }else{
            $data = $wpdb->get_results($sql);
        }
        
        return $data;
    }
    
    public function make_safe( $variable ) {

        $variable = $this->strip_html_tags($variable);
        $bad = array("<", ">");
        $variable = str_replace($bad, "", $variable);
        
        return $variable;
    }

    public function strip_html_tags( $text ) {
        $text = preg_replace(
                array(
                  // Remove invisible content
                        '@<head[^>]*?>.*?</head>@siu',
                        '@<style[^>]*?>.*?</style>@siu',
                        '@<script[^>]*?.*?</script>@siu',
                        '@<object[^>]*?.*?</object>@siu',
                        '@<embed[^>]*?.*?</embed>@siu',
                        '@<applet[^>]*?.*?</applet>@siu',
                        '@<noframes[^>]*?.*?</noframes>@siu',
                        '@<noscript[^>]*?.*?</noscript>@siu',
                        '@<noembed[^>]*?.*?</noembed>@siu'
                ),
                array(
                        '', '', '', '', '', '', '', '', ''), $text );

        return strip_tags( $text);
    }

    // Function to safe redirect the page without warnings
    public function redirect( $url ) {
        echo '<script language="javascript">window.location.href="'.$url.'";</script>';
        exit();
    }
    
    //Function will get called on plugin activation
    static function imthestory_install() {

        do_action('imthestory_before_install');

        require_once IMTHESTORY_PLUGIN_PATH.'includes/imthestory_install.php';

        do_action('imthestory_after_install');
    }

    // Function will get called on plugin de activation
    static function imthestory_uninstall() {

        do_action('imthestory_before_uninstall');

        require_once IMTHESTORY_PLUGIN_PATH.'includes/imthestory_uninstall.php';

        do_action('imthestory_after_uninstall');
    }
}

$imthestory = new IMTHESTORY();