<?php

/**
* Author		: Jai K
* Purpose		: Main Category (Post Type)
* Created On 	: 2017-05-14 19:57
*/

add_action('init', 'init_main_category');

function init_main_category(){
    
    $labels = array(
        "name" => "Main Categories",
        "singular_name" => "Main Category",
        "menu_name" => "Main Categories",
        "all_items" => "All Main Categories",
        "add_new" => "Add New",
        "add_new_item" => "New Main Category",
        "edit" => "Edit",
        "edit_item" => "Edit Main Category",
        "new_item" => "New Main Category",
        "view" => "View",
        "view_item" => "View Main Category",
        "search_items" => "Search Main Category",
        "not_found" => "No Main Category Found",
        "not_found_in_trash" => "No Main Category Found in Trash",
        "parent" => "Parent Main Category",
    );
    
    $args = array(
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "has_archive" => true,
        "show_in_menu" => true,
        "menu_position" => 7,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "rewrite" => array( "slug" => "categories/%main-category-tax%", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "revisions", "thumbnail", "excerpt", "menu-order" ), // 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'
        "taxonomies" => array("post_tag")
    );
    

    register_post_type( "main-category", $args );
    
    register_taxonomy('main-category-tax', 'main-category', array(
        'label'         => 'Categories',
        'singular_label'=> 'Category',
        'hierarchical'  => true,
        'query_var'     => true,
        'show_ui'       => true,
        'rewrite'       => array(
            'slug'      => 'main-category',
            'with_front'=> FALSE
        )
    ));
    
    add_action('add_meta_boxes', function(){
        
        add_meta_box('main-category-class', 'Total Post Counts', 'main_category_met_class', 'main-category');
    });
    
    function main_category_met_class($post){
        /*$args = array(
          'post_type'   => $post->post_name,
          'post_status'=> 'publish',
           'posts_per_page'=> -1
        );*/
        
        $total = get_option($post->post_name.'_total_posts');
        
        echo $post->post_title.': <b style="color: #f33;">'. ($total) . '</b>';//count(get_posts($args)) .'</b>';
        
       //echo '<input type="text" class="regular-text code" name="main_category_class" value="" placeholder="fa fa-home" />'; 
    }
    
    
    
}