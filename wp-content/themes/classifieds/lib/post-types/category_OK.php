<?php

/**
* Author		: Jai K
* Purpose		: Category (Post Type)
* Created On 	: 2017-05-10 19:38
*/

add_action('init', 'init_category');

function init_category(){
    
    $labels = array(
        "name" => "Category",
        "singular_name" => "Category",
        "menu_name" => "Category",
        "all_items" => "All Category",
        "add_new" => "Add New",
        "add_new_item" => "Add New Category",
        "edit" => "Edit",
        "edit_item" => "Edit Category",
        "new_item" => "New Category",
        "view" => "View",
        "view_item" => "View Category",
        "search_items" => "Search Category",
        "not_found" => "No Category Found",
        "not_found_in_trash" => "No Category Found in Trash",
        "parent" => "Parent Category",
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
        "supports" => array( "title", "revisions", "thumbnail", "excerpt" ), // 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'
        "taxonomies" => array("post_tag")
    );
    

    register_post_type( "category", $args );
    
    register_taxonomy('category-tax', 'category', array(
        'label'         => 'Main Category',
        'singular_label'=> 'Main Category',
        'hierarchical'  => true,
        'query_var'     => true,
        'show_ui'       => true,
        'rewrite'       => array(
            'slug'      => 'category',
            'with_front'=> FALSE
        )
    ));
    
    
    add_action('add_meta_boxes', 'meta_boxes_category');
    function meta_boxes_category(){
        add_meta_box('category-parents', 'Categories', 'category_attrib_meta_box', 'category', 'side', 'default');
    }
    
    function category_attrib_meta_box($post){
        $pages = wp_dropdown_pages(array(
            'post_type' => 'category',
            'selected'  => $post->post_parent,
            'name'      => 'parent_id',
            'show_option_none' => _('(no category)'),
            'sort_column'=> 'menu_order, post_title',
            'echo'      => 0
        ));
        
        echo $pages;
        
    }
}