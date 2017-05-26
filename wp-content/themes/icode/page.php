<?php

/*
 * page.php
 */

get_header();
?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <div class="white-bg postContent">
            <h2><?php echo $post->post_title; ?></h2>
            <p><?php echo apply_filters('the_content', $post->post_content); ?></p>
        </div>    
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
