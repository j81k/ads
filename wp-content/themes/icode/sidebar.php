<?php

/*
 * sidebar.php
 */
?>
<div class="col-xs-4 sideBar">
    <div class="col-xs-12">
        <?php
            
                
            if( function_exists('dynamic_sidebar') ):// && dynamic_sidebar( 'sidebar-widgets' ) ) :
                dynamic_sidebar( 'sidebar-widgets' );
            /*else :
                
                // Set Default
       
                $widgets_arr = array(
                    'View_Profile',
                    'Be_Social',
                    'Subscribers',
                    'Sidebar_Posts',
                    'Sponsores',
                    'Tags'
                );

                foreach( $widgets_arr as $k=> $widget_name ) :
                    $widget_class = $widget_name.'_Widget';

                    if (class_exists( $widget_class ) ) :
                        $widget = new $widget_class();
                        echo $widget->widget();
                    endif;

                endforeach;*/
            endif;
    
        ?>
    </div>
</div>
