<?php


/*
 * Document: Home
 */
get_header();

$page_post = $post;

/*
 * Get all posts. 
 */
$args = array(
    'post_type'     => array('post'),
    'posts_per_page'=> -1,
    'post_status'   => 'publish',
    'orderby'       => 'post_modified',
    'order'         => 'DESC'
);

?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <?php
            $is_loader = false;
            include 'includes/list-posts.php';
        ?>
      </div>
    </div>
    <?php
        /*
         * Display Sidebar
         */
        
         get_sidebar();
      ?>
  </div>
</div>
<?php
get_footer();
