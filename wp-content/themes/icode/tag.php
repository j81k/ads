<?php

/*
 * tag.php
 */

get_header();
$page_post = $post;

/*
 * Get Active term.
 */
if( is_tag() ) :
        
        $tag_id = get_query_var( 'tag_id' );
        $terms = get_terms( 'post_tag', 'include='. $tag_id );
        $active_term = $terms[0];
endif;

?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <div class="browseTC">
          <h1>Browse Tag: <?php echo $active_term->name; ?></h1>
        </div>
          <?php
            /*
             * Get all posts under this Tag. 
             */
             
             $args = array(
                 'post_type'    => 'post',
                 'post_status'  => 'publish',
                 'posts_per_page'=> -1,
                 'tax_query'    => array( 
                     array(
                        'taxonomy' => 'post_tag',
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