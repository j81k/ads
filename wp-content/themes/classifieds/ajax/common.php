<?php

/**
* Author		: Jai K
* Purpose		: Common (Ajax)
* Created On 	: 2017-05-25 15:22
*/

$results = [];
$act        = $_POST['action'];
$data       = $_POST['data'];    

require_once '../../../../wp-load.php';

switch( $act ) :
    
    case 'list-cities' :
        
        // List all cities for particular State
        $results = getCities($data['stateId'], TRUE);
        
        
    break;    

    case 'sample-posts' :
        /*
        * List all sample posts
        */
        $main_cats = get_main_categories();

        $main_cats_slug = [];
        foreach( $main_cats as $k => $main_cat ) :
            $main_cats_slug[] = $main_cat->post_name;
        endforeach;

        //echo '<pre>Pos: '; print_r( $main_cats_slug ); die;

        /*
         * Get Posts
         */
        $args = array(
            'post_type'     => $main_cats_slug,
            'post_status'   => 'publish',
            'order_by'      => $data['type'] == 'hot' ? 'menu_order' : 'post_modified',
            'posts_per_page'=> 10    
        );

        $posts = get_posts($args);

        if( !empty( $posts ) ) :
            
            foreach( $posts as $k => $post ) :
                ?>
                    <div class="block">
                        <div class="img">
                            <img style="min-width: 100px;" src="<?php echo TMPL_URI; ?>/assets/images/no-image.png" />
                        </div>
                        <div class="content">
                            <h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></h4>
                            <?php echo get_max_chars($post->post_content); ?>
                        </div>
                        <div class="caption"><?php echo date("d M, Y", strtotime($post->post_modified)); ?></div>
                    </div>
                <?php
            endforeach;
        else :
            ?>
                <div class="no-results">Sorry, No results!</div>
            <?php
        endif;
        
        
        
    break;    

endswitch;


echo json_encode( $results );

