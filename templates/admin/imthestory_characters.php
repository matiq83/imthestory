<?php if ( $message!="") : ?>
<div id="message" class="updated fade"><p><strong><?php echo __( $message, 'imthestory' ); ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<br>
<h1><?php echo __( 'Characters', 'imthestory' );?> <a href="?page=imthestory_characters&action=add" class="page-title-action"><?php echo __( 'Add New', 'imthestory' );?></a></h1>
<br>
<table class="wp-list-table widefat fixed" cellspacing="0">
	<thead>
        <tr>
            <th scope="col" class="manage-column " style=""><?php echo __( 'Character Name', 'imthestory' );?></th>
            <th scope="col" class="manage-column num" style=""><?php echo __( 'Product', 'imthestory' );?></th>
            <th scope="col" class="manage-column num" style=""><?php echo __( 'Character', 'imthestory' );?></th>
            <th scope="col" class="manage-column num" style=""><?php echo __( 'Action', 'imthestory' );?></th>            
        </tr>
	</thead>

	<tfoot>
        <tr>
            <th scope="col" class="manage-column " style=""><?php echo __( 'Character Name', 'imthestory' );?></th>
            <th scope="col" class="manage-column num" style=""><?php echo __( 'Product', 'imthestory' );?></th>
            <th scope="col" class="manage-column num" style=""><?php echo __( 'Character', 'imthestory' );?></th>
            <th scope="col" class="manage-column num" style=""><?php echo __( 'Action', 'imthestory' );?></th>      
        </tr>
	</tfoot>

	<tbody id="the-list" class="list">
            <?php if( !empty($characters) ) {?>
                <?php foreach( $characters as $character ) { ?>
                    <tr class="alternate">
                        <td><strong><?php echo $character->character_name;?><?php if(!empty($character->character_name2)){ echo ' and '.$character->character_name2;}?></strong></td>
                        <td class="num">
                            <?php 
                            foreach( $products as $product ) {
                                if( $product->ID == $character->woo_product ) {
                                    echo '<a href="post.php?post='.$product->ID.'&action=edit" target="_blank">'.$product->post_title.'</a> (ID: '.$product->ID.')';
                                    break;
                                }
                            }
                            ?>
                        </td>
                        <td class="num"><img src="<?php echo $character->character_image;?>" class="imthestory_character_image" width="100" /></td>
                        <td class="num"><a href="?page=imthestory_characters&action=edit&id=<?php echo $character->id;?>">Edit</a> / <a href="?page=imthestory_characters&action=del&id=<?php echo $character->id;?>">Delete</a></td>                        
                    </tr>
                <?php }?>
            <?php }else{?>
            <tr class="alternate">
                <td colspan="4">
                    <p><?php echo __( 'There is no character at the moment', 'imthestory' );?></p>
                </td>
            </tr>
            <?php }?>
	</tbody>
</table>
</div>