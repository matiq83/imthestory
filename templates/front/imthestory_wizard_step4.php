<div class="imthestory_wizard_step4">
    <div class="imthestory_heading_container">
        <div class="imthestory_step4_img"></div>
        <div class="imthestory_step_heading">
            <div class="imthestory_heading_text">
                CHOOSE TYPE OF BOOK 
                <p>Choose between our options</p>
            </div>
            <div class="imthestory_clear"></div>
        </div>
        <div class="imthestory_clear"></div>
    </div>
    <div class="imthestory_step_content_container">
        
        <div class="imthestory_book_type_container">
            <p class="form-row form-row-wide" style="display: none;">
                <input class="addon addon-checkbox" id="imthestory_hard_cover" name="<?php echo $field_name;?>" data-price="<?php echo $field_price;?>" value="<?php echo $field_value;?>" type="checkbox">
            </p>
            <div class="customize_item" id="item_types">
                <div class="type_options_l selected">
                    <h3>Hard Cover + U$ <?php echo $field_price;?></h3>
                    <div class="l_option_texts">
                        <input id="agree_pay_extra2" name="agree_pay_extra2" value="1" type="checkbox"> Yes, I agree to pay extra U$ <?php echo $field_price;?> <br>for Hard Cover.
                    </div>
                    <img src="<?php echo $hard_cover;?>">
                </div>
                <div class="type_options_r deselected imthestory_soft_cover_opt">
                    <h3>Soft Cover / Paper Back</h3>
                    <div class="l_option_texts">
                        No additional cost.
                    </div>
                    <img src="<?php echo $soft_cover;?>">
                </div>
            </div>
            <div class="imthestory_clear"></div>
        </div>
        <div class="imthestory_clear"></div>
        <div class="imthestory_wizard_buttons">
            <div class="imthestory_wizard_step_col33 imthestory_wizard_step_col1">
                <input class="imthestory_btn" value="BACK" id="imthestory_btn_step4_back" type="button">
            </div>
            <div class="imthestory_wizard_step_col33 imthestory_wizard_step_col2">
                <p class="text-total">Book total + customization:</p>
                <div id="imthestory_product_addons_total" data-type="simple" data-price="<?php echo $product->price;?>">$<?php echo $product->price;?></div>
            </div>
            <div class="imthestory_wizard_step_col33 imthestory_wizard_step_col3">
                <input class="imthestory_btn single_add_to_cart_button" value="ADD TO CART" id="imthestory_btn_step4" type="submit">
                <input name="add-to-cart" value="<?php echo $product->id;?>" type="hidden">
            </div>    
        </div>
    </div>
    <div class="imthestory_clear"></div>
</div>
<script>
    jQuery(document).on('click', ".type_options_l.deselected", function() {
        jQuery(this).removeClass('deselected');
        jQuery(this).addClass('selected');
        jQuery('.type_options_r').removeClass('selected');
        jQuery('.type_options_r').addClass('deselected');
        jQuery('#agree_pay_extra2').prop('checked',true);
        jQuery('#imthestory_hard_cover').prop('checked',true);
        imthestory_calc_total();
    });

    jQuery(document).on('click', ".type_options_r.deselected", function() {
        jQuery(this).removeClass('deselected');
        jQuery(this).addClass('selected');
        jQuery('.type_options_l').removeClass('selected');
        jQuery('.type_options_l').addClass('deselected');
        jQuery('#agree_pay_extra2').prop('checked',false);
        jQuery('#imthestory_hard_cover').prop('checked',false);
        imthestory_calc_total();
    });
</script>