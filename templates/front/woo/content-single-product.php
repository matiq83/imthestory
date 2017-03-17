<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<?php
/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
do_action( 'woocommerce_before_single_product' );

$imthestory = new IMTHESTORY();
$record  = $imthestory->imthestory_get_data( "imthestory_characters", "woo_product = '".get_the_ID()."'", TRUE );

$imthestory_product_layout = get_post_meta( get_the_ID(), '_imthestory_product_layout', true );

$enable_wizzard = false;

if( !empty($record) ) {
    $enable_wizzard = true;
}

if( !empty($imthestory_product_layout) ) {
    $enable_wizzard = true;
}

//echo $enable_wizzard;
if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
if( $enable_wizzard ) {
    global $woocommerce;
    $cart_count = $woocommerce->cart->cart_contents_count;
    $cart_url   = $woocommerce->cart->get_cart_url();
    ?>
    <script>
        <?php if( empty($imthestory_product_layout) ) {?>
        jQuery(".single-product").addClass('imthestory_wizard_product');
        jQuery(".imthestory_wizard_product #header").remove();
        jQuery(".imthestory_wizard_product .slideshow2").remove();
        jQuery(".imthestory_wizard_product #breadcrumbs").remove();
        jQuery(".imthestory_wizard_product .footer-wrap").remove();
        jQuery(".imthestory_wizard_product #wrapper .tagline").html('<div class="logo"><a href="<?php echo IMTHESTORY_SITE_BASE_URL;?>"><img src="<?php echo IMTHESTORY_PLUGIN_URL.'/images/logo.png';?>"/></a></div><div class="text"><?php the_title(); ?></div><div class="cart"><a href="<?php echo $cart_url;?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo ($cart_count <= 1)?$cart_count.' item':$cart_count.' items';?></a></div>');
        <?php }else{?>
        jQuery(".single-product").addClass('imthestory_wizard_product_layout2');
        <?php }?>
    </script>
    <header class="imthestory_product_title_header">
        <h1><?php the_title(); ?></h1>
        <img src="<?php echo get_template_directory_uri(); ?>/images/decor1.png" alt="" style="margin-bottom:20px;" class="img-no-border centered">
    </header>
    <?php
}else{
?>
<header>
    <h1><?php the_title(); ?></h1>
    <img src="<?php echo get_template_directory_uri(); ?>/images/decor1.png" alt="" style="margin-bottom:20px;" class="img-no-border centered">
</header>
<?php } ?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    /**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
    if( $enable_wizzard ) {
        echo '<form class="cart" method="post" enctype="multipart/form-data">';
        echo '<div class="imthestory_wizard_container">';
        echo '<div class="imthestory_wizard_step1">'; 
        echo '<div class="imthestory_preview_text_container"><img src="'.IMTHESTORY_PLUGIN_URL.'images/main_cover.png" /><div class="imthestory_preview_text"></div></div>';
    }
    do_action( 'woocommerce_before_single_product_summary' );    
    ?>
    <style>
    .single-product .images .a3-dgallery .a3dg-thumbs li{
        border: none !important;
    }
    .product_gallery .a3-dgallery .a3dg-thumbs li a{
        border: 1px solid #ccc !important;
    }
    .a3-dgallery .a3dg-thumbs li a.a3dg-active{
        border: 2px solid #D86565 !important;
    }
    .single-product .images .product_gallery .a3-dgallery .a3dg-thumbs li a img{
        padding: 6px 0 0 20px !important;
    }
    </style>
    <div class="summary entry-summary">

        <?php
        /**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
        if( $enable_wizzard ) {
            echo do_shortcode('[imthestory_wizard step="1"]');
        }else{
            do_action( 'woocommerce_single_product_summary' );
        }        
        ?>
    </div><!-- .summary -->
    
    <?php
    if( $enable_wizzard ) {
        echo '<div class="imthestory_clear"></div><div class="imthestory_step_seprator"></div></div>';
        echo do_shortcode('[imthestory_wizard step="2"]');
        echo do_shortcode('[imthestory_wizard step="3"]');
        echo do_shortcode('[imthestory_wizard step="4"]');
        echo '</div>';
        echo '</form>';
    }
    /**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
    if( !$enable_wizzard ) {
        do_action( 'woocommerce_after_single_product_summary' );
        //add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    ?>
    <script>
        jQuery(function() {
            jQuery( ".addon-section" ).accordion({heightStyle: "content"});

            // CUSTOMIZE MY BOOK - section
            jQuery('#btn-next1').click(function (){
                jQuery('#ui-id-3 h3').trigger('click');
                jQuery('#ui-id-3 h3').text('ADD INSCRIPTION + U$ 2.50 ');
            });

            // ADD INSCRIPTIONS - section
            jQuery('#ui-id-3').click(function (){
                jQuery('#ui-id-3 h3').text('ADD INSCRIPTION + U$ 2.50 ');
            });
            jQuery('#btn-next2').on('click', function() {
                if (jQuery(".addon-custom-textarea").val()) {
                    if (jQuery(".check-textarea").is(":checked")) {
                        jQuery('#ui-id-5 h3').trigger('click'); //open photo upload section
                        jQuery('#ui-id-5 h3').text('PHOTO UPLOAD + U$ 2.50 ');
                        jQuery(".single-product form.cart #ui-id-4 .please-agree").hide();
                    } else {
                        jQuery(".single-product form.cart #ui-id-4 .please-agree").show();
                    }
                } else {
                    jQuery('#ui-id-5 h3').trigger('click'); //open photo upload section
                    jQuery('#ui-id-5 h3').text('PHOTO UPLOAD + U$ 2.50 ');
                    jQuery(".single-product form.cart #ui-id-4 .please-agree").hide();
                }
            });
            jQuery('.btn-skiptoStep3').on('click', function(e) {
                e.preventDefault();
                jQuery(".addon-custom-textarea").val('');
                jQuery("input.hard-cover").trigger('click');
                jQuery("input.hard-cover").trigger('click');
                //jQuery('.inscription-added').remove();
                jQuery('.check-textarea').prop('checked',false);
                jQuery('#ui-id-5 h3').trigger('click'); //open photo upload section
                jQuery('#ui-id-5 h3').text('PHOTO UPLOAD + U$ 2.50 ');
                jQuery(".single-product form.cart #ui-id-4 .please-agree").hide();
            });
            /*jQuery('.check-textarea').on('click', function() {
				if (!jQuery(".check-textarea").is(":checked")) {
					jQuery('.inscription-added').show();
				}
			});*/

            // PHOTO UPLOAD - section
            jQuery('#ui-id-5').click(function (){
                if (jQuery(".addon-custom-textarea").val()) {
                    if (!jQuery(".check-textarea").is(":checked")) {
                        jQuery(".addon-custom-textarea").val('');
                        //jQuery('.inscription-added').remove();
                        jQuery("input.hard-cover").trigger('click');
                        jQuery("input.hard-cover").trigger('click');
                        jQuery('#ui-id-5 h3').text('PHOTO UPLOAD + U$ 2.50 ');
                        jQuery(".single-product form.cart #ui-id-4 .please-agree").hide();
                    }
                }
            });
            jQuery('#ui-id-5').click(function (){
                jQuery('#ui-id-5 h3').text('PHOTO UPLOAD + U$ 2.50 ');
            });
            jQuery('#btn-next3').on('click', function() {
                if (jQuery(".input-file-upload").val()) {
                    if (jQuery(".check-fileupload").is(":checked")) {
                        jQuery('#ui-id-7 h3').trigger('click');
                        jQuery(".single-product form.cart #ui-id-6 .please-agree").hide();
                    } else {
                        jQuery(".single-product form.cart #ui-id-6 .please-agree").show();
                    }
                } else {
                    jQuery('#ui-id-7 h3').trigger('click');
                    jQuery(".single-product form.cart #ui-id-6 .please-agree").hide();
                }
            });
            jQuery('.btn-skiptoStep4').on('click', function(e) {
                e.preventDefault();
                jQuery(".input-file-upload").val('');
                jQuery('#show-image').attr('src', '');
                jQuery('.input-files').removeClass('image-added');
                //jQuery('.photo-upload').remove();
                jQuery('.check-fileupload').prop('checked',false);
                jQuery("input.hard-cover").trigger('click');
                jQuery("input.hard-cover").trigger('click');
                jQuery('#ui-id-7 h3').trigger('click');
                jQuery(".single-product form.cart #ui-id-6 .please-agree").hide();
            });

            // TYPE OF BOOK - section
            jQuery('#ui-id-7').click(function (){
                if (jQuery(".addon-custom-textarea").val()) {
                    if (!jQuery(".check-textarea").is(":checked")) {
                        //jQuery('.inscription-added').remove();
                        jQuery(".addon-custom-textarea").val('');
                        jQuery("input.hard-cover").trigger('click');
                        jQuery("input.hard-cover").trigger('click');
                        jQuery(".single-product form.cart #ui-id-6 .please-agree").hide();
                    }
                }
            });
            jQuery('#ui-id-7').click(function (){
                if (jQuery(".input-file-upload").val()) {
                    if (!jQuery(".check-fileupload").is(":checked")) {
                        jQuery(".input-file-upload").val('');
                        jQuery('#show-image').attr('src', '');
                        //jQuery('.photo-upload').remove();
                        jQuery("input.hard-cover").trigger('click');
                        jQuery("input.hard-cover").trigger('click');
                        jQuery('.input-files').removeClass('image-added');
                    }
                }
            });

            // BUTTON

            jQuery('.after-form .single_add_to_cart_button').click(function (){
                if (!jQuery(".addon-custom-textarea").val()) {
                    jQuery(".check-textarea").prop('required',false);
                }
                if (!jQuery(".input-file-upload").val()) {
                    jQuery(".check-fileupload").prop('required',false);
                }
            });


            jQuery(document).on('click', ".type_options_l.deselected", function() {
                jQuery(this).removeClass('deselected');
                jQuery(this).addClass('selected');
                jQuery('.type_options_r').removeClass('selected');
                jQuery('.type_options_r').addClass('deselected');
                jQuery('#agree_pay_extra2').prop('checked',true);
                jQuery('.hard-cover').trigger('click');
            });

            jQuery(document).on('click', ".type_options_r.deselected", function() {
                jQuery(this).removeClass('deselected');
                jQuery(this).addClass('selected');
                jQuery('.type_options_l').removeClass('selected');
                jQuery('.type_options_l').addClass('deselected');
                jQuery('#agree_pay_extra2').prop('checked',false);
                jQuery('.hard-cover').trigger('click');
            });
        });
    </script>
    <?php 
    }
    ?>
    <meta itemprop="url" content="<?php the_permalink(); ?>" />
    <meta itemprop="name" content="<?php the_title(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>