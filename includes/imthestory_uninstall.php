<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class that will hold functionality for plugin deactivation
 *
 * PHP version 5
 *
 * @category   Uninstall
 * @package    Customization for iamthestory.com
 * @author     Muhammad Atiq
 * @version    1.0.0
 * @since      File available since Release 1.0.0
*/

class IMTHESTORY_Uninstall
{
    public static $imthestory;
    
    public function __construct() {
        
        $this->imthestory = new IMTHESTORY();
        
        do_action('imthestory_before_uninstall', $this->imthestory, $this );
        
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."imthestory_characters`");
        
        do_action('imthestory_after_uninstall', $this->imthestory, $this );
    }    
}

$imthestory_uninstall = new IMTHESTORY_Uninstall();