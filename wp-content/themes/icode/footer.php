<?php

/*
 * footer.php
 */

/**
 * Get theme Options.
 */
$theme_options = json_decode(get_option('theme-options'));
$general_options = $theme_options->general;
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-6 footLeft">
                <ul>
                    <?php 
                    // Footer Menu
                    $menu_name = get_menu_name( 'footer_menu' );
                    if( !empty( $menu_name ) ) :
                        wp_nav_menu( array( 'menu' => $menu_name ) ); //get_menu_html('main_menu'); 
                    endif;
                    //echo get_menu_html('footer_menu');
                    ?>
                </ul>
            </div>
            <div class="col-xs-6 text-right footRight">
                <?php echo $general_options->footer->text; ?>
            </div>
        </div>
    </div>
</footer>
<?php
    // Load WP Default footer.
    wp_footer();
   
?>

</body>
</html>