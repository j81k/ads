<?php

/**
* Author		: Jai K
* Purpose		: Files to be include at admin side
* Created On 	: 2017-05-10 19:33
*/

//include 'post-types/parent.php';
include_once 'post-types/main-category.php';
include_once 'post-types/looper.php';

include_once 'post-types/geo.php';


/*function save_post_fn($post_id){
    global $post;
    
    // Check is Revision
    if( wp_is_post_revision($post_id) || empty($post) ) 
        return;
    
    if( $post->post_status == 'draft' ) :
        // Increase Post Count 
        echo '++';
    
    endif;
    
    echo '<pre>Post: '; print_r( $post );
     
        echo 'Current: '. get_post_type($post_id); die;
    
}

add_action('save_post', 'save_post_fn');
*/

function trans_post_status_fn($new_status, $old_status, $post) {
    
    if( !isset($post->post_type) || $new_status == 'auto-draft' || ($new_status == 'publish' && $old_status == 'publish') )
        return;

    $total = get_option($post->post_type.'_total_posts'); //get_post_meta( $post->ID, $post->post_type.'_total_posts', TRUE);

    if( $new_status == 'publish' && $old_status != 'publish' ) : //  && $old_status == 'auto-draft'

        $total = !empty($total) ? $total : 0;
        ++$total;
    elseif( $old_status == 'publish' ) :
        --$total;
    endif;

    update_option($post->post_type.'_total_posts', $total);  //update_post_meta( $post->ID, $post->post_type.'_total_posts', $total );
}

add_action('transition_post_status', 'trans_post_status_fn', 10, 3);

// ----------------------------------------------------------------------------

//include_once 'post-types/ads.php';
//include_once 'post-types/item.php';

/*
add_action( 'init', 'wpa70679_custom_types' );

function wpa70679_custom_types() {

    $labels = array(
        'name'          => _x('Categories', 'Post type general name'),
        'singular_name' => _x('Category', 'Post type singular name'),
        'add_new'       => _x('Add New', 'Category'),
        'add_new_item'  => _x('Add New', 'Category'),
        'edit_item'     => _x('Edit Item', 'Category'),
        'new_item'      => _x('New Item', 'Category'),
        'view_item'     => __('View Category'),
        'search_items'   => __('Search Category'),
        'not_found'     => __('No Category found'),
        'not_found_in_trash'=> __('No log found in Trash'),
        'parent_item_colon'=> ''
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'hierarchical'           => true,
        'menu_position'         => 7,
        'capability_type'       => 'post',
        'rewrite'               => array(
            //'slug' => '', 
            //'slug' => 'cat', 
            'with_front' => FALSE
        ),
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'taxonomies'            => array('post_tag')
    );
    
    register_post_type('category', $args);
    
}


add_action('init', 'wpreg_i');
function wpreg_i(){

    register_post_type( 'child_type',
        array(
            'public' => true,
            'show_in_menu' => 'edit.php?post_type=category',
            'labels' => array(
                'name' => 'Child post type'
            )
        )
    );

}
*/

# Functions.add_filter('post_link', 'post_link_modifier', 1, 3);
add_filter('post_type_link', 'post_link_modifier', 1, 3);

function post_link_modifier($permalink, $post, $leave_name){
    
    $post_type = get_post_type($post->ID);
    if(!$post || empty($post_type)) return $permalink;
    
    $terms = wp_get_object_terms($post->ID, $post_type.'-tax');
    if( is_wp_error($terms) ) : return $permalink;
    elseif( empty($terms) || !is_object($terms[0])) : $terms[0]->slug = $post_type;
    /*else :
        if( $terms[0]->parent == 0 ) :
            $terms[0]->slug .= '/'.$terms[1]->slug;
        else :
            $terms[0]->slug = $terms[1]->slug . '/'.$terms[0]->slug;
        endif;
        
    */
    endif;
    
    //echo "<pre>Terms"; print_r($terms); die;
    return str_replace('%'.$post_type.'-tax%', $terms[0]->slug, $permalink);
}

/*
add_action( 'init', 'my_website_add_rewrite_tag' );
function my_website_add_rewrite_tag() {
    // defines the rewrite structure for 'chapters', needs to go first because the structure is longer
    // says that if the URL matches this rule, then it should display the 'chapters' post whose post name matches the last slug set
    add_rewrite_rule( '^authors/([^/]*)/([^/]*)/([^/]*)/?','index.php?chapters=$matches[3]','top' );
    // defines the rewrite structure for 'books'
    // says that if the URL matches this rule, then it should display the 'books' post whose post name matches the last slug set
    add_rewrite_rule( '^authors/([^/]*)/([^/]*)/?','index.php?books=$matches[2]','top' );   
}

// this filter runs whenever WordPress requests a post permalink, i.e. get_permalink(), etc.
// we will return our custom permalink for 'books' and 'chapters'. 'authors' is already good to go since we defined its rewrite slug in the CPT definition.
add_filter( 'post_type_link', 'my_website_filter_post_type_link', 1, 4 );
function my_website_filter_post_type_link( $post_link, $post, $leavename, $sample ) {
    switch( $post->post_type ) {

        case 'books':

            // I spoke with Dalton and he is using the CPT-onomies plugin to relate his custom post types so for this example, we are retrieving CPT-onomy information. this code can obviously be tweaked with whatever it takes to retrieve the desired information.
            // we need to find the author the book belongs to. using array_shift() makes sure only one author is allowed
            if ( $author = array_shift( wp_get_object_terms( $post->ID, 'authors' ) ) ) {
                if ( isset( $author->slug ) ) {
                    // create the new permalink
                    $post_link = home_url( user_trailingslashit( 'authors/' . $author->slug . '/' . $post->post_name ) );
                }
            }

            break;

        case 'chapters':

            // I spoke with Dalton and he is using the CPT-onomies plugin to relate his custom post types so for this example, we are retrieving CPT-onomy information. this code can obviously be tweaked with whatever it takes to retrieve the desired information.
            // we need to find the book it belongs to. using array_shift() makes sure only one book is allowed
            if ( $book = array_shift( wp_get_object_terms( $post->ID, 'books' ) ) ) {

                // now to find the author the book belongs to. using array_shift() makes sure only one author is allowed
                $author = array_shift( wp_get_object_terms( $book->term_id, 'authors' ) );

                if ( isset( $book->slug ) && $author && isset( $author->slug ) ) {
                    // create the new permalink
                    $post_link = home_url( user_trailingslashit( 'authors/' . $author->slug . '/' . $book->slug . '/' . $post->post_name ) );
                }

            }

            break;

    }
    return $post_link;
}*/