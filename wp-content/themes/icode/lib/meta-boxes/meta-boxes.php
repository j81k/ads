<?php

/*
 * meta-boxes.php ( lib/meta-boxes )
 */

/**
 * Add Buttons on the Post page
 */
function post_meta_boxes( $post ){
    
    $post_buttons = json_decode( get_post_meta( $post->ID, 'post_buttons', true ) );
    ?>
        <table>
            <thead>
                <tr>
                    <td colspan="10">
                        <h4>Single Page Buttons: (Optional)</h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    if( empty( $post_buttons ) ) :
                        $post_buttons = array('','');
                    endif;
                    
                    foreach( $post_buttons as $k => $post_button ) :
                ?>
                        <tr>
                            <td><input type="text" placeholder="Button Name" value="<?php echo ( empty( $post_button->button_name ) ) ? ( ( $k == 0 ) ? 'Source' : 'Live' ) : $post_button->button_name; ?>" name="post-btn-name[]"/></td>
                            <td width="65%"><input type="text" placeholder="Button Link (http://www.example.com)" value="<?php echo $post_button->button_url; ?>" name="post-btn-url[]" style="width: 100%"/></td>
                            <td><input type="checkbox" name="post-btn-target[]" <?php echo ( $post_button->button_target == 'on' ) ? 'checked' : ''; ?>/> Target</td>
                        </tr>
                <?php 
                    endforeach;
                ?>
                
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <span style="text-decoration: italic;">It will be displayed under the featured image of this post in a single page.</span>
                    </td>
                </tr>
            </tfoot>
            
        </table>
    <?php
}
function admin_menu_meta_boxes() {
    add_meta_box( 'post-meta-box', 'Post Options', 'post_meta_boxes', 'post');
    
}
add_action( 'admin_menu', 'admin_menu_meta_boxes' );

function saving_post( $post_id ) {
   
    // Do not update, while AUTO_SAVE
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || get_post_type( $post_id ) != 'post' ) :
        return $post_id;
    endif;
    
    $post_buttons = array();
    foreach( $_POST['post-btn-name'] as $k => $button_name ) :
        $url = $_POST['post-btn-url'][$k];
        if( !empty( $button_name ) && !empty( $url ) ) :
            
           /*
            * Check whether url holds, 'http://'
            */
           preg_match( '/^(http|https):\/\//i', $url, $matches );
           if( empty( $matches ) ) :
               $url = 'http://'.$url;
           endif;
       
            $post_buttons[] = array(
                'button_name'   => $button_name,
                'button_url'    => $url,
                'button_target' => $_POST['post-btn-target'][$k]
            );
        endif;
    endforeach;
        
    update_post_meta( $post_id, 'post_buttons', json_encode( $post_buttons ) );
    
}
add_action( 'save_post', 'saving_post' );

/**
 * Add Social link boxes to User profile.
 */
function user_meta_boxes( $user ) {
    
    $user_social = json_decode( get_user_meta( $user->ID, 'social-links', true ) ) ;
    ?>
        <h3>User Social Links</h3>
        <table class="form-table">
            <tr>
                <th><label>Facebook </label></th><td><input type="text" name="fb-link" class="regular-text" value="<?php echo $user_social->fb_link; ?>" placeholder="http://www.facebook.com"></td>
            </tr>
            <tr>
                <th><label>Twitter </label></th><td><input type="text" name="tw-link" class="regular-text" value="<?php echo $user_social->tw_link; ?>" placeholder="http://www.twitter.com"></td>
            </tr>
            <tr>
                <th><label>Google Plus </label></th><td><input type="text" name="gplus-link" class="regular-text" value="<?php echo $user_social->gplus_link; ?>" placeholder="http://www.plus.google.com"></td>
            </tr>
            <tr>
                <th><label>LikedIn </label></th><td><input type="text" name="in-link" class="regular-text" value="<?php echo $user_social->in_link; ?>" placeholder="http://www.in.linked.com"></td>
            </tr>
            <tr>
                <th><label>Instagram </label></th><td><input type="text" name="insta-link" class="regular-text" value="<?php echo $user_social->insta_link; ?>" placeholder="http://www.instagram.com"></td>
            </tr>
            <tr>
                <th><label>Pinterest </label></th><td><input type="text" name="pin-link" class="regular-text" value="<?php echo $user_social->pin_link; ?>" placeholder="http://www.pinterest.com"></td>
            </tr>
            
            <tr>
                <th><label>Youtube </label></th><td><input type="text" name="youtube-link" class="regular-text" value="<?php echo $user_social->youtube_link; ?>" placeholder="http://www.youtube.com"></td>
            </tr>
            <tr>
                <th><label>Tumblr </label></th><td><input type="text" name="tumblr-link" class="regular-text" value="<?php echo $user_social->tumblr_link; ?>" placeholder="http://www.tumblr.com"></td>
            </tr>
        </table>    
    <?php
}


add_action( 'show_user_profile', 'user_meta_boxes' );
add_action( 'edit_user_profile', 'user_meta_boxes' );


// update User profile.
function save_user_meta_boxes( $user_id ) {
    
    if( !current_user_can( 'edit_user' ) ) :
        return false;
    endif;
    
    $args = array(
        'fb_link'   => $_POST['fb-link'],
        'tw_link'   => $_POST['tw-link'],
        'gplus_link'   => $_POST['gplus-link'],
        'in_link'   => $_POST['in-link'],
        'insta_link'   => $_POST['insta-link'],
        'pin_link'   => $_POST['pin-link'],
        'youtube_link' => $_POST['youtube-link'],
        'tumblr_link' => $_POST['tumblr-link']
    );
    
    /*
     * Check whether all links holds, 'http://'
     */
    foreach( $args as $k => $url ) :
        if( !empty( $url ) ) :
                preg_match( '/^(http|https):\/\//i', $url, $matches );
                if( empty( $matches ) ) :
                    $args[$k] = 'http://'.$url;
                endif;
        endif;
    endforeach;
    
    update_user_meta( $user_id, 'social-links', json_encode( $args ) );
    
}
add_action( 'edit_user_profile_update', 'save_user_meta_boxes' );
add_action( 'personal_options_update', 'save_user_meta_boxes' );

?>
