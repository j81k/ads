<?php

/*
 * 404.php (Page Not Found)
 */

get_header();
?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <div class="white-bg postContent">
            <h2>404 Page Not Found</h2>
            <p>The page you have requested is not found! Please try again from <a href="<?php echo site_url('/'); ?>" title="Go to Home" >here.</a> </p>
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
