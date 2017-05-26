<?php

/**
* Author		: Jai K
* Purpose		: Main & common functions
* Created On 	: 2017-05-06 22:18
*/

define('MAX_CHAR',  100);
define('PER_PAGE',  10);

define('SITE_NAME', get_bloginfo('name'));
define('IS_HOME', (is_home() || is_front_page()) ? TRUE : FALSE); 

define('IS_LOGGED', is_user_logged_in() ? TRUE : FALSE);
define('TMPL_URI', get_template_directory_uri());
#define('INC_PREFIX', 'wp-content'. explode( 'wp-content', TMPL_URI )[1]);
define('SITE_URL', site_url('/'));

show_admin_bar(false);
error_reporting(E_ERROR);
add_theme_support('post-thumbnails');
add_post_type_support('page', 'excerpt');
register_nav_menu('main_menu', 'Main Menu Navigation');


#Functions

function get_breadcumb_html($type = '', $class = ''){
    global $post;
    
    $html = '<div class="bread-crumb '. $class .'"><ul>';
    $html .= '<li><a href="'. SITE_URL .'"><i class="fa fa-home"></i>Home</a></li>';
    
    if( $type == 'sub-cat' || $type == 'single' ) :
        $html .= '<li> / <a href="'. SITE_URL .'categories/main-category/'.$post->post_type .'/"><i class="fa fa-crosshairs"></i>'. ucfirst( $post->post_type ) .'</a></li>';
    
        $active_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        $html .= '<li> / <i class="fa fa-superpowers"></i>'. $active_term->name .'</li>';
    elseif( $post->post_type == 'main-category' ) :
        $html .= '<li> / <i class="fa fa-crosshairs"></i>'. $post->post_title .'</li>';
    endif;
    
    $html .= '</ul></div>';
    
    //echo 'Path: '. $html;
    //echo '<pre>Bre:'; print_r($post); die;
    
    return $html;
}

function get_states($is_html = FALSE){
    
    /*return [
        'Andra Pradesh',
        'Arunachal Pradesh',
        'Assam',
        'Bihar',
        'Chhattisgarh',
        'Goa',
        'Gujarat',
        'Haryana',
        'Himachal Pradesh',
        'Jammu and Kashmir',
        'Jharkhand',
        'Karnataka',
        'Kerala',
        'Madya Pradesh',
        'Maharashtra',
        'Manipur',
        ''
    ];*/
    $args = array(
        'taxonomy'      => 'geo-tax',
        'hide_empty'    => FALSE,
        'posts_per_page'=> -1,
        //'order_by'      => 'menu_order'
    );
    
    $states = get_terms($args);
    
    if( $is_html ) :
        $html = '<option value="" readonly class="readonly" >-- Select the State --</option>';
        foreach( $states as $k => $state ) :
            $html .= '<option value="'. $state->term_id .'"'.($state->parent !== 0 ? 'style="color: #666; font-weight: bold;"' : '') . '>'. $state->name .'</option>';
        endforeach;
        
        return $html;
    else :
        return $states;
    endif;
    
    
}

function getCities($state_id, $is_html = FALSE) {
    
    $args = array(
        'post_type' => 'geo',
        'post_status'=> 'publish',
        'order_by'  => 'post_title',
        'posts_per_page'=> -1,
        'tax_query' => array(
            array(
                'taxonomy'  => 'geo-tax',
                'field'     => 'id',
                'terms'     => $state_id
            )
        )
    );
    
    $cities = get_posts($args);
    
    //echo '<pre>'; print_r( $cities ); die;
    
    if( $is_html ) :
        $html = '<option value="" readonly class="readonly" >-- '. ( count( $cities ) > 0 ? 'Select the City' : 'Sorry, No Cities found!' ) .' --</option>';
        foreach( $cities as $k => $city ) :
            $html .= '<option value="'. $city->ID .'" >'. $city->post_title .'</option>';
        endforeach;
        
        return $html;
    else :
        return $cities;
    endif;
    
    
}

function get_main_categories(){
    $args =array(
        'post_type'     => 'main-category',
        'post_status'   => 'publish',
        'posts_per_page'=> -1,
        'order_by'      => 'menu_order',
        'order'         => 'ASC'
    );
    
    return get_posts($args);
    
}



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

if( is_admin() ) :
    /*
     * admin
     */
    if( IS_FRESH ) :
        /**
         * Set basics
         */
        set_basics();
    endif;

    //add_action('init', function(){
        
    //});
    
endif;

require 'lib/admin-config.php';


