jQuery(document).ready(function($){
    if( $(".frm_imthestory #woo_product").length ) {
        $(".frm_imthestory #woo_product").change(function(){
            var product_id = $(this).val();
            if( product_id != "" ) {
                $(".imthestory_woo_product_addon").html("<p>Please wait ....</p>");
                var data = {
                            action: 'imthestory_load_product_addons',
                            product_id:product_id,
                            id:$("#id").val()
                        };

                $.post( ajaxurl, data, function( response ) {
                    if( !response['error'] ) {
                        $(".imthestory_woo_product_addon").html(response['content']);                        
                    }else{
                        alert(response['content']);
                        $(".imthestory_woo_product_addon").html("<p>Please select some product to show its add ons</p>");
                    }
                });
            }
        });
        $(".frm_imthestory #woo_product").trigger("change");
    }
    
    if( $(".imthestory_field_container #imthestory_character").length ) {
        $(".imthestory_field_container #imthestory_character").change(function(){
            var img_url     = $(this).val();
            
            if( img_url !== "" ) {
                var addon1      = $(this).find(":selected").attr('data-woo-product-addon');
                var addon2      = $(this).find(":selected").attr('data-woo-product-addon2');
                var chr_name1   = $(this).find(":selected").attr('data-character-name');
                var chr_name2   = $(this).find(":selected").attr('data-character-name2');
                if( $(".imthestory_char_thumbs #"+addon1+"_thumb").length ) {
                    imthestory_select_char($(".imthestory_char_thumbs #"+addon1+"_thumb"));
                }else{
                    $(".imthestory_selected_char_container").html('<img src="'+img_url+'" id="'+addon1+'_main" /><span data-woo-product-addon="'+addon1+'" data-woo-product-addon2="'+addon2+'" onclick="javascript: imthestory_del_char(this);">X</span>');
                    $(".imthestory_char_thumbs").append('<a id="'+addon1+'_thumb" class="imthestory_char_thumb" onclick="javascript:return imthestory_select_char(this);" href="'+img_url+'" data-woo-product-addon="'+addon1+'" data-woo-product-addon2="'+addon2+'" data-character-name="'+chr_name1+'" data-character-name2="'+chr_name2+'" ><img src="'+img_url+'" /></a>');
                    imthestory_select_char($(".imthestory_char_thumbs #"+addon1+"_thumb"));
                }
                $(".imthestory_selected_char_container").show();
                $(this).find(":selected").hide();
                $(this).find(":selected").prop("selected", false);
            }
        });
        
        $(".imthestory_field_container #imthestory_character").trigger("change");
    }
    
    if( $(".imthestory_field_container .imthestory_character_select_box").length ) {
        $(".imthestory_wizard_product").mouseup(function (e) {
            var container = $(".imthestory_field_container .imthestory_character_select_box");
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                $(".imthestory_field_container .imthestory_character_select_box .imthestory_characters").hide();
            }
        });
        
        $(".imthestory_field_container .imthestory_character_select_box").click(function(){
            $(".imthestory_field_container .imthestory_character_select_box .imthestory_characters").toggle();
        });
        
        $(".imthestory_field_container .imthestory_character_select_box .imthestory_characters .imthestory_character").click(function(){
            var img_url     = $(this).attr('data-value');
            
            if( img_url !== "" ) {
                var addon1      = $(this).attr('data-woo-product-addon');
                var addon2      = $(this).attr('data-woo-product-addon2');
                var chr_name1   = $(this).attr('data-character-name');
                var chr_name2   = $(this).attr('data-character-name2');
                if( $(".imthestory_char_thumbs #"+addon1+"_thumb").length ) {
                    imthestory_select_char($(".imthestory_char_thumbs #"+addon1+"_thumb"));
                }else{
                    $(".imthestory_selected_char_container").html('<img src="'+img_url+'" id="'+addon1+'_main" /><span data-woo-product-addon="'+addon1+'" data-woo-product-addon2="'+addon2+'" onclick="javascript: imthestory_del_char(this);">X</span>');
                    $(".imthestory_char_thumbs").append('<a id="'+addon1+'_thumb" class="imthestory_char_thumb" onclick="javascript:return imthestory_select_char(this);" href="'+img_url+'" data-woo-product-addon="'+addon1+'" data-woo-product-addon2="'+addon2+'" data-character-name="'+chr_name1+'" data-character-name2="'+chr_name2+'" ><img src="'+img_url+'" /></a>');
                    imthestory_select_char($(".imthestory_char_thumbs #"+addon1+"_thumb"));
                }
                $(".imthestory_selected_char_container").show();
                $(this).hide();                
            }
        });
        
        $(".imthestory_field_container .imthestory_character_select_box .imthestory_characters .imthestory_default_character").trigger('click');
        $(".imthestory_field_container .imthestory_character_select_box .imthestory_characters").hide();
    }
    
    if( $("#imthestory_character_name").length ) {
        $("#imthestory_character_name").keyup(function(){
            var value       = $(this).val();
            var addon1      = $(this).attr('data-woo-product-addon');
            $("#"+addon1+"_field").val(value);
            $("#"+addon1+"_thumb").attr('data-character-name',value);
            if( addon1 == 'name-for-alice' ) {
                $(".a3dg-image-wrapper .a3dg-image").css('top','20px');
                $(".a3dg-image-wrapper .a3dg-image").html($(".imthestory_preview_text_container").html());
                if( $("#imthestory_character_name2").val() != "" ) {
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").css('top','40px');
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").html(value+" & "+$("#imthestory_character_name2").val());
                }else{
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").css('top','53px');
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").html(value);
                }            
            }
        });
    }
    
    if( $("#imthestory_character_name2").length ) {
        $("#imthestory_character_name2").keyup(function(){
            var value       = $(this).val();
            var addon2      = $(this).attr('data-woo-product-addon2');
            var addon1      = $(this).attr('data-woo-product-addon');
            $("#"+addon2+"_field").val(value);
            $("#"+addon1+"_thumb").attr('data-character-name2',value);
            if( addon1 == 'name-for-alice' ) {
                $(".a3dg-image-wrapper .a3dg-image").html($(".imthestory_preview_text_container").html());
                $(".a3dg-image-wrapper .a3dg-image").css('top','20px');
                $(".a3dg-image-wrapper .a3dg-image").html($(".imthestory_preview_text_container").html());
                if( $("#imthestory_character_name").val() != "" ) {
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").css('top','40px');
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").html($("#imthestory_character_name").val()+" & "+value);
                }else{
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").css('top','53px');
                    $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").html(value);
                }
            }
        });
    }
    
    if( $("#imthestory_btn_step1").length ) {
        $("#imthestory_btn_step1").click(function(){
            $(".imthestory_wizard_step1").hide();
            $(".imthestory_wizard_step2").slideDown();
        });
    }
    
    if( $("#imthestory_btn_step2_back").length ) {
        $("#imthestory_btn_step2_back").click(function(){
            $(".imthestory_wizard_step2").hide();
            $(".imthestory_wizard_step1").slideDown();
        });        
    }
    
    if( $("#imthestory_btn_step2").length ) {
        $("#imthestory_btn_step2").click(function(){
            $(".imthestory_wizard_step2").hide();
            $(".imthestory_wizard_step3").slideDown();
        });
    }
    
    if( $(".imthestory_wizard_step2 .imthestory_heading_text a").length ) {
        $(".imthestory_wizard_step2 .imthestory_heading_text a").click(function(){
            $("#imthestory_btn_step2").trigger("click");
            return false;
        });        
    }
    
    if( $("#imthestory_btn_step3_back").length ) {
        $("#imthestory_btn_step3_back").click(function(){
            $(".imthestory_wizard_step3").hide();
            $(".imthestory_wizard_step2").slideDown();
        });        
    }
    
    if( $("#imthestory_btn_step3").length ) {
        $("#imthestory_btn_step3").click(function(){
            $(".imthestory_wizard_step3").hide();
            $(".imthestory_wizard_step4").slideDown();
            $(".imthestory_soft_cover_opt").trigger("click");
        });
    }
    
    if( $(".imthestory_wizard_step3 .imthestory_heading_text a").length ) {
        $(".imthestory_wizard_step3 .imthestory_heading_text a").click(function(){
            $("#imthestory_btn_step3").trigger("click");
            return false;
        });        
    }
    
    if( $("#imthestory_btn_step4_back").length ) {
        $("#imthestory_btn_step4_back").click(function(){
            $(".imthestory_wizard_step4").hide();
            $(".imthestory_wizard_step3").slideDown();
        });        
    }
    
    if( $(".single-product .images .product_gallery .a3-dgallery .a3dg-thumbs li a img").length ) {
        var style = $(".single-product .images .product_gallery .a3-dgallery .a3dg-thumbs li a img").attr('style');
        style = style.replace( /!important/g, "" );
        //style = style.replace( "! important", "" );
        $(".single-product .images .product_gallery .a3-dgallery .a3dg-thumbs li a img").attr( 'style',style );
    }
});

