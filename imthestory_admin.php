<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class that will hold functionality for admin side
 *
 * PHP version 5
 *
 * @category   Admin Side Code
 * @package    Customization for imthestory.com
 * @author     Muhammad Atiq
 * @version    1.0.0
 * @since      File available since Release 1.0.0
*/

class IMTHESTORY_Admin
{
    public static $imthestory;
    
    //Admin side starting point. Will call appropriate admin side hooks
    public function __construct() {
        
        $this->imthestory = new IMTHESTORY();
        
        do_action('imthestory_before_admin', $this->imthestory, $this );
        //All admin side code will go here
        
        add_action( 'admin_menu', array( $this, 'imthestory_admin_menus' ) );    
        add_action( 'wp_ajax_imthestory_load_product_addons', array( $this, 'imthestory_load_product_addons' ) );
        add_action( 'wp_ajax_nopriv_imthestory_load_product_addons', array( $this, 'imthestory_load_product_addons' ) );
        add_action( 'add_meta_boxes', array( $this, 'imthestory_register_meta_boxes' ) );
        add_action( 'save_post',      array( $this, 'imthestory_save_product' ) );
        
        do_action('imthestory_after_admin', $this->imthestory, $this );            
    }
    
    public function imthestory_register_meta_boxes( $post_type ) {
        
        // Limit meta box to certain post types.
        $post_types = array( 'product' );
 
        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
                'imthestory_product_layout_type',
                __( 'Normal Layout For Product', 'imthestory' ),
                array( $this, 'imthestory_product_layout_type' ),
                $post_type,
                'advanced',
                'high'
            );
        }
        //add_meta_box( 'imthestory_product_layout_type', __( 'Normal Layout For Product', 'imthestory' ), array( $this, 'imthestory_product_layout_type' ) , 'product' );
    }
    
    public function imthestory_product_layout_type( $post ) {
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'imthestory_inner_custom_box', 'imthestory_inner_custom_box_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta( $post->ID, '_imthestory_product_layout', true );
        
        $imthestory_data = $this->imthestory->imthestory_get_data( "imthestory_characters" );
        $products_ids = array();
        foreach( $imthestory_data as $row ) {
            $products_ids[] = $row->woo_product;
        }
        $products_ids = array_unique($products_ids);
        // Display the form, using the current value.
        ?>
        <label for="myplugin_new_field">
            <?php _e( 'Is this product have a normal layout for any of the following product? If YES then please select it.', 'imthestory' ); ?>
        </label>
        <br><br>
        <?php foreach( $products_ids as $id ) { ?>
        <?php if( $value == $id ) { ?>
        <input type="radio" checked id="imthestory_product_layout" name="imthestory_product_layout" value="<?php echo esc_attr( $id ); ?>" /> <?php echo get_the_title($id);?> (<?php echo $id;?>) <br>
        <?php }else{ ?>
        <input type="radio" id="imthestory_product_layout" name="imthestory_product_layout" value="<?php echo esc_attr( $id ); ?>" /> <?php echo get_the_title($id);?> (<?php echo $id;?>) <br>
        <?php }?>
        <?php }?>
        <?php
    }
    
    public function imthestory_save_product( $post_id ) {
        
        // Check if our nonce is set.
        if ( ! isset( $_POST['imthestory_inner_custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['imthestory_inner_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'imthestory_inner_custom_box' ) ) {
            return $post_id;
        }
 
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
        // Check the user's permissions.        
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        
        /* OK, it's safe for us to save the data now. */
 
        // Sanitize the user input.
        $imthestory_product_layout = sanitize_text_field( $_POST['imthestory_product_layout'] );
 
        // Update the meta field.
        update_post_meta( $post_id, '_imthestory_product_layout', $imthestory_product_layout );
    }
    
    public function imthestory_load_product_addons() {
        $product_id = $_POST['product_id'];
        $character_id = $_POST['id'];
        $error = false;
        $html = '';
        if( !is_numeric($product_id) ) {
            $error = true;
            $html = 'Please provide valid product!';
        }
        
        if( is_numeric($character_id) ) {
            $character = $this->imthestory->imthestory_get_data( 'imthestory_characters', "id = '".$character_id."'", TRUE );
        }
        $product_addons = get_post_meta( $product_id, '_product_addons', true );
        if( !empty($product_addons) ) {
            $html.= '<select name="woo_product_addon">';
            $html.= '<option value="">Select Add On</option>';
            foreach( $product_addons[0]['options'] as $option ) {
                $add_on = sanitize_title($option['label']);
                if( !empty($character) ) {
                    if( $character->woo_product_addon == $add_on ) {
                        $html.= '<option value="'.$add_on.'" selected>'.$option['label'].'</option>';
                    }else{
                        $html.= '<option value="'.$add_on.'">'.$option['label'].'</option>';
                    }
                }else{
                    $html.= '<option value="'.$add_on.'">'.$option['label'].'</option>';
                }                
            }
            $html.= '</select>';
            
            $html.= '<p><small>If character have two names then please select add on for the second name below</small></p>';
            $html.='<select name="woo_product_addon2">';
            $html.= '<option value="">Select Add On</option>';
            foreach( $product_addons[0]['options'] as $option ) {
                $add_on = sanitize_title($option['label']);
                if( !empty($character) ) {
                    if( $character->woo_product_addon2 == $add_on ) {
                        $html.= '<option value="'.$add_on.'" selected>'.$option['label'].'</option>';
                    }else{
                        $html.= '<option value="'.$add_on.'">'.$option['label'].'</option>';
                    }
                }else{
                    $html.= '<option value="'.$add_on.'">'.$option['label'].'</option>';
                }                
            }
            $html.= '</select>';
        }else{
            $html.='<p>There is no addon for this product, please select some other product.</p>';
        }
        $return = array( 'error'=> $error, 'content' => $html );
        
        header('Content-Type: application/json');
        echo json_encode($return);
        exit();
    }
    
    public function imthestory_admin_menus(){
        
        add_menu_page( IMTHESTORY_PLUGIN_NAME, 'Characters', 'manage_options', 'imthestory_characters', array( $this, 'imthestory_characters' ) );
        //add_submenu_page( 'imthestory_settings', IMTHESTORY_PLUGIN_NAME.' Settings', 'Settings', 'manage_options', 'imthestory_characters', array( $this, 'imthestory_characters' ) );
        //add_submenu_page( 'imthestory_settings', IMTHESTORY_PLUGIN_NAME.' Reports', 'Reports', 'manage_options', 'imthestory_reports', array( $this, 'imthestory_reports' ) );
    }    
    
    public function imthestory_characters() {
        
        $action = $_REQUEST['action'];
        $html = '';
        ob_start();
        $args     = array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1 );
        $products = get_posts( $args );        
        if( $action == 'add' ) {
            if( isset($_POST['btnsave']) ) {
                if( $this->imthestory->imthestory_add_record( 'imthestory_characters', $_POST )) {
                    $message = "Character added successfully!";
                }
            }
            require_once IMTHESTORY_PLUGIN_PATH.'templates/admin/imthestory_add_character.php';
        }elseif ( $action == 'edit' ) {
            if( is_numeric($_REQUEST['id']) ) {
                if( isset($_POST['btnsave']) ) {
                    if( $this->imthestory->imthestory_update_record( 'imthestory_characters', $_POST, $_REQUEST['id'] )) {
                        $message = "Character updated successfully!";
                    }
                }
                $character = $this->imthestory->imthestory_get_data( 'imthestory_characters', "id = '".$_REQUEST['id']."'", TRUE );
                require_once IMTHESTORY_PLUGIN_PATH.'templates/admin/imthestory_edit_character.php';
            }
        }else{
            if ( $action == 'del' ) {
                if( is_numeric($_REQUEST['id']) ) {
                    $this->imthestory->imthestory_del_record( 'imthestory_characters', $_REQUEST['id'] );
                    $message = "Character deleted successfully!";
                }                
            }
            $characters = $this->imthestory->imthestory_get_data( 'imthestory_characters' );
            require_once IMTHESTORY_PLUGIN_PATH.'templates/admin/imthestory_characters.php';            
        }
        $this->load_wp_media_uploader();
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
        
    }
    
    public function imthestory_reports() {
        
    }
    
    private function load_wp_media_uploader() {
        
        wp_enqueue_script('media-upload');
    	wp_enqueue_script('thickbox');
    	wp_enqueue_style('thickbox');
        
        $this->load_javascript();
    }
    
    private function load_javascript() {
        $html = '';
        ob_start();
        require_once IMTHESTORY_PLUGIN_PATH.'templates/admin/load_media_upload_js.php';
        $html = ob_get_contents();
        ob_end_clean();
        echo $html;
    }
}

$imthestory_admin = new IMTHESTORY_Admin();