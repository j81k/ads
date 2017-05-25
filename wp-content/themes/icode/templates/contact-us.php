<?php

/*
 * Template Name: Contact Us
 */
get_header();

// Assign page post to avoid to override by other.
$page_post = $post;

?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <h1><?php echo $post->post_title; ?></h1>
        <?php echo wpautop( apply_filters( 'the_content', $post->post_content ) ); ?>
        <div>
            <form method="post" data-attr="contact" class="form">
          <div class="formSection"> 
            <div class="formInput">
              <label><span>Name</span></label>
              <input type="text" placeholder="Jas" class="req" name="name" data-type="name"/>
            </div>
          </div>
          <div class="formSection">
            <div class="formInput">
              <label><span>Email ID</span></label>
              <input type="text" placeholder="jas@icodeblog.com" class="req" name="email" data-type="email"/>
            </div>
          </div>
          <div class="formSection">
            <div class="formInput">
              <label><span>Twitter ID</span></label>
              <input type="text" placeholder="Optional" name="twitter-id"/>
            </div>
          </div>
          <div class="formSection">
            <div class="formInput textBlock">
              <label><span>Message</span></label>
              <textarea rows="7" placeholder="Write me your feedback..." class="req" name="message" data-type="message"></textarea>
            </div>
          </div>
          <div class="formSection text-right">
            <input type="submit" class="btn" value="Send" />
          </div>
                </form>
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