<?php

/**
* Author		: Jai K
* Purpose		: Geo (Post Type)
* Created On 	: 2017-05-25 19:57
*/

add_action('init', 'init_geo');

function init_geo(){
    
    $labels = array(
        "name" => "Cities",
        "singular_name" => "City",
        "menu_name" => "Cities",
        "all_items" => "All Cities",
        "add_new" => "Add New",
        "add_new_item" => "New City",
        "edit" => "Edit",
        "edit_item" => "Edit City",
        "new_item" => "New City",
        "view" => "View",
        "view_item" => "View City",
        "search_items" => "Search City",
        "not_found" => "No City Found",
        "not_found_in_trash" => "No City Found in Trash",
        "parent" => "Parent City",
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
        "rewrite" => array( "slug" => "cities/%geo-tax%", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "revisions", "thumbnail", "excerpt", "menu-order" ), // 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'
        "taxonomies" => array("post_tag")
    );
    

    register_post_type( "geo", $args );
    
    register_taxonomy('geo-tax', 'geo', array(
        'label'         => 'States',
        'singular_label'=> 'State',
        'hierarchical'  => true,
        'query_var'     => true,
        'show_ui'       => true,
        'rewrite'       => array(
            'slug'      => 'geo',
            'with_front'=> FALSE
        )
    ));
    
}