<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class that will hold functionality for plugin activation
 *
 * PHP version 5
 *
 * @category   Install
 * @package    Customization for imthestory.com
 * @author     Muhammad Atiq
 * @version    1.0.0
 * @since      File available since Release 1.0.0
*/

class IMTHESTORY_Install 
{
    public static $imthestory;
    
    public function __construct() {
        
        $this->imthestory = new IMTHESTORY();
        
        do_action('imthestory_before_install', $this->imthestory, $this );
        
        global $wpdb;
        $sql="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."imthestory_characters` (
                          `id` bigint(20) NOT NULL AUTO_INCREMENT,
                          `character_name` varchar(255) DEFAULT '0',
                          `character_name2` varchar(255) DEFAULT '0',
                          `character_image` text DEFAULT NULL,
                          `woo_product` varchar(255) DEFAULT '0',
                          `woo_product_addon` varchar(255) DEFAULT '0',
                          `woo_product_addon2` varchar(255) DEFAULT '0',
                          PRIMARY KEY (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        $wpdb->query($sql);
        
        do_action('imthestory_after_install', $this->imthestory, $this );
    }    
}

$imthestory_install = new IMTHESTORY_Install();