<?php

/**
* Author		: Jai K
* Purpose		: Header file
* Created On 	: 2017-05-06 22:20
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

$site_name = SITE_NAME;

?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EDGE,chrome=1" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0 minimal-ui" />
        
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        
        <meta name="description" content="" />
		<meta name="author" content="Jai" />
		<meta name="keywords" content="" />
        
        <title><?php echo $page_title; ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo TMPL_URI; ?>/assets/images/favicon.png" />
       <!-- <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300' rel='stylesheet' type='text/css'> -->
        
        <link rel="stylesheet" href="<?php echo TMPL_URI; ?>/assets/css/jquery-ui-1.11.4.css" />
        <link rel="stylesheet" href="<?php echo TMPL_URI; ?>/assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo TMPL_URI; ?>/style.css" />
        <link rel="stylesheet" href="<?php echo TMPL_URI; ?>/assets/css/media.css" />
        
        <script type="text/javascript">
            var siteUrl = "<?php echo TMPL_URI.'/'; ?>";
            //var pages = new Array('home', 'publish', 'search', 'about', 'contact', 'category' );
        
        </script>	
    </head>
    
    <body id="<?php echo strtolower($post->post_title); ?>">
        
        <div id="side-panel-mask" class="side-panel-mask"></div><!-- /side-panel-mask -->
        <nav id="side-menu" class="side-panel">
            <div class=" parallels site-wrapper ">
                <div class="parallel" data-width="65">
                    <?php //echo get_menu_html(); ?>
                    
                    <ul class="fL">
                        <li class="active"><a href="<?php echo home_url('/'); ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>login"><i class="fa fa-lock"></i> Login</a></li>
                        <li class="none"><a href="<?php echo SITE_URL; ?>profile"><i class="fa fa-user"></i> Profile</a></li>
                        
                        <li><a href="<?php echo SITE_URL; ?>about"><i class="fa fa-smile-o"></i> About</a></li>
                        <li><a href="<?php echo SITE_URL; ?>contact"><i class="fa fa-envelope"></i> Contact</a></li>
                    </ul>
                </div>
                <div  class="parallel text-right" id="quick-search" data-width="35" >
                    <input type="text" class="input-box quick-search-box" placeholder="Quick Search ..." name="quick-search" value="" />
                    <i class="fa fa-search place-icon icon no-inverse" data-target="#side-menu .quick-search-box"></i>
                    
                    <button class="close-btn icon icon-btn inverse"><i class="fa fa-close"></i></button>
                </div>
            </div>    
       </nav><!-- /c-menu slide-right -->    
       <div id="global-msg" class="side-panel">Hi..., Welcome! </div>
       
        <section id="page">
            
            <!-- Header -->
            <header class="fixed-bar wrapper">
                <section class="site-wrapper parallels">
                    
                    <div id="logo" class="parallel" >
                    	<a href="<?php echo home_url('/'); ?>">
                        	<h1>
                                <span><?php echo '<span class="rotor">'.$site_name[0].'</span>' . substr(SITE_NAME, 1); ?></span>
                        		<br /><span id="tag-line-text"><?php echo get_bloginfo('description'); ?></span>			
                        	</h1>
                        </a>
                        
                    </div>

                    <div class="parallel">
                        <nav class="fR" id="main-menu">
                            <ul>
                                <li class="btn" id="publish-btn"><a href="<?php echo SITE_URL; ?>publish">Publish</a></li>
                                <li id="menu-btn" class="side-panel-btn icon icon-btn" data-target="#side-menu" data-action="slide-bottom" data-close="true" data-delay=""><i class="fa fa-bars"></i></li>
                            </ul>
                        </nav>
                    </div>
                    
                </section>
            </header>
            
            <!-- Content -->
            <section id="content" class="side-panel-push win-height">
                <section  class="site-wrapper parallels" >