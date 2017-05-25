<?php

/*
 * theme-widgets.php (lib/includes/)
 */

/**
 * Subscribers Widget.
 */
class Subscribers_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( 'subscribers-widget', 'Subscribers' );
    }
    
    function widget() { // $args, $instance
        ?>
            <div class="subscribeSide" id="subscribe">
                <h2>Subscribe Us</h2>
                <p>Join subscribe list and get latest update through Email</p>
                <input type="text" placeholder="Email address" id="subscribe-email"/>
                <div class="text-left"><input type="submit" value="Subscribe Me" class="btn"/></div>
            </div>
        <?php
    }
}

/**
 * Be Social Widget.
 */
class Be_Social_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( 'be-social-widget', 'Be Social' );
    }
    
    function widget() {
        global $post, $theme_options;
        
        /*
         * Get Social Theme-options.
         */
        $social_options = $theme_options->social;
        ?>
            <div class="beSocial">
                <h2>Be Social</h2>
                <div>
                    <a href="<?php echo $social_options->fb_link; ?>" id="facbookLink" target="_blank" ><i class="fa fa-facebook"></i></a>
                    <a href="<?php echo $social_options->tw_link; ?>" id="twitterLink" target="_blank" ><i class="fa fa-twitter"></i></a>
                    
                    <!-- G Plus -->
                    <a href="<?php echo $social_options->gplus_link; ?>" id="gplusLink" target="_blank" ><i class="fa fa-google-plus"></i></a>
                                
                    <?php if( !empty( $social_options->youtube_link ) ) : ?><a href="<?php echo $social_options->youtube_link; ?>" id="youtubeLink" target="_blank"><i class="fa fa-youtube"></i></a><?php endif; ?>
                    
                    <!-- Linked In -->
                    <?php if( !empty( $social_options->in_link ) ) : ?><a href="<?php echo $social_options->in_link; ?>" id="linkedLink" target="_blank"><i class="fa fa-linkedin"></i></a><?php endif; ?>
                    
                    
                    <?php if( !empty( $social_options->insta_link ) ) : ?><a href="<?php echo $social_options->insta_link; ?>" id="instaLink" target="_blank"><i class="fa fa-instagram"></i></a><?php endif; ?>
                    <?php if( !empty( $social_options->pin_link ) ) : ?><a href="<?php echo $social_options->pin_link; ?>" id="pinLink" target="_blank"><i class="fa fa-pinterest"></i></a><?php endif; ?> 
                    <?php if( !empty( $social_options->tumblr_link ) ) : ?><a href="<?php echo $social_options->tumblr_link; ?>" id="tumblrLink" target="_blank" ><i class="fa fa-tumblr"></i></a><?php endif; ?>   
                </div>
      </div>
        <?php
    }
    
}

/**
 * View Profile Widget.
 */
