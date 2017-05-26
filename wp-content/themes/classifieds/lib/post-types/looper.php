<?php

/**
* Author		: Jai K
* Purpose		: looper (Create Dynamic Post Type)
* Created On 	: 2017-05-14 20:07
*/
//echo 'secs: ' .get_secs('00:01:10'); die;

add_action('init', function(){
    $args = array(
        'post_type'     => 'main-category',
        'post_status'   => 'publish',
        'posts_per_page'=> -1,
        'orderby'       => 'menu_order',
        'order'         => 'DESC'
    );

    $post_types = get_posts($args);

    foreach( $post_types as $k => $post_type ) :
        $post_type_name = $post_type->post_title;
        $post_type_slug = $post_type->post_name;

    
        $labels = array(
            "name" => $post_type_name,
            "singular_name" => $post_type_name,
            "menu_name" => $post_type_name,
            "all_items" => "All ". $post_type_name,
            "add_new" => "Add New",
            "add_new_item" => "New ". $post_type_name,
            "edit" => "Edit",
            "edit_item" => "Edit ".$post_type_name,
            "new_item" => "New ".$post_type_name,
            "view" => "View",
            "view_item" => "View ".$post_type_name,
            "search_items" => "Search ".$post_type_name,
            "not_found" => "No ". $post_type_name ." Found",
            "not_found_in_trash" => "No ". $post_type_name ." Found in Trash",
            "parent" => "Parent ".$post_type_name,
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
            "rewrite" => array( "slug" => $post_type_slug . "/%". $post_type_slug ."-tax%", "with_front" => true ),
            "query_var" => true,
            "supports" => array( "title", "editor", "revisions", "thumbnail", "excerpt" ), // 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'
            "taxonomies" => array("post_tag")
        );


        register_post_type( $post_type_slug, $args );

        register_taxonomy($post_type_slug . '-tax', $post_type_slug, array(
            'label'         => 'Sub Categories',
            'singular_label'=> 'Sub Category',
            'hierarchical'  => true,
            'query_var'     => true,
            'show_ui'       => true,
            'rewrite'       => array(
                'slug'      => $post_type_slug,
                'with_front'=> FALSE
            )
        ));


        /*add_action('add_meta_boxes', 'meta_boxes_ad');
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

        }*/
    endforeach;
});