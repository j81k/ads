<?php

/*
 * functions.php
 */

/*
 * Define Basic settings
 */
show_admin_bar( false );
add_theme_support( 'post-thumbnails' );
//add_post_type_support('blog','tags');
define( 'TMPL_URI', get_template_directory_uri() );
$inc_prefix = explode( 'wp-content', TMPL_URI );
define( 'INC_PREFIX', 'wp-content'. $inc_prefix[1] );
define( 'SITE_NAME', get_bloginfo('name') );

// Define IS_HOME
if( is_home() || is_front_page() ) define( 'IS_HOME', true );
else  define( 'IS_HOME', false );

$web_uri = ($_SERVER['HTTP'] == 'on') ? 'https' : 'http' . '://'.$_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];
define('WEB_URI', $web_uri);

/**
 * Get theme Options.
 */
$theme_options = json_decode(get_option('theme-options'));

if( empty( $theme_options ) ) :
        /*
         * First Time Installation.
         */
        define( 'IS_FRESH', true );
else :
        define( 'IS_FRESH', false );
endif;

// Register menu.
register_nav_menus( array(
    'main_menu'     => __( 'Main Navigation' ),
    'footer_menu'   => __( 'Footer Navigation' )
));

// include(s).
include 'lib/admin-config.php';

if( is_admin() ):
    
    if( IS_FRESH ) :
        /**
         * Set basics
         */
        set_basics();
    endif;
    
    /**
     * Admin Side Functions
     */
    
    // Load essential files.
    wp_enqueue_style('admin_style', TMPL_URI.'/lib/css/style.css', array(), '1.0');
    wp_enqueue_script('admin_script', TMPL_URI.'/lib/js/script.js', array(), '1.0');
    
    add_action( 'admin_head', 'admin_head_fn' );
    
else:
    /*
     * Theme Side functions.
     */
    
    
    
endif;



# Functions.
# ----------

