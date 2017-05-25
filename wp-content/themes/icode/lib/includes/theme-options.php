<?php

/*
 * theme-options.php
 */
function theme_options_menu_page(){
    
    if(isset($_POST) && !empty($_POST)) :
        /*
         * Save theme options.
         */
        
        $theme_options = array(
            'general'   => array(
                'pagination_type'   => $_POST['pagination-type'],
                'footer'    => array(
                    'text'  => $_POST['footer-text']
                ),
                'header'    => array(
                    'logo'  => $_FILES['logo']
                )
            ),
            'msgs'  => array(
                'no_results'    => $_POST['no-results'],
                'no_search_results'=> $_POST['no-search-results'] 
            ),
            
            'social'    => array(
                'fb_link'   => $_POST['fb-link'],
                'tw_link'   => $_POST['tw-link'],
                'gplus_link'   => $_POST['gplus-link'],
                'in_link'   => $_POST['in-link'],
                'insta_link'   => $_POST['insta-link'],
                'pin_link'   => $_POST['pin-link'],
                'youtube_link' => $_POST['youtube-link'],
                'tumblr_link' => $_POST['tumblr-link']
            ),
            'misc'  => array(
                'limits'    => array(
                    'read_more' => $_POST['read-more'],
                    'per_page'  => $_POST['per-page']
                )
            ),
            
        );
    
        /*
        * Check whether all links holds, 'http://'
        */
       foreach( $theme_options['social'] as $k => $url ) :
               if( !empty( $url ) ) :
                        preg_match( '/^(http|https):\/\//i', $url, $matches );
                        if( empty( $matches ) ) :
                            $theme_options['social'][$k] = 'http://'.$url;
                        endif;
                endif;
       endforeach;
    
        // Header Logo
        $allowed_exts = array( 'png', 'jpg', 'jpeg' );
        if( isset( $_FILES['header-logo'] ) && !empty( $_FILES['header-logo']['name'] ) ) :
            $file = $_FILES['header-logo'];
                  
            $file_name = $file['name'];
            $explode = explode( '.', $file_name );
            
            if( in_array( end( $explode ), $allowed_exts ) ) :
                $logo_path = get_template_directory().'/images/logo.'.end( $explode );
            
                if( move_uploaded_file( $file['tmp_name'], $logo_path ) ) :
                    // Uploaded
                    $theme_options['general']['header']['logo'] = 'logo.'.end( $explode );
                else :
                    // Error
                    $err_msg = 'Error while uploading the file. ('.$logo_path.')';
                endif;
            else : 
                $err_msg = 'Invalid File Type (Allowed Types: '.implode( ',', $allowed_exts ).')';
            endif;
        else :
            // Set Default
            $theme_options['general']['header']['logo'] = $_POST['hidden-header-logo'];
        endif;
    
        update_option('theme-options', json_encode($theme_options));
    endif;
    
    
    
    /**
     * Get theme Options.
     */
    $theme_options = json_decode(get_option('theme-options'));
    $general_options = $theme_options->general;
    $misc_options = $theme_options->misc;
    $msgs_options = $theme_options->msgs;
    $social_options = $theme_options->social;
    
    ?>
        <div id="theme-options">
            <h2><i><?php echo get_bloginfo('name'); ?></i> Theme Options</h2>
            <div id="theme-options-menu" class="show">
                <span class="active" data-attr="1">General</span>
                <span data-attr="2">Messages</span>
                <span data-attr="3">Social</span>
                <span data-attr="4">Misc</span>
            </div>
            <form method="post" enctype="multipart/form-data" onsubmit="return false;">
                <div class="error-message show" ><?php echo $err_msg; ?></div>
                <div class="panel active" id="panel-1" style="display: block;">
                    <div>
                        <div class="header">Pagination</div>
                    </div>
                    <div>
                        <div class="label">Display Type</div> :
                        <?php 
                            $pagination_type = $theme_options->general->pagination_type;
                        ?>
                        <input type="radio" name="pagination-type" id="pagination-type-link" value="link"  <?php echo ( empty( $pagination_type ) || $pagination_type == 'link' ) ? 'checked' : ''; ?> /> Link ( default ) 
                        <input type="radio" name="pagination-type" id="pagination-type-block" value="block" <?php echo ( $pagination_type == 'block' ) ? 'checked' : ''; ?> /> Square Block
                    </div>
                    <div>
                        <div class="header">Footer</div>
                    </div>
                    <div>
                        <div class="label">Text</div> :
                        <input type="text" name="footer-text" id="footer-text" value="<?php echo $general_options->footer->text; ?>" />
                    </div>
                    <div>
                        <div class="header">Header</div>
                    </div>
                    <div>
                        <div class="label">Logo Image</div> :
                        
                        <?php
                            $header_logo = $general_options->header->logo;
                            if( !empty( $header_logo ) ) :
                                ?>
                                    <img src="<?php echo TMPL_URI.'/images/'.$header_logo; ?>" alt="Header Logo" id="header-logo-img" />
                                    <input type="hidden" name="hidden-header-logo" id="hidden-header-logo" value="<?php echo $header_logo; ?>" />
                                    <button id="logo-remove-btn" class="btn">Remove</button>
                                 <?php
                            endif;
                        ?>
                        <input type="file" id="header-logo" value="" <?php echo !empty( $header_logo ) ? 'class="none"' : 'name="header-logo"'; ?>class />
                    </div>
                </div>

                <div class="panel" id="panel-2">
                    <div>
                        <div class="header">Results</div>
                    </div>
                    <div>
                        <div class="label">No results</div> :
                        <input type="text" name="no-results" id="no-results" value="<?php echo $msgs_options->no_results; ?>" placeholder="Sorry, No results found" />
                    </div>
                    <div>
                        <div class="label">No Search results</div> :
                        <input type="text" name="no-search-results" id="no-search-results" value="<?php echo $msgs_options->no_search_results; ?>" placeholder="Sorry, No search results for {keyword}" />
                    </div>
                </div>
                
                <div class="panel" id="panel-3">
                    <div>
                        <div class="header">Links</div>
                    </div>
                    <div>
                        <div class="label">Facebook</div> :
                        <input type="text" name="fb-link" id="fb-link" value="<?php echo $social_options->fb_link; ?>" placeholder="http://www.facebook.com" />
                    </div>
                    <div>
                        <div class="label">Twitter</div> :
                        <input type="text" name="tw-link" id="tw-link" value="<?php echo $social_options->tw_link; ?>" placeholder="http://www.twitter.com" />
                    </div>
                    <div>
                        <div class="label">Google Plus</div> :
                        <input type="text" name="gplus-link" id="gplus-link" value="<?php echo $social_options->gplus_link; ?>" placeholder="http://www.plus.google.com" />
                    </div>
                    
                    <div>
                        <div class="label">LikedIn</div> :
                        <input type="text" name="in-link" id="in-link" value="<?php echo $social_options->in_link; ?>" placeholder="http://www.in.linked.com" />
                    </div>
                    <div>
                        <div class="label">Instagram</div> :
                        <input type="text" name="insta-link" id="insta-link" value="<?php echo $social_options->insta_link; ?>" placeholder="http://www.instagram.com" />
                    </div>
                    <div>
                        <div class="label">Pinterest</div> :
                        <input type="text" name="pin-link" id="pin-link" value="<?php echo $social_options->pin_link; ?>" placeholder="http://www.pinterest.com" />
                    </div>
                    <div>
                        <div class="label">Youtube</div> :
                        <input type="text" name="youtube-link" id="youtube-link" value="<?php echo $social_options->youtube_link; ?>" placeholder="http://www.youtube.com" />
                    </div>
                    <div>
                        <div class="label">Tumblr</div> :
                        <input type="text" name="tumblr-link" id="tumblr-link" value="<?php echo $social_options->tumblr_link; ?>" placeholder="http://www.tumblr.com" />
                    </div>
                </div>
                
                <div class="panel" id="panel-4">
                    <div>
                        <div class="header">Limits</div>
                    </div>
                    <div>
                        <div class="label">Read more ( in Chars )</div> :
                        <input type="text" name="read-more" id="read-more" value="<?php echo $misc_options->limits->read_more; ?>" placeholder="60" />
                    </div>
                    <div>
                        <div class="label">Posts per page</div> :
                        <input type="text" name="per-page" id="per-page" value="<?php echo $misc_options->limits->per_page; ?>" placeholder="10" />
                    </div>
                </div>
                
                <div>
                    <input type="submit" class="btn active" value="Save Options" />
                </div>
            </form>
        </div>
    <?php
    
    
}

function theme_options_menu() {
    add_menu_page('Theme Options', 'Theme Options', 'moderate_comments', 'theme_options', 'theme_options_menu_page');
}

add_action ('admin_menu', 'theme_options_menu');




