<?php

/*
 * category.php
 */

get_header();
$page_post = $post;

/*
 * Get Active term.
 */
$cat = get_query_var( 'cat' );
$active_term = get_category( $cat );
?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <div class="browseTC">
          <h1>Browse Category: <?php echo $active_term->name; ?></h1>
        </div>
          <?php
            /*
             * Get all posts under this category. 
             */
             
             $args = array(
                 'post_type'    => 'post',
                 'post_status'  => 'publish',
                 'posts_per_page'=> -1,
                 'tax_query'    => array( 
                     array(
                        'taxonomy' => 'category',//get_query_var( 'taxonomy' ),
                        'terms'    => $active_term->term_id,
                        'field'    => 'term_id'
                     )
                 )
             );
             
             $is_loader = false;
             include 'includes/list-posts.php';
          ?>
         </div>
    </div>
    <?php  
       /**
       * Get Sidebar.
       */
        get_sidebar();
     ?>   
  </div>
</div>
<?php
get_footer();