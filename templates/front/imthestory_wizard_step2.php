<div class="imthestory_wizard_step2">
    <div class="imthestory_heading_container">
        <div class="imthestory_step2_img"></div>
        <div class="imthestory_step_heading">
            <div class="imthestory_heading_text">
                ADD INSCRIPTION + <span>U$ <?php echo $field_price;?></span> 
                <a href="">Skip this step</a>
                <p>Add personal text to your book (optional)</p>
            </div>
            <div class="imthestory_clear"></div>
        </div>
        <div class="imthestory_clear"></div>
    </div>
    <div class="imthestory_step_content_container">        
        <textarea type="text" id="imthestory_inscription" class="input-text addon addon-custom-textarea" data-price="<?php echo $field_price;?>" name="<?php echo $field_name;?>" rows="4" cols="20" maxlength="<?php echo $field_max;?>" placeholder="<?php echo $field_place_holder;?>"></textarea>
        
        <div class="imthestory_clear"></div>
        <div class="imthestory_wizard_buttons">
            <div class="imthestory_wizard_step_left_col">
                <input class="imthestory_btn" value="BACK" id="imthestory_btn_step2_back" type="button">
            </div>
            <div class="imthestory_wizard_step_right_col">
                <input class="imthestory_btn" value="NEXT" id="imthestory_btn_step2" type="button">
            </div>    
        </div>
    </div>    
    <div class="imthestory_clear"></div>
    <div class="imthestory_step_seprator"></div>
</div>