class View_Profile_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( 'view-profile-widget', 'View Profile' );
    }
    
    function widget() {
        /*
         * Get current user info.
         */
        $current_user_id = get_current_user_id();
        if( !empty( $current_user_id ) ) :
            $current_user = get_userdata( $current_user_id );
            $current_user_meta = get_user_meta( $current_user_id );
            
            /*
             * Get User Social Links
             */
            $user_social = json_decode( get_user_meta( $current_user_id, 'social-links', true ) ) ;
        ?>
            <div class="viewProfile">
                <h2>View Profile</h2>
                <div class="profileDesc">
                    <?php
                        
                        /**
                        * Avator Image
                        */
                        $avatar = get_avatar( $current_user_id, 50 );

                        if( !empty( $avatar ) ) :

                            // Avatar Image
                            echo $avatar;
                        else :

                            // Default Image
                    ?>
                               <img src="<?php echo  TMPL_URI; ?>/images/thumbnail1.jpg" alt=""/>
                    <?php
                        endif;
                    ?>    
                    <h5><?php echo ucfirst( $current_user->display_name ); ?></h5>
                    <?php echo wpautop( $current_user_meta['description'][0] ); ?>
                    <div class="socialProfile">
                        <a href="<?php echo $user_social->fb_link; ?>" id="facbookLink"><i class="fa fa-facebook"></i></a>
                        <a href="<?php echo $user_social->tw_link; ?>" id="twitterLink"><i class="fa fa-twitter"></i></a>
                        <a href="<?php echo $user_social->gplus_link; ?>" id="gplusLink"><i class="fa fa-google-plus"></i></a>
                        <?php if( !empty( $user_social->youtube_link ) ) : ?><a href="<?php echo $user_social->youtube_link; ?>" id="youtubeLink"><i class="fa fa-youtube"></i></a><?php endif; ?>
                        <?php if( !empty( $user_social->in_link ) ) : ?><a href="<?php echo $user_social->in_link; ?>" id="linkedLink"><i class="fa fa-linkedin"></i></a><?php endif; ?>
                        <?php if( !empty( $user_social->insta_link ) ) : ?><a href="<?php echo $user_social->insta_link; ?>" id="instaLink"><i class="fa fa-instagram"></i></a><?php endif; ?>
                        <?php if( !empty( $user_social->pin_link ) ) : ?><a href="<?php echo $user_social->pin_link; ?>" id="pinLink"><i class="fa fa-pinterest"></i></a><?php endif; ?> 
                        <?php if( !empty( $user_social->tumblr_link ) ) : ?><a href="<?php echo $user_social->tumblr_link; ?>" id="tumblrLink"><i class="fa fa-tumblr"></i></a><?php endif; ?>
                    </div>
                </div>
            </div> 
        <?php
        endif;
    }
}

/**
 * Sidebar Posts Widget.
 */
class Sidebar_Posts_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( 'sidebar-posts-widget', 'Sidebar Posts' );
    }
    
    function widget() {
        // Posts per page
        global $theme_options;
        $per_page = $theme_options->misc->limits->per_page;
        if( empty( $per_page ) ) $per_page = 10;

        /*
         * get all posts.
         */
        
        $args = array(
            'post_type'     => array('post'),
            'posts_per_page'=> $per_page,
            'post_status'   => 'publish',
            'orderby'       => 'post_modified',
            'order'         => 'DESC'
        );

        $posts = get_posts($args);
        $posts_count = count($posts);

        $hot_posts = $new_posts = $recommend_posts = array();
        if($posts_count > 0):
            foreach($posts as $k=>$post):
                $hot_posts[get_post_visit_count($post->ID).''.$k] = $post;
                $recommend_posts[$post->menu_order.''.$k] = $post;
            endforeach;
        endif;

        krsort($hot_posts);
        ksort($recommend_posts);
        
        if($posts_count > 0):
    ?>
        <div class="featurePosts">
            <div id="featureTab" class="owl-carousel">
                <?php 
                  if(count($hot_posts) > 0) :                
                ?>
                    <div class="item">
                        <h3>What's hot</h3>
                        <div class="featureList">
                            <?php 
                                foreach($hot_posts as $k=>$hot):
                                    $img_url = wp_get_attachment_url(get_post_thumbnail_id($hot->ID));
                                    if(empty($img_url)) $img_url = TMPL_URI.'/images/thumbnail2.jpg';
                                    else $img_url = TMPL_URI.'/thumb.php?src='.wp_get_attachment_url(get_post_thumbnail_id($hot->ID)).'&w=60&h=60';
                                    ?>
                                        <a href="<?php echo get_permalink($hot->ID); ?>" class="singlePost clearfix">
                                            <img src="<?php echo $img_url; ?>" alt="<?php echo $hot->post_title; ?>"/>
                                            <h5><?php echo $hot->post_title; ?></h5>    
                                        </a>
                                    <?php
                                endforeach;
                            ?>
                        </div>
                    </div>
                <?php
                  endif;

                  if( count($posts) > 0 ): 
                ?>
                    <div class="item">
                        <h3>what's new</h3>
                        <div class="featureList">
                            <?php 
                                foreach($posts as $k=>$post):
                                    $img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                    if(empty($img_url)) $img_url = TMPL_URI.'/images/thumbnail2.jpg';
                                    else $img_url = TMPL_URI.'/thumb.php?src='.wp_get_attachment_url(get_post_thumbnail_id($post->ID)).'&w=60&h=60';
                                    ?>
                                        <a href="<?php echo get_permalink($post->ID); ?>" class="singlePost clearfix">
                                            <img src="<?php echo $img_url; ?>" alt="<?php echo $post->post_title; ?>"/>
                                            <h5><?php echo $post->post_title; ?></h5>    
                                        </a>
                                    <?php
                                endforeach;
                            ?>
                        </div>
                    </div>
                <?php
                  endif;

                  if( count($recommend_posts) > 0 ):
                ?>
                    <div class="item">
                        <h3>what's recommend</h3>
                        <div class="featureList">
                            <?php 
                                foreach($recommend_posts as $k=>$recommend):
                                    $img_url = wp_get_attachment_url(get_post_thumbnail_id($recommend->ID));
                                    if(empty($img_url)) $img_url = TMPL_URI.'/images/thumbnail2.jpg';
                                    else $img_url = TMPL_URI.'/thumb.php?src='.wp_get_attachment_url(get_post_thumbnail_id($recommend->ID)).'&w=60&h=60';
                                    ?>
                                        <a href="<?php echo get_permalink($recommend->ID); ?>" class="singlePost clearfix">
                                            <img src="<?php echo $img_url; ?>" alt="<?php echo $recommend->post_title; ?>"/>
                                            <h5><?php echo $recommend->post_title; ?></h5>    
                                        </a>
                                    <?php
                                endforeach;
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php
      endif; // Owl-carosul count($posts)
    
    }
    
}

