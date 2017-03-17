<div class="imthestory_wizard_step_left_col">
    <div class="imthestory_field_container">
        <label>Change Name (Optional)</label>
        <?php /* ?><div class="imthestory_down_arrow"></div><?php */ ?>
        <div class="imthestory_field">
            <input type="text" name="imthestory_character_name" id="imthestory_character_name" />
            <input type="text" name="imthestory_character_name2" id="imthestory_character_name2" />
        </div>
    </div>
    
    <div class="imthestory_field_container">
        <label>Add Character (Optional)</label>
        <div class="imthestory_field">
            <div class="imthestory_character_select_box">
                <span class="imthestory_character_select_box_icon"></span>
                <span class="imthestory_character_select_box_text">Select Character</span>
                <div class="imthestory_characters">
                <?php
                $counter = 0;
                foreach( $characters as $character ) {
                    $label = $character->character_name;
                    if( $character->character_name2 != "" ) {
                        //$label.=' and '.$character->character_name2;
                    }
                    if( $counter == 0 ) {
                        echo '<div style="display:none;" class="imthestory_default_character imthestory_character '.$character->woo_product_addon.'_option" data-value="'.$character->character_image.'" data-woo-product-addon="'.$character->woo_product_addon.'" data-woo-product-addon2="'.$character->woo_product_addon2.'" data-character-name="'.$character->character_name.'" data-character-name2="'.$character->character_name2.'"><img src="'.$character->character_image.'" />'.$label.'</div>';
                    }else{
                        echo '<div class="imthestory_character '.$character->woo_product_addon.'_option" data-value="'.$character->character_image.'" data-woo-product-addon="'.$character->woo_product_addon.'" data-woo-product-addon2="'.$character->woo_product_addon2.'" data-character-name="'.$character->character_name.'" data-character-name2="'.$character->character_name2.'"><img src="'.$character->character_image.'" />'.$label.'</div>';
                    }                    
                    $counter++;
                }
                ?>
                </div>
            </div>
            <?php /* ?>
            <select name="imthestory_character" id="imthestory_character">
                <option value="">Select Character</option>
                <?php
                $counter = 0;
                foreach( $characters as $character ) {
                    $label = $character->character_name;
                    if( $character->character_name2 != "" ) {
                        //$label.=' and '.$character->character_name2;
                    }
                    if( $counter == 0 ) {
                        echo '<option selected class="'.$character->woo_product_addon.'_option" value="'.$character->character_image.'" data-woo-product-addon="'.$character->woo_product_addon.'" data-woo-product-addon2="'.$character->woo_product_addon2.'" data-character-name="'.$character->character_name.'" data-character-name2="'.$character->character_name2.'">'.$label.'</option>';
                    }else{
                        echo '<option class="'.$character->woo_product_addon.'_option" value="'.$character->character_image.'" data-woo-product-addon="'.$character->woo_product_addon.'" data-woo-product-addon2="'.$character->woo_product_addon2.'" data-character-name="'.$character->character_name.'" data-character-name2="'.$character->character_name2.'">'.$label.'</option>';
                    }                    
                    $counter++;
                }
                ?>
            </select>
            <?php */ ?>
            <?php
            if( !empty($product_addons) ) {
                $addon_field_name = "addon-".$product->id."-".sanitize_title($product_addons[0]['name']);
                foreach( $product_addons[0]['options'] as $option ) {
                    $add_on = sanitize_title($option['label']);
                    echo '<input type="hidden" value="" id="'.$add_on.'_field" name="'.$addon_field_name.'['.$add_on.']" data-price="'.$option['price'].'">';
                }
            }
            ?>
        </div>
        <?php /* ?>
        <div class="imthestory_right_arrow"></div><?php */?>
    </div>
</div>
<div class="imthestory_wizard_step_right_col">
    <div class="imthestory_char_container">
        <div class="imthestory_selected_char_container">

        </div>
        <div class="imthestory_char_thumbs">

        </div>
    </div>
    <div class="imthestory_next_button_container">
        <input type="button" class="imthestory_btn" value="NEXT" id="imthestory_btn_step1" />
    </div>
</div>
<div class="imthestory_clear"></div>