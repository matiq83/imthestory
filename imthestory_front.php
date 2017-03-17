<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class that will hold functionality for front side
 *
 * PHP version 5
 *
 * @category   Front Side Code
 * @package    Customization for imthestory.com
 * @author     Muhammad Atiq
 * @version    1.0.0
 * @since      File available since Release 1.0.0
*/

class IMTHESTORY_Front
{
    public static $imthestory;
    
    //Front side starting point. Will call appropriate front side hooks
    public function __construct() {
        
        $this->imthestory = new IMTHESTORY();
        do_action('imthestory_before_front', $this->imthestory, $this );
        //All front side code will go here
        add_filter( 'woocommerce_locate_template', array( $this, 'imthestory_woocommerce_locate_template' ), 25, 3 );
        add_filter( 'wc_get_template_part', array( $this, 'imthestory_wc_get_template_part' ), 25, 3 );
        add_shortcode( 'imthestory_wizard', array( $this, 'imthestory_wizard' ) );
        
        do_action('imthestory_after_front', $this->imthestory, $this );
    }
    
    public function imthestory_wizard( $atts ) {
        
        global $woocommerce, $post, $product;
        $step = $atts['step'];
        $html = '';
        ob_start();        
        if( $step == 1 ) {
            $this->imthestory_wizard_step1();
        }elseif( $step == 2 ) {
            $this->imthestory_wizard_step2();
        }elseif( $step == 3 ) {
            $this->imthestory_wizard_step3();
        }elseif( $step == 4 ) {
            $this->imthestory_wizard_step4();
        }else{
            $this->imthestory_wizard_step1();
        }
        
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
    
    private function imthestory_wizard_step1() {        
        global $woocommerce, $post, $product;
        $imthestory_product_layout = get_post_meta( $post->ID, '_imthestory_product_layout', true );
        if( !empty($imthestory_product_layout) ) {
            $woo_product = $imthestory_product_layout;
        }else{
            $woo_product = $product->id;
        }
        $characters = $this->imthestory->imthestory_get_data( 'imthestory_characters', "woo_product= '".$woo_product."'" );
        $product_addons = get_post_meta( $product->id, '_product_addons', true );
        require_once IMTHESTORY_PLUGIN_PATH.'templates/front/imthestory_wizard_step1.php';
    }
    
    private function imthestory_wizard_step2() {
        global $woocommerce, $post, $product, $imthestory_global_addons;
        $imthestory_global_addons = $this->imthestory_get_product_addons_fields( $product->id );
        foreach ($imthestory_global_addons as $addon ) {
            if( strpos( $addon['name'], 'Inscription' ) !== false || strpos( $addon['name'], 'inscription' ) !== false ) {
                $addon_name = $addon['name'];
                $addon_option = $addon['options'][0]['label'];                
                $field_price = $addon['options'][0]['price'];
                $field_max = $addon['options'][0]['max'];
                break;
            }
        }
        $field_name = "addon-".$product->id."-".sanitize_title($addon_name)."[".sanitize_title($addon_option)."]";
        $field_place_holder = $addon_option;
        if( !empty( $addon_name ) ) {
            require_once IMTHESTORY_PLUGIN_PATH.'templates/front/imthestory_wizard_step2.php';
        }
    }
    
    private function imthestory_wizard_step3() {
        global $woocommerce, $post, $product, $imthestory_global_addons;
        foreach ($imthestory_global_addons as $addon ) {
            if( strpos( $addon['name'], 'Upload' ) !== false || strpos( $addon['name'], 'upload' ) !== false ) {
                $addon_name = $addon['name'];
                $addon_option = $addon['options'][0]['label'];
                $field_price = $addon['options'][0]['price'];
                break;
            }
        }
        $field_name = "addon-".$product->id."-".sanitize_title($addon_name)."-".sanitize_title($addon_option);
        $field_place_holder = $addon_name;
        if( !empty( $addon_name ) ) {
            require_once IMTHESTORY_PLUGIN_PATH.'templates/front/imthestory_wizard_step3.php';
        }
    }
    
    private function imthestory_wizard_step4() {
        global $woocommerce, $post, $product, $imthestory_global_addons;
        foreach ($imthestory_global_addons as $addon ) {
            if( strpos( $addon['name'], 'Type' ) !== false || strpos( $addon['name'], 'type' ) !== false ) {
                $addon_name = $addon['name'];
                $addon_option = $addon['options'][0]['label'];
                $field_price = $addon['options'][0]['price'];
                break;
            }
        }
        
        $field_name = "addon-".$product->id."-".sanitize_title($addon_name)."[]";
        $field_value = sanitize_title($addon_option);
        $hard_cover = get_post_meta( $product->id, 'type_of_book_-_hard_cover', true );
        $soft_cover = get_post_meta( $product->id, 'type_of_book_-_soft_cover', true );
        if( !empty( $addon_name ) ) {
            require_once IMTHESTORY_PLUGIN_PATH.'templates/front/imthestory_wizard_step4.php';
        }
    }
    
    public function imthestory_get_product_addons_fields( $post_id = '' ) {
        
        $addons = array();
        if( empty($post_id) ) {
            return $addons;
        }
        
        $product_terms     = apply_filters( 'get_product_addons_product_terms', wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'ids' ) ), $post_id );
        $exclude           = get_post_meta( $post_id, '_product_addons_exclude_global', TRUE );
        
