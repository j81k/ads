<?php

/* 
 * taxonomy-category-tax.php
 */

echo 'Tax: main Cat taxonomo!'; die;

/*
 * Get Active term.
 */
$active_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );




//echo 'Tax: <pre>'; print_r( $active_term ); die;
/*
* Get all blog under this category. 
*/

$args = array(
    'post_type' => 'category',
    'post_status'=> 'publish',
    'posts_per_page'=> -1,
    'tax_query' => array(
        'taxonomy'  => 'category-tax',
        'field'     => 'term_id',
        'terms'     => $active_term->term_id
    )
);

$results = get_posts($args);

//echo '<pre>'; print_r( $results ); die;

foreach( $results as $k => $result ) :
    echo '<br>Link: <a href="'.get_permalink( $result->ID ).'" target="_blank">'. get_permalink( $result->ID ).'</a>';
    
endforeach;