<?php

/*
 * taxonomy-blog-tax.php
 */

//get_header();
echo 'Services Taxonomy Landing Bloh'; die;

$page_post = $post;

/*
 * Get Active term.
 */
$active_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

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
             * Get all blog under this category. 
             */
             
             $args = array(
                 'post_type'    => 'blog',
                 'post_status'  => 'publish',
                 'posts_per_page'=> -1,
                 'tax_query'    => array( 
                     array(
                        'taxonomy' => 'blog-tax',
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
        if( !empty( $theme_options->sidebars ) && in_array( 'blog-landing', $theme_options->sidebars ) ) :
            echo '<div class="col-xs-4 sideBar"><div class="col-xs-12">';
            dynamic_sidebar( 'blog-landing-sidebar' );
            echo '</div></div>';
        endif;
     ?>   
  </div>
</div>
<?php
get_footer();