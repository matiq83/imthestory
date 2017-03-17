<?php if ( $message!="") : ?>
<div id="message" class="updated fade"><p><strong><?php echo __( $message, 'imthestory' ); ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2><?php echo __( 'Edit Character', 'imthestory' ); ?></h2>
<form method="post" name="frm_imthestory" id="frm_imthestory" class="frm_imthestory" action="?page=imthestory_characters&action=edit&id=<?php echo $character->id;?>" enctype="multipart/form-data">
    <table class="wp-list-table widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="manage-column" style=""><?php echo __( 'Character Detail', 'imthestory' );?></th>
            </tr>
        </thead>
        <tbody id="the-list">
            <tr>
                <td>            	
                    <table width="100%">
                        <tr>
                            <td width="150"><?php echo __( 'Character Name', 'imthestory' );?></td>
                            <td>
                                <input type="text" name="character_name" id="character_name" value="<?php echo $character->character_name;?>" /><br>
                                <p><small>If character have two names then please enter second name below</small></p>
                                <input type="text" name="character_name2" id="character_name2" value="<?php echo $character->character_name2;?>" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __( 'Character Image', 'imthestory' );?></td>
                            <td>
                                <img src="<?php echo $character->character_image;?>" class="imthestory_character_image" width="100" /><br>
                                <input type="text" name="character_image" id="character_image" value="<?php echo $character->character_image;?>" class="textfield" />
                                <input class="upload_media_button button" type="button" name="btnupload" value="Upload" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __( 'Product', 'imthestory' );?></td>
                            <td>
                                <select name="woo_product" id="woo_product">
                                    <option value="">Select Product</option>
                                    <?php foreach( $products as $product ) {?>
                                    <?php if( $character->woo_product == $product->ID ) {?>
                                    <option value="<?php echo $product->ID;?>" selected><?php echo $product->post_title;?> (ID: <?php echo $product->ID;?>)</option>
                                    <?php }else{?>
                                    <option value="<?php echo $product->ID;?>"><?php echo $product->post_title;?> (ID: <?php echo $product->ID;?>)</option>
                                    <?php }?>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __( 'Product Add-on', 'imthestory' );?></td>
                            <td class="imthestory_woo_product_addon">
                                <p>Please select some product to show its add ons</p>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="id" id="id" value="<?php echo $character->id;?>" /></td>
                            <td><input type="submit" name="btnsave" id="btnsave" class="button button-primary button-large" value="Save"></td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</form>