/**
 * Sponsores Widget.
 */
class Sponsores_Widget extends WP_Widget {
    private $sponsors_count = 2;
    
    function __construct() {
        parent::__construct( 'sponsores-widget', 'Sponsores' );
    }
    
    function form( $instance ){
        
        for( $i = 1; $i <= $this->sponsors_count; $i++ ) :
        ?>
            <div class="sponsors-form">
                <h4>Sponsor <?php echo $i; ?></h4>
                <input type="text" name="<?php echo $this->get_field_name('title-'.$i); ?>" id="sponsers-title" value="<?php echo $instance['title-'.$i]; ?>" placeholder="Title"/>
                <textarea name="<?php echo $this->get_field_name('content-'.$i); ?>" id="sponsers-area" placeholder="Enter the content"> <?php echo $instance['content-'.$i]; ?> </textarea>
            </div>
        <?php
        endfor;
    }
    
    function update( $new_instance, $old_instance ) {
        
        // Update
        $old_instance = array();
        for( $i = 1; $i <= $this->sponsors_count; $i++ ) :
            $old_instance['title-'.$i] = $new_instance['title-'.$i];
            $old_instance['content-'.$i] = $new_instance['content-'.$i];
        endfor;
        
        return $old_instance;
        
    }
    
    function widget( $args = '', $instance = '' ) {
        
        if( !empty( $instance ) && count( $instance ) > 0 ) :
        ?>
            <div class="sponsoredBy">
                <h2>Sponsored By</h2>
                <?php
                    for( $i = 1; $i <= $this->sponsors_count; $i++ ) :
                        echo $instance['content-'.$i];
                    endfor;
                ?>
            </div>
        <?php
        endif;    
    }
    
}

/**
 * Tags Widget.
 */