        if ( ! isset( $exclude ) || $exclude != '1' ) {
            // Global level addons (all products)
            $args = array(
                    'posts_per_page'   => -1,
                    'orderby'          => 'meta_value',
                    'order'            => 'ASC',
                    'meta_key'         => '_priority',
                    'post_type'        => 'global_product_addon',
                    'post_status'      => 'publish',
                    'suppress_filters' => true,
                    'meta_query' => array(
                            array(
                                    'key'   => '_all_products',
                                    'value' => '1',
                            )
                    )
            );

            $global_addons = get_posts( $args );

            if ( $global_addons ) {
                foreach ( $global_addons as $global_addon ) {
                    $addons = apply_filters( 'get_product_addons_fields', array_filter( (array) get_post_meta( $global_addon->ID, '_product_addons', true ) ), $global_addon->ID );
                }
            }

            // Global level addons (categories)
            if ( $product_terms ) {
                $args = apply_filters( 'get_product_addons_global_query_args', array(
                        'posts_per_page'   => -1,
                        'orderby'          => 'meta_value',
                        'order'            => 'ASC',
                        'meta_key'         => '_priority',
                        'post_type'        => 'global_product_addon',
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                        'tax_query'        => array(
                                array(
                                        'taxonomy'         => 'product_cat',
                                        'field'            => 'id',
                                        'terms'            => $product_terms,
                                        'include_children' => false
                                )
                        )
                ), $product_terms );

                $global_addons = get_posts( $args );

                if ( $global_addons ) {
                    foreach ( $global_addons as $global_addon ) {
                        $addons = apply_filters( 'get_product_addons_fields', array_filter( (array) get_post_meta( $global_addon->ID, '_product_addons', true ) ), $global_addon->ID );
                    }
                }
            }

        } // exclude from global addons
        
        return $addons;
    }
    
    public function imthestory_wc_get_template_part( $template, $slug, $name ) {
        
        if ( $name ) {
            $template_name = $slug.'-'.$name.'.php';
        } else {
            $template_name = $slug.'.php';
        }
        $path = IMTHESTORY_PLUGIN_PATH .'templates/front/woo/'. $template_name;
        return file_exists( $path ) ? $path : $template;
    }
    
    public function imthestory_woocommerce_locate_template( $template, $template_name, $template_path ) {
        
        global $woocommerce;
        
        $_template = $template;
        
        if ( ! $template_path ) $template_path = $woocommerce->template_url;
        
        if ( file_exists( IMTHESTORY_PLUGIN_PATH .'templates/front/woo/'. $template_name ) ) {
            $template = IMTHESTORY_PLUGIN_PATH .'templates/front/woo/'. $template_name;
        }else{
            // Look within passed path within the theme - this is priority
            $template = locate_template(
                    array(
                        $template_path . $template_name,
                        $template_name
                    ));
        }
        
        // Use default template
        if ( ! $template ) $template = $_template;
        
        // Return what we found
        return $template;
    }
}

$imthestory_front = new IMTHESTORY_Front();