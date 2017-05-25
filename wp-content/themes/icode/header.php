<?php

/*
 * header.php
 */

/*
 * Page title.
 */
if( IS_HOME )
    $page_title = SITE_NAME;
else if( is_404() )
    $page_title = 'Page not found | '.SITE_NAME;
else 
    $page_title = $post->post_title . ' | ' .SITE_NAME;

/*
* Get Social Theme-options.
*/
$theme_options = json_decode(get_option('theme-options'));
$social_options = $theme_options->social;
$general_options = $theme_options->general;

$header_logo = $general_options->header->logo;
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $page_title; ?></title>
<link href="<?php echo TMPL_URI; ?>/images/favicon.png" rel="icon">
<?php
    
    /**
     * Enqueue Styles.
     */

     $styles = array( 'css/bootstrap', 'css/font-awesome.min', 'css/jquery-ui.min', 'css/owl.carousel', 'css/style', 'css/media', 'style' );
     foreach( $styles as $s => $style ) :
         wp_enqueue_style( 'style-'.$s, TMPL_URI .'/'. $style . '.css', '', '1.0', 'all' );
     endforeach;
     
    /**
     * Enqueue Scripts.
     */

     $scripts = array( 'jquery.min', 'bootstrap.min', 'smoothscroll', 'jquery.matchHeight-min', 'jquery-ui.min', 'owl.carousel.min', 'common', 'script', 'addthis' );
     foreach( $scripts as $s => $script ) :
         wp_enqueue_script( 'js-'.$s, TMPL_URI .'/js/'. $script . '.js', '', '1.0', true);
     endforeach;
     
     // addthis
     wp_enqueue_script( 'js-addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-537da75468e7ecd', '', '1.0', true );
     
     // modernizr
     wp_enqueue_script( 'js-modernizr', TMPL_URI.'/js/modernizr.js', '', '1.0');
     
     // Load WP Default Header.
     wp_head();
?> 
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script type="text/javascript">
    var tmplUri = <?php echo json_encode(TMPL_URI); ?>;
</script>
</head>
<body <?php echo body_class(); ?>>
<header>
  <div class="container">
    <div class="slideFirst clearfix">
        <div class="mobileTrigger"> <span><!-- --></span> <span><!-- --></span> <span><!-- --></span> </div>
      <div class="col-xs-2 logo text-center">
          <span><a href="<?php echo home_url('/'); ?>" title="<?php echo SITE_NAME; ?>"><?php echo ( !empty( $header_logo ) ) ? '<img id="header-logo" src="'.TMPL_URI.'/images/'.$header_logo.'" alt="'.SITE_NAME.'"/>' : SITE_NAME; ?></a></span>
        </div>
      <div class="col-xs-7">
        <div class="headerMenu">
          <nav>
            <ul class="clearfix mobSlide">
                <li><a href="<?php echo site_url('/'); ?>" >Home</a></li>
                <?php 
                    $menu_name = get_menu_name( 'main_menu' );
                    if( !empty( $menu_name ) ) :
                        wp_nav_menu( array( 'menu' => $menu_name ) ); //get_menu_html('main_menu'); 
                    endif;
                    
                //echo "<pre>"; print_r( wp_nav_menu( array( 'menu' => '' ) ) ); die;
                ?>
            </ul>
            <span class="searchTrigger"><a href="#"><i class="fa fa-search"></i></a></span> </nav>
          <div class="searchOverflow">
            <div class="searchBox"> <i class="fa fa-close"></i>
                <form action="" method="post">
                    <input type="text" placeholder="Search using keywords..." name="search-key"/>
                    <input type="submit" value="&#xf002;" class="btn btnSubmit"/>
                </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <ul class="socialConnect clearfix">
          <li><a id="fbAni" href="<?php echo $social_options->fb_link; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
          <li><a id="twAni" href="<?php echo $social_options->tw_link; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
          <li><a id="gpAni" href="<?php echo $social_options->gplus_link; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
          <li id="dropProfile">
              
          <?php 
              /*
               * Author Image
               */
            $current_user_id = get_current_user_id();
            
                $current_user = get_user_by( 'id', $current_user_id );
                $current_user_meta = get_user_meta( $current_user_id );
                //echo "<pre>"; print_r( ucwords( $current_user->data->display_name) ); die;
            /*
             * Get User Social Links
             */
            $user_social = json_decode( get_user_meta( $current_user_id, 'social-links', true ) ) ;
          ?>
                <a href="#"><i class="fa fa-user"></i></a>
                <div class="downProfile">
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
                     
                   /* if( !user_avatar_avatar_exists( $current_user_id )  ):
                ?>
                        <img src="<?php echo  TMPL_URI; ?>/images/thumbnail1.jpg" alt=""/>
                <?php 
                    /*else:   
                          echo user_avatar_get_avatar( $current_user_id, 50 );
                    endif;*/
                    
                ?>
                    <h5><?php echo ucwords( $current_user->data->display_name ); ?></h5>
                    <?php echo wpautop( $current_user_meta['description'][0] ); ?>
                    <div class="socialProfile"> <div class="socialProfile">  
                        <a href="<?php echo $user_social->fb_link; ?>" class="facbookLink" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="<?php echo $user_social->tw_link; ?>" class="twitterLink" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a class="gplusLink" href="<?php echo $user_social->gplus_link; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                        <?php if( !empty( $user_social->in_link ) ) : ?><a class="linkedLink" href="<?php echo $user_social->in_link; ?>" target="_blank"><i class="fa fa-linkedin"></i></a> <?php endif; ?>
                        <?php if( !empty( $user_social->insta_link ) ) : ?><a href="<?php echo $user_social->insta_link; ?>" target="_blank"><i class="fa fa-instagram"></i></a> <?php endif; ?>
                        <?php if( !empty( $user_social->pin_link ) ) : ?><a href="<?php echo $user_social->pin_link; ?>" target="_blank"><i class="fa fa-pinterest"></i></a> <?php endif; ?>
                    </div>
                </div>          
              
        
              
       
              </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<?php
   /*
    * Check for Search keyword is exists.
    */
   if( isset( $_POST['search-key'] ) && !empty( $_POST['search-key'] ) ) :
       include 'includes/search.php';
   endif;