class Tags_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( 'Tags-widget', 'Tags' );
    }
    
    function widget() {
        global $post;
        
        $tags = get_the_tags( $post->ID );
        if( !empty( $tags ) ) :    
        ?>
            <div class="tagBlog">
                <h2>Tags</h2>
                <?php
                    foreach( $tags as $k => $tag ) :
                        echo '<a href="'.get_term_link( $tag ).'">'.$tag->name.'</a>';
                    endforeach;
                ?>
            </div>
        <?php
        endif;
    }
    
}


function widgets_auto_init_fn() {
        
       /*
        * Widgets
        */
       $widgets = array(
           array(
               'class'     => 'View_Profile_Widget',
               'id'        => 'view-profile-widget'
           ),
           array(
               'class'     => 'Be_Social_Widget',
               'id'        => 'be-social-widget'
           ),
           array(
               'class'     => 'Subscribers_Widget',
               'id'        => 'subscribers-widget'
           ),
           array(
               'class'     => 'Sidebar_Posts_Widget',
               'id'        => 'sidebar-posts-widget'
           ),array(
               'class'     => 'Tags_Widget',
               'id'        => 'tags-widget'
           ),
           array(
               'class'     => 'Sponsores_Widget',
               'id'        => 'sponsores-widget'
           ),
               
       );
        
        /**
         * Get Active Sidebars.
         */
        $active_sidebars = get_option( 'sidebars_widgets' );
        $count = count( $active_sidebars ) + 1;
        
        /*
         * Sidebars
         */
        $sidebars = array(
            array(
                'id'    => 'sidebar-widgets',
                'name'  => 'Sidebar Widgets',
                'before'=> '',
                'after' => ''
            )
        );
        
        /*
         * Register Sidebar's
         */
        foreach( $sidebars as $s => $sidebar ) :
                
                register_sidebar( $sidebar );
                
                // Register Widget's
                foreach( $widgets as $w => $widget ) :
                        
                        register_widget( $widget['class'] );
                    
                        $widget_id = $widget['id'];
                        $widget_content = array();
                        
                        // Widget content.
                        $content = get_option( 'widget_'.$widget_id );
                        if(is_array( $content ) ) :
                            $content_arr = array_values( $content );
                        endif;
                        
                        if( ( !empty($content) && !empty( $content_arr[0] ) ) ) :
                            
                            continue;
                        elseif( !is_active_widget( false, false , $widget_id ) && IS_FRESH ) :
                            continue;
                            
                        endif;
                        
                        /*if(is_array( $content ) ) :
                            $content_arr = array_values( $content );
                        //echo "<pre> Data: "; print_r( $content_arr ); die;
                            // Check it is deleted.
                            if( count( $content_arr[0] == 1 ) && !empty( $content ) ) :
                                // Widget is removed.
                                continue;
                            endif;
                        
                        endif;*/
                        
                        /*if( !empty($content) && !empty( $content_arr[0] ) ) :
                               // Widget is not empty. So don't fill by empty value.
                               continue;
                        else :
                                if( !is_active_widget( false, false , $widget_id ) ) :
                                    continue;
                                endif;
                                $content = array();
                        endif;*/
                        if( empty( $content ) ) :
                            $content = array();
                        endif;
                        
                        // Integrate to Sidebar.
                        $active_sidebars[$sidebar['id']][$w] = $widget_id.'-'.$count;
                        
                        $widget_content[$count] = $content;//array(); // array( 'text' => 'This is the Content' );
                        
                        // Update Widget Content.
                        
                        update_option( 'widget_'.$widget_id, $widget_content );
                        
                        $count++;
                endforeach;
                
                        
        endforeach;
        
        // Update Sidebars option.
        update_option( 'sidebars_widgets', $active_sidebars );
            
        if( IS_FRESH ) :

            // Reload Once
            header( 'Location: '.$_SERVER['PHP_SELF'] );
        endif;
}


add_action( 'widgets_init', 'widgets_auto_init_fn' );
//add_action( 'after_swicth_theme', 'widgets_auto_init_fn', 10, 2 );

