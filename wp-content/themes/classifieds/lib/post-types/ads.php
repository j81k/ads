<?php

/**
* Author		: Jai K
* Purpose		: Ad (Post Type)
* Created On 	: 2017-05-10 19:38
*/
//echo 'secs: ' .get_secs('00:01:10'); die;

add_action('init', 'init_ad');

function init_ad(){
    
    $labels = array(
        "name" => "Classifieds",
        "singular_name" => "Advertisement",
        "menu_name" => "Classifieds",
        "all_items" => "All Ads",
        "add_new" => "Add New",
        "add_new_item" => "New Ad/Sub category",
        "edit" => "Edit",
        "edit_item" => "Edit Advertisement",
        "new_item" => "New Advertisement",
        "view" => "View",
        "view_item" => "View Advertisement",
        "search_items" => "Search Advertisement",
        "not_found" => "No Advertisement Found",
        "not_found_in_trash" => "No Advertisement Found in Trash",
        "parent" => "Parent Advertisement",
    );
    
    $args = array(
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "has_archive" => true,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "rewrite" => array( "slug" => "category/%category-tax%", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "revisions", "thumbnail", "excerpt" ), // 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'
        "taxonomies" => array("post_tag")
    );
    

    register_post_type( "category", $args );
    
    register_taxonomy('category-tax', 'category', array(
        'label'         => 'Categories',
        'singular_label'=> 'Category',
        'hierarchical'  => true,
        'query_var'     => true,
        'show_ui'       => true,
        'rewrite'       => array(
            'slug'      => 'category',
            'with_front'=> FALSE
        )
    ));
    
    
    add_action('add_meta_boxes', 'meta_boxes_ad');
    function meta_boxes_ad(){
        add_meta_box('ad-parents', 'Sub Category', 'ad_attrib_meta_box', 'category', 'side', 'default');
    }
    
    function ad_attrib_meta_box($post){
        $pages = wp_dropdown_pages(array(
            'post_type' => 'category',
            'selected'  => $post->post_parent,
            'name'      => 'parent_id',
            'show_option_none' => _('(none)'),
            'sort_column'=> 'menu_order, post_title',
            'echo'      => 0
        ));
        
        echo $pages;
        
    }
}