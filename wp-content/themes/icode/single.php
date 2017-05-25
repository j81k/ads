<?php

/*
 * single.php 
 */
get_header();
$post_id = $post->ID;

/*
 * Update "Post Visit Count"
 */
$count = get_post_visit_count( $post_id );
if( $count == 0 ):
    $args   = array(
        'post_id'   => $post_id,
        'count'     => ++$count,
        'post_type' => get_post_type( $post_id )
    );
    
    $wpdb->insert( $wpdb->prefix.'post_visits', $args );
    
else:
    // Update Count.
    $count = ++$count;
    $query = "UPDATE `".$wpdb->prefix."post_visits` SET `count` = ".$count." WHERE `post_id` = ".$post_id;
    $wpdb->get_results( $query );
    
endif;

/*
 * Page Featured Image.
 */
$featured_image_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); 

/*
 * Get post category.
 */
$terms = get_the_terms( $post, 'category' );

/*
 * Get the Tags.
 */
$tags = get_the_tags();
//echo "<pre>Tags: "; print_r($post);

/*
 * Get the Author data.
 */
$author = get_userdata( $post->post_author );   
$author_meta = get_user_meta( $author->ID );


?>
<div class="container">
  <div class="row mainSection">
    <div class="col-xs-8 articlePost postMain">
      <div class="white-bg postContent">
        <h1><?php echo $post->post_title; ?></h1>
        <div class="detailPost clearfix"> 
            <span class="fL"><strong><em><?php echo date( "d M'y", strtotime( $post->post_modified ) ); ?></em></strong></span> 
            <?php
                if( !empty( $terms ) ) :
            ?>
            <span class="fR"><strong>Categories:</strong> 
                <?php
                    $terms_count = count( $terms );
                    $terms  = array_values( $terms );
                    foreach( $terms as $k=>$term ):
                        echo '<a href="'.get_term_link($term).'"><strong>'.$term->name.'</strong></a>';
                        if( $k != ( $terms_count-1 ) ) echo ', ';
                    endforeach;
                ?>
            </span> 
            <?php endif; ?>
        </div>
        <?php
            /*
             * The Page Excerpt.
             */
            echo wpautop(apply_filters('the_excerpt', $post->post_excerpt)); 
        ?>
        <figure class="mainIMG">
            <img src="<?php echo $featured_image_url; ?>" class="imgWid" alt=""/> 
        </figure>
        
        <?php
            /*
             * Check for Post Buttons
             */
             $post_buttons = json_decode( get_post_meta( $post->ID, 'post_buttons', true ) );
             if( !empty( $post_buttons ) ) :
                 ?>
                    <div class="demoDownload text-center"> 
                        <?php
                        foreach( $post_buttons as $k=> $post_button ) :
                                if( !empty( $post_button->button_url ) ) :
                                ?>
                                      <a href="<?php echo $post_button->button_url; ?>" class="btn <?php echo ( strtolower( $post_button->button_name ) == 'source' ) ? 'sourceBtn' : 'liveBtn'  ?>" <?php echo ( $post_button->button_target == 'on' ) ? 'target="_blank"' : '';  ?>><?php echo $post_button->button_name; ?></a>
                                <?php
                                endif;
                             endforeach;
                        ?>
                    </div>
                 <?php
             endif;
        
            /*
             * The Page content.
             */
            echo wpautop(apply_filters('the_content', $post->post_content)); 
            
            /*
             * Tags.
             */
            $tags_count = count( $tags );
            if( !empty($tags) && $tags_count ):
                ?>
                <div class="detailTags"> 
                    <span>
                        <strong>Tags:</strong> 
                        <?php
                            $tags_html = '';
                            foreach( $tags as $k => $tag ):
                                $tags_html .= '<a href="'. get_tag_link( $tag ). '">' .$tag->name. '</a>, ';
                            endforeach;
                            echo substr($tags_html, 0, -2);
                        ?>
                    </span> 
                </div>
                <?php
            endif;
        ?>
        <div class="shareIt">
          <ul class="clearfix threePlatform">
            <li><a id="fbShare" class="addthis_button_facebook" addthis:url="<?php echo get_permalink( $post->ID ); ?>"><i class="fa fa-facebook"></i>Share on Facebook</a></li>
            <li><a href="#" id="twShare" class="addthis_button_twitter" addthis:url="<?php echo get_permalink( $post->ID ); ?>"><i class="fa fa-twitter"></i>Share on Twitter</a></li>
            <li><a href="https://plus.google.com/share?url={<?php echo get_permalink( $post->ID ); ?>}" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" id="gpShare"><i class="fa fa-google-plus"></i>Share on Google+</a></li>
        </div>
      </div>
        <?php
            /*
             * Post - Blog
             */
             $args = array(
                 'post_type'    => 'blog',
                 'posts_per_page'=> -1,
                 'post_status'  => 'publish'
             );
             $blog_posts = get_posts( $args );
             $blog_posts_count = count( $blog_posts );
             
             if( $blog_posts_count > 1 ):
                 $next_post = get_next_post();
                 $prev_post = get_previous_post();
                 ?>
                 <div class="nextPrev clearfix">
                     <?php
                        if( !empty( $next_post ) ):
                     ?>
                     <a class="fL" href="<?php echo get_permalink($next_post->ID); ?>">
                                <i class="fa fa-backward"></i><?php echo $next_post->post_title; ?>
                            </a>     
                     <?php
                        endif;
                        
                        if( !empty( $prev_post ) ):
                     ?>
                     <a class="fR" href="<?php echo get_permalink($prev_post->ID); ?>">
                         <?php echo $prev_post->post_title; ?><i class="fa fa-forward"></i>
                     </a> 
                     <?php 
                        endif;
                     ?>
                 </div>
                 <?php
             endif;
      ?>
      <div class="white-bg bottomBar">
        <div class="viewProfile">
          <h2>About Author</h2>
          <div class="profileDesc"> 
              <?php 
                /*
                 * Author Image
                 */
              /*if( !user_avatar_avatar_exists( $author->ID ) ):
              ?>
                <img src="<?php echo  TMPL_URI; ?>/images/thumbnail1.jpg" alt=""/>
              <?php 
              else:  */ 
                //echo user_avatar_get_avatar( $author->ID, 50 );                
              //endif;
                echo get_avatar( $author->ID, 50 );
               ?>
            <h5><?php echo ucwords( $author->display_name ); ?></h5>
            <?php 
                echo wpautop( $author_meta['description'][0] ); 
                
                // Social Links.
                echo user_social_links( $author->ID );
           ?>     
          </div>
        </div>
          <?php
            /*
             * Author Posts
             */
            // Posts per page
            $per_page = $theme_options->misc->limits->per_page;
            if( empty( $per_page ) ) $per_page = 10;
            
            //$author_posts = get_the_author_posts($author->ID);
            $args = array(
                'post_type'    => 'post',
                'author'  => $author->ID,
                'post_status'  => 'publish',
                'posts_per_page'=> $per_page,
                'exclude'      => $post_id,
                'orderby'      => 'menu_order',
                'order'        => 'ASC'

            );
            $author_posts = get_posts( $args );
             
            if( !empty( $author_posts ) && count( $author_posts ) >0 ):
          ?>
        <div>
          <h2>Suggested Posts</h2>
          <ul class="suggestList">
              <?php
                foreach( $author_posts as $k=>$author_post ):
                    $author_post_img = wp_get_attachment_url( get_post_thumbnail_id( $author_post->ID ) );
                    if( empty( $author_post_img ) ) $author_post_img = TMPL_URI.'/images/thumbnail2.jpg'; 
                    else $author_post_img = TMPL_URI.'/thumb.php?src='.$author_post_img.'&w=60&h=60&zc=1';
                    ?>
                        <li>
                            <a href="<?php echo get_permalink( $author_post->ID ); ?>">
                                <img src="<?php echo $author_post_img; ?>" alt=""/>
                                <h4><?php echo $author_post->post_title; ?></h4>
                            <?php 
                                    $content = apply_filters('the_excerpt', $author_post->post_excerpt);
                                    if( empty( $content ) ) $content = get_limited_words( apply_filters('the_content', $author_post->post_content), $author_post );
                                    echo $content;
                            ?>
                            </a>
                        </li>
                    <?php
                endforeach;
              ?>
          </ul>
        </div>
          <?php
            endif;
          ?>
        <div>
        <?php 
            /*
             * Comments
             */
             $comments = get_post_comments( $post_id );
             if( !empty($comments) && count( $comments ) > 0 ) :
                 /*
                  * Check for Replies.
                  */
                 $comment_replies_arr = array();
                 foreach( $comments as $k=>$comment ) :
                    if( $comment->comment_parent != 0 ) :
                        // Reply
                        $comment_replies_arr[$comment->comment_parent][] = $comment;
                        // Unset Reply
                        unset( $comments[$k] );
                    endif;
                 endforeach;
        ?>
          <h2>Comments</h2>
          <div class="showComments" id="comments">
              <?php
                foreach( $comments as $k=>$comment ) :
                    $comment_date = date("d M'y", strtotime( $comment->comment_date ) );
                    ?>
                    <div>
                        <?php echo wpautop( str_replace( '\\', '', $comment->comment_content ) ); ?>
                        <span class="clearfix">
                            <a href="<?php echo $comment->comment_author_url; ?>">
                                <strong><?php echo ucwords($comment->comment_author); ?></strong>
                            </a> <em>Says</em> <i class="fa fa-reply"></i> 
                            <a class="fR replyLink" href="#" data-date="<?php echo $comment_date; ?>"><strong><?php echo $comment_date; ?></strong></a>
                        </span>
                        <div class="replyBox" id="comment-<?php echo $comment->comment_ID; ?>" >
                          <input type="text" placeholder="Name" class="comment-author req" data-type="name"/>
                          <input type="text" placeholder="Email or Twitter ID" class="comment-email" data-type="email"/>
                          <textarea rows="7" placeholder="Write a reply for <?php echo ucwords($comment->comment_author); ?>"></textarea>
                          <input class="btn" type="submit" value="Reply" data-id="<?php echo $comment->comment_ID; ?>" />
                        </div>
                        <?php
                            /*
                             * Replies.
                             */
                             if( !empty( $comment_replies_arr[$comment->comment_ID] ) ) :
                                 foreach( $comment_replies_arr[$comment->comment_ID] as $r=>$comment_reply ) :
                                    ?>
                                        <div class="replies">
                                            <?php echo wpautop( str_replace('\\', '', $comment_reply->comment_content ) ); ?>
                                            <span class="clearfix"><a href="<?php echo $comment_reply->comment_author_url; ?>"><strong><?php echo ucwords($comment_reply->comment_author); ?></strong></a> <em>replied</em></span>
                                        </div>
                                    <?php
                                 endforeach;
                                 ?>
                                 <?php
                             endif;
                        ?>
                      </div>
                    <?php
                endforeach;
                ?>
          </div>
          <?php
            endif;
          ?>
          <div id="comment-submit">
            <h3>Write here...</h3>
            <div class="formSection"> 
              <div class="formInput">
                <label><span>Name</span></label>
                <input type="text" class="comment-author req" data-type="name" />
              </div>
            </div>
            <div class="formSection">
              <div class="formInput" >
                <label><span>Email ID</span></label>
                <input type="text" class="comment-email req" data-type="email"/>
              </div>
            </div>
            <div class="formSection">
              <div class="formInput">
                <label><span>Twitter ID</span></label>
                <input type="text" placeholder="Optional" class="comment-twitter" data-type="twitter"/>
              </div>
            </div>
            <div class="formSection">
              <div class="formInput textBlock">
                <label><span>Comment</span></label>
                <textarea rows="7" class="req" data-type="message"></textarea>
              </div>
            </div>
            <div class="formSection text-right">
              <input type="submit" class="btn" id="comment-submitBtn"/>
            </div>
          </div>
        </div>
      </div>
    </div>
      <input type="hidden" value="<?php echo $post_id; ?>" id="hidden" />
        <?php
        /*
         * Display Sidebar
         */
        /*if( !empty( $theme_options->sidebars ) && in_array( 'single-'.get_post_type( $post_id ), $theme_options->sidebars ) ) :
            echo '<div class="col-xs-4 sideBar"><div class="col-xs-12">';
            dynamic_sidebar( 'single-'.get_post_type( $post_id ).'-sidebar' );
            echo '</div></div>';
        endif;
         * 
         */
        get_sidebar();
      ?>
    </div>
</div>
<?php
get_footer();