function set_basics(){
    global $wpdb;
    
    // Create Main Category table
    /*$sql = "CREATE TABLE IF NOT EXISTS `". $wpdb->prefix ."main_categories` (
            `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `mcat_name` varchar(255) NULL,
            `mcat_slug` text NULL,
            `mcat_icon` varchar(255) NULL,
            `mcat_desc` mediumtext NULL,
            `mcat_total_count` int NULL DEFAULT '0' COMMENT 'Total No. of posts in this category',
            `mcat_status` int(2) NULL DEFAULT '1' COMMENT '0-Inactive, 1-Active, 2-deleted',
            `created_on` datetime NULL
          ) COMMENT='' ENGINE='InnoDB';";
    
    $wpdb->query($sql);*/
    
    // Set Theme Options.
    $theme_options_str = '{"general":{"pagination_type":"link","footer":{"text":"\u00a9 Copyrights 2015. All rights are reserved"},"header":{"logo":null}},"msgs":{"no_results":"Sorry! No results found.","no_search_results":"Sorry, No search results for {keyword}"},"social":{"fb_link":"http:\/\/facebook.com","tw_link":"http:\/\/twitter.com","gplus_link":"http:\/\/plus.google.com","in_link":"","insta_link":"","pin_link":"","youtube_link":"","tumblr_link":""},"misc":{"limits":{"read_more":"60","per_page":"10"}}}';
    //#update_option( 'theme-options' , $theme_options_str );
    
}


function get_menu_html($menu_name = 'main_menu', $args = array(), $type = 0, $li_ul_cls_names = 'clearfix subChild', $li_sub_cls_names = ''){
    $htm = '';
    global $wpdb;
    global $wp_query;
    $obj    = $wp_query->get_queried_object();
    $current_page_id = $obj->ID;
    
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
            
    $items = wp_get_nav_menu_items($menu_name, $args);
    $items_cnt = count($items);
    
    $sb_mnu_first = true;
    $sb_mnu_htm = '';
    
    /*
     * Find Active Sub Menu item Parent id.
     */
    $query = "SELECT * FROM `".$wpdb->prefix."postmeta` WHERE `meta_key` = '_menu_item_object_id' AND `meta_value` = '".$current_page_id."'";
    $menu_item_parent = $wpdb->get_results($query);
    if(count($menu_item_parent) > 0):
        foreach($menu_item_parent as $k=>$item):
            $query = "SELECT * FROM `".$wpdb->prefix."postmeta` WHERE `meta_key` = '_menu_item_menu_item_parent' AND `post_id` = '".$item->post_id."'";
            $menu_item_obj_parent = $wpdb->get_results($query);
            foreach($menu_item_obj_parent as $q=>$parent_item):
                if($parent_item->meta_value):
                    $parent_menu_id = $parent_item->meta_value;
                    break;
                endif;
            endforeach;
        endforeach;
    endif;
    
    foreach($items as $k=>$item):
        //echo "<pre>"; print_r($item); 
        /*
         * Get menu item url.
         */
        if($item->post_name == 'home') $menu_url = home_url('/');
        // By pass "sign out" menu, once if the user not logged in.
        elseif( $item->attr_title == 'sign-out' && is_user_logged_in() )   $menu_url = wp_logout_url( home_url( '/' ) );
        else $menu_url = get_permalink($item->object_id);
        
        /*
         * Active menu.
         */
        if($current_page_id == $item->object_id || $item->ID == $parent_menu_id)  $active = 'class="active"';
        else $active = '';

        if($item->menu_item_parent == 0):
            // Main menu items
            // Check childrens.
            $children = get_posts(array('post_type' => 'nav_menu_item', 'post_status' => 'publish', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
            $mn_li = '<li ';
            if(!empty($children)) $mn_li .= ' class="'.$li_sub_cls_names.'" ';
            $mn_li .='> <a '.$active.' href="'.$menu_url.'" title="'.$item->title.'" >'.$item->title.'</a>';

            if(!empty($sb_mnu_htm)):
                $sb_mnu_first = true;
                $htm .= $sb_mnu_htm.'</ul></li>'.$mn_li;
            elseif(empty($children)):
                $htm .= $mn_li.'</li>';
            else:
                $htm .= $mn_li;
            endif;

            $sb_mnu_htm = '';
       else:
            // Sub menu items
           
            $li = '<li> <a '.$active.' href="'.$menu_url.'" title="'.$item->title.'">'.$item->title.'</a> </li>';
            if($sb_mnu_first):
                // First Sub menu item.
                $sb_mnu_htm = '<ul class="'.$li_ul_cls_names.'">'.$li; // for Mobile
            else:
                $sb_mnu_htm .= $li;
            endif;

            $sb_mnu_first = false;

        endif;

        if((($k+1) == $items_cnt) && !empty($sb_mnu_htm)){
            // Display, Once if Last Main menu item holds 'Sub menu'
            $htm .= $sb_mnu_htm.'</ul></li>';
        }
    endforeach;

    return $htm;
}



/*
 * Common functions
 */

function get_var_name( $str = '' ) {
    return strtolower(preg_replace( '/(\~\|\$|\%|\^|\&|\;|\`|\'|\.|\,|\-|\+|\=)/', '_', $str ));
}

function get_secs($time){
    $e = explode(':', $time); // 20:08:56
    $e = array_reverse($e);
    $secs = $e[0];
    unset($e[0]);
    foreach($e as $k=>$digits):
        $incr = 1;
        for($i=0; $i<$k; $i++):
            $incr *= 60; 
        endfor;
        $secs += $digits*$incr;
    endforeach;
    
    return $secs;
}

function get_max_chars($str){
    if( strlen($str) > MAX_CHAR ) :
        return substr($str, 0, MAX_CHAR) . ' ...';
    endif;
    return $str;
}