function imthestory_readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            jQuery('.input-files').addClass('image-added');
            jQuery('#show-image')
                    .attr('src', e.target.result)
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function imthestory_calc_total() {
    var $ = jQuery;
    var product_price = parseFloat($("#imthestory_product_addons_total").attr('data-price'));
    if( $("#imthestory_hard_cover").is(':checked')) {
        product_price = product_price+parseFloat($("#imthestory_hard_cover").attr('data-price'));
    }
    if( $('.input-files').hasClass('image-added') ) {
        product_price = product_price+parseFloat($(".input-files input.input-file-upload").attr('data-price'));
    }
    if( $('#imthestory_inscription').val() != "" ) {
        product_price = product_price+parseFloat($("#imthestory_inscription").attr('data-price'));
    }
    $("#imthestory_product_addons_total").html("$"+parseFloat(product_price).toFixed(2));
}

function imthestory_select_char(obj) {
    var $ = jQuery;
    var img_url     = $(obj).attr('href');
    var addon1      = $(obj).attr('data-woo-product-addon');
    var addon2      = $(obj).attr('data-woo-product-addon2');
    var chr_name1   = $(obj).attr('data-character-name');
    var chr_name2   = $(obj).attr('data-character-name2');
    $(".imthestory_char_thumb").show();
    $(obj).hide();
    $("#imthestory_character_name").val(chr_name1);
    if( addon1 == 'name-for-alice' ) {
        $(".a3dg-image-wrapper .a3dg-image").css('top','20px');
        $(".a3dg-image-wrapper .a3dg-image").html($(".imthestory_preview_text_container").html());
        if( chr_name2 != "" ) {
            $("#imthestory_character_name2").val(chr_name2);
            $("#imthestory_character_name2").show();
            $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").css('top','40px');
            $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").html(chr_name1+" & "+chr_name2);
        }else{
            $("#imthestory_character_name2").val(chr_name2);
            $("#imthestory_character_name2").hide();
            $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").css('top','53px');
            $(".a3dg-image-wrapper .a3dg-image .imthestory_preview_text").html(chr_name1);
        }
    }else{
        if( chr_name2 != "" ) {
            $("#imthestory_character_name2").val(chr_name2);
            $("#imthestory_character_name2").show();            
        }else{
            $("#imthestory_character_name2").val(chr_name2);
            $("#imthestory_character_name2").hide();            
        }
    }
    $("#"+addon1+"_field").val(chr_name1);
    $("#"+addon2+"_field").val(chr_name2);
    $("#imthestory_character_name").attr("data-woo-product-addon",addon1);
    $("#imthestory_character_name").attr("data-woo-product-addon2",addon2);
    $("#imthestory_character_name2").attr("data-woo-product-addon",addon1);
    $("#imthestory_character_name2").attr("data-woo-product-addon2",addon2);
    $(".imthestory_selected_char_container").html('<img src="'+img_url+'" /><span data-woo-product-addon="'+addon1+'" data-woo-product-addon2="'+addon2+'" onclick="javascript: imthestory_del_char(this);">X</span>');
    return false;
}

function imthestory_del_char(obj) {
    var $ = jQuery;
    var addon1      = $(obj).attr('data-woo-product-addon');
    var addon2      = $(obj).attr('data-woo-product-addon2');
    $("#"+addon1+"_field").val("");
    $("#"+addon2+"_field").val("");    
    $(".imthestory_char_thumbs #"+addon1+"_thumb").remove();
    var next_obj = $(".imthestory_char_thumbs a").first();
    imthestory_select_char(next_obj);
    if( !$(".imthestory_char_thumbs a").length ) {
        $(".imthestory_selected_char_container").hide();
        $("#imthestory_character_name2").hide();
    }
    $("."+addon1+"_option").show();
}