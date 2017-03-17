<div class="imthestory_wizard_step3">
    <div class="imthestory_heading_container">
        <div class="imthestory_step3_img"></div>
        <div class="imthestory_step_heading">
            <div class="imthestory_heading_text">
                PHOTO UPLOAD + <span>U$ <?php echo $field_price;?></span> 
                <a href="">Skip this step</a>
                <p>Upload an image for the inside page eg family photo etc. (optional)</p>
            </div>
            <div class="imthestory_clear"></div>
        </div>
        <div class="imthestory_clear"></div>
    </div>
    <div class="imthestory_step_content_container">
        <div class="input-files form-row form-row-wide addon-wrap-128-photo-upload">
            <div class="imthestory_dotted_border">
            <div class="for-center"><img id="show-image" src="#"></div>
            <div class="input-message">Drag your image here or click to upload a photo<br>(max files size <?php echo str_replace( "M", "", ini_get("upload_max_filesize") );?> MB)</div>
            <input onchange="imthestory_readURL(this);" class="input-text input-file-upload addon" data-price="<?php echo $field_price;?>" name="<?php echo $field_name;?>" type="file">
            </div>
        </div>
        <div class="imthestory_clear"></div>
        <div class="imthestory_wizard_buttons">
            <div class="imthestory_wizard_step_left_col">
                <input class="imthestory_btn" value="BACK" id="imthestory_btn_step3_back" type="button">
            </div>
            <div class="imthestory_wizard_step_right_col">
                <input class="imthestory_btn" value="NEXT" id="imthestory_btn_step3" type="button">
            </div>    
        </div>	
    </div>
    <div class="imthestory_clear"></div><div class="imthestory_step_seprator"></div>
</div>