function set_basics() {
    global $wpdb;

    // Create database tables
    $query = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'contact_us` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` text NOT NULL,
            `email` varchar(60) NOT NULL,
            `twitter_id` varchar(60) NOT NULL,
            `message` longtext NOT NULL,
            `posted_date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;';
    // Execute Query
    $wpdb->query( $query );
    
    // post_visits`
    $query = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'post_visits` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `post_type` text NOT NULL,
                `count` int(11) NOT NULL,
                `last_visited_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;';
    // Execute Query
    $wpdb->query( $query );

    // subscribers
    $query = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'subscribers` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `email` varchar(60) NOT NULL,
                `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;';
    // Execute Query
    if( $wpdb->query( $query ) ) :
    
        // Set Theme Options.
        $theme_options_str = '{"general":{"pagination_type":"link","footer":{"text":"\u00a9 Copyrights 2015. All rights are reserved"},"header":{"logo":null}},"msgs":{"no_results":"Sorry! No results found.","no_search_results":"Sorry, No search results for {keyword}"},"social":{"fb_link":"http:\/\/facebook.com","tw_link":"http:\/\/twitter.com","gplus_link":"http:\/\/plus.google.com","in_link":"","insta_link":"","pin_link":"","youtube_link":"","tumblr_link":""},"misc":{"limits":{"read_more":"60","per_page":"10"}}}';
        update_option( 'theme-options' , $theme_options_str );
        
        
        // Set Default User Social links.
        $user_social_str = '{"fb_link":"http://www.facebook.com","tw_link":"http://www.twitter.com","gplus_link":"http://www.plus.google.com","in_link":"http://","insta_link":"http://","pin_link":"http://","youtube_link":"http://","tumblr_link":"http://"}';
        update_option( 'social-links' , $user_social_str );
        
        // Set Default Menu
        $query = "INSERT INTO `'.$wpdb->prefix.'terms` (`name`, `slug`, `term_group`) VALUES('main_menu', 'main_menu', 0)";
        
        // Set Defaukt User Description
        update_user_meta( get_current_user_id(), 'description', 'Hi, I\'m new author. I love to write lot of things.' );
        
    endif;

}

function admin_head_fn() {
    ?>
            <script type="text/javascript" >
                    jQuery(document).ready(function($){

                            /**
                            * Prevent 3rd - level menu
                            */
                           var isDragging = false;
                           $(document).on( 'mousedown', '.menu-item', function(){
                                   isDragging = false;

                           }).on( 'mousemove', '.menu-item', function(){
                                   isDragging = true;
                           }).on( 'mouseup', '.menu-item', function(){ 
                                   isDragging = false;
                                   
                                   window.setTimeout(function(){
                                       var max = 2
                                        ,  err = 0;
                                        $('.menu-item').each(function(){
                                            var accepted = false
                                            ,   $this = $(this);
                                            
                                            for( var i = 0; i < max; i++ ) {
                                                if( $this.hasClass( 'menu-item-depth-'+i ) ) {
                                                    accepted = true;
                                                }
                                            }
                                            
                                            if( !accepted ) {
                                                err++;
                                                $this.attr( 'class', 'menu-item menu-item-depth-'+(max-1)+' menu-item-category menu-item-edit-inactive' );
                                            

                                                // Replace Hidden value
                                                var $parent = $this.prevAll('.menu-item-depth-0:first')
                                                ,   $parentId = $parent.attr('id')
                                                ,   split = $parentId.split('-')
                                                ,   $thisSplit = $this.attr( 'id' ).split('-');   

                                                 $('input[name="menu-item-parent-id['+$thisSplit[2]+']"]').val(split[2]);
                                            }
                                            
                                        });
                                        
                                        if( err != 0 ) {
                                            alert( 'Not allowed for 3rd-level of hierarchy!' );
                                            return false;
                                        }
                                       
                                   }, 100);

                           });

                    });
            </script>
    <?php
}

function get_menu_name( $menu_key = 'main_menu') {
    $menu_locations = get_nav_menu_locations();
    
    if( !empty( $menu_locations[$menu_key] ) ) :
        $menu = get_term( $menu_locations[$menu_key], 'nav_menu' );
        return $menu->slug;
    endif;
    
    return '';

}
    
function get_var_name( $str = '' ) {
    return preg_replace( '/(\~\|\$|\%|\^|\&|\;|\`|\'|\.|\,|\-|\+|\=)/', '_', $str );
}

function user_social_links( $user_id ) {
    // User Social links.
    $user_social = json_decode( get_user_meta( $user_id, 'social-links', true ) ) ;
    
    $current_user = get_user_by( 'id', $user_id );
    $current_user_meta = get_user_meta( $user_id );

    $html = '<div class="socialProfile">';
    if( !empty( $user_social->fb_link ) ) : $html .= ' <a href="'.$user_social->fb_link.'" class="facbookLink" ><i class="fa fa-facebook"></i></a>'; endif;
    if( !empty( $user_social->tw_link ) ) : $html .= ' <a href="'.$user_social->tw_link.'" class="twitterLink"></i></a> '; endif;
    if( !empty( $user_social->gplus_link ) ) : $html .= '<a href="'.$user_social->gplus_link.'" class="gplusLink" ><i class="fa fa-google-plus"></i></a>'; endif;
    if( !empty( $user_social->youtube_link ) ) : $html .= '<a href="'.$user_social->youtube_link.'" class="youtubeLink"><i class="fa fa-youtube"></i></a>'; endif;
    if( !empty( $user_social->in_link ) ) : $html .= ' <a href="'.$user_social->in_link.'" class="linkedLink"><i class="fa fa-linkedin"></i></a>'; endif;
    if( !empty( $user_social->insta_link ) ) : $html .= ' <a href="'.$user_social->insta_link.'" class="instaLink "></i></a>'; endif;
    if( !empty( $user_social->pin_link ) ) : $html .= ' <a href="'.$user_social->pin_link.'" class="pinLink"><i class="fa fa-pinterest"></i></a> '; endif;
    if( !empty( $user_social->tumblr_link ) ) : $html .= '<a href="'.$user_social->tumblr_link.'" class="tumblrLink" ><i class="fa fa-tumblr"></i></a>'; endif;
    $html .= '</div>';
    
    return $html;
}

function get_limited_words( $content = '', $post = '' ){
    if( empty( $content ) ) return '';
    
    global $theme_options;
    $limit = $theme_options->misc->limits->read_more;
    
    // Drop <img>
    $content = preg_replace( '/(<img (.*?)>)|(<a (.*?)><img (.*?)><\/a>)|(<p><a (.*?)><img (.*?)><\/a><\/p>)/i', '', $content );
    
    if( strlen( $content ) > $limit ) return substr( $content, 0, $limit ).' <strong><a href="'.get_permalink( $post->ID ).'" class="read-more" title="Read More">...</a></strong>';
    else return $content;
} 

function get_post_comments( $post_id = '' ){
    global $wpdb;
    $query = "SELECT * FROM `".$wpdb->prefix."comments` WHERE `comment_approved` = '1' ";
    if( !empty($post_id) ) $query .= " AND `comment_post_ID` = '".$post_id."' ";
    $query .= ' ORDER BY `comment_date` DESC';
    return $wpdb->get_results( $query );
}

function get_post_visit_count($post_id = ''){
    global $wpdb;
    if(empty($post_id)):
        global $post;
        $post_id = $post->ID;
    endif;
    
    $query = "SELECT `count` AS count FROM `".$wpdb->prefix."post_visits` WHERE `post_id` = '".$post_id."'";
    $count = $wpdb->get_results($query);
    $count = $count[0]->count;
    if(empty($count)) return 0;
    else return $count;
}

function get_menu_html($menu_name = 'main_menu', $args = array(), $type = 0, $sb_ul_cls_names = '', $main_li_cls_names = ''){
	
    $html = '';
    $sb_mnu_first = true;
    $sb_mnu_htm = '';
    
    // Default args.
    if(empty($args)):
        $args = array(
            'order' => 'ASC', 
            'post_type' => 'nav_menu_item', 
            'post_status' => 'publish', 
            'output' => ARRAY_A, 
            'output_key' => 'menu_order', 
            'nopaging' => true, 
            'update_post_term_cache' => false
        );
    endif;
    
    $items = wp_get_nav_menu_items( $menu_name, $args );
    $items_count = count($items);
    
    if( !empty( $items ) ) :
        
        foreach($items as $k=>$item):

            /*
             * Get menu item url.
             */
            if($item->post_name == 'home') $menu_url = home_url('/');
            else $menu_url = get_permalink($item->object_id);

            // Main menu items
            if($item->menu_item_parent == 0):
                if( $item->url == WEB_URI ):
                    $class = 'active';
                else:
                    $class = '';
                endif;

                // Check childrens.

                // Only for desktop view
                $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
                if($type == 0):
                    if (empty($children)) $sb_mnu_class = '';
                    else $sb_mnu_class = 'class="'.$main_li_cls_names.'"';
                endif;

                $mn_li = '<li> <a href="'.$menu_url.'" title="'.$item->title.'" '.$class.'>'.$item->title.'</a>';

                if(!empty($sb_mnu_htm)):
                    $sb_mnu_first = true;
                    $html .= $sb_mnu_htm.'</ul></li>'.$mn_li;
                elseif(empty($children)):
                    $html .= $mn_li.'</li>';
                else:
                    $html .= $mn_li;
                endif;

                $sb_mnu_htm = '';
            else:
                // Sub menu items
                $li = '<li> <a href="'.$menu_url.'" title="'.$item->title.'" '.$class.'>'.$item->title.'</a> </li>';
                if($sb_mnu_first):
                // First Sub menu item.
                $sb_mnu_htm = '<ul class="'.$sb_ul_cls_names.'">'.$li; // for Mobile
                else:
                $sb_mnu_htm .= $li;
                endif;

                $sb_mnu_first = false;
            endif;

            if((($k+1) == $items_count) && !empty($sb_mnu_htm)):
                // Display, Once if Last Main menu item holds 'Sub menu'
                $html .= $sb_mnu_htm.'</ul></li>';
            endif;
        endforeach;
    endif;
    
    return $html;
}