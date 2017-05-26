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
    
    case 'get-posts' :
        
        /*
         * Get All Posts
         */
        $hidden = [
            'listType'  => !empty( $data['listType'] ) ? $data['listType'] : 'list',
            'offset'    => !empty( $data['offset'] ) ? $data['offset'] : 0,
            'perPage'   => PER_PAGE
        ];
       
        switch( $data['type'] ) :
            
            case 'sub-cat' :
                
                // Sub category Landing Page
                
                $args = array(
                    'post_type' => $data['postType'],
                    'tax_query'  => [
                        [
                            'taxonomy' => $data['postType'] . '-tax',
                            'field' => 'term_id',
                            'terms' => $data['termId']
                        ]
                    ]
                );

                
            break;    
            
            
        endswitch;
        
        $posts = get_posts($args);
        
        //echo '<pre>Args: '; print_r($posts); die;
        
        if( !empty( $posts ) ) :
        
            if( $hidden['listType'] == 'list' ) :
                
                foreach( $posts as $k => $post ) :
                ?>
                    <div class="block">
                        <div class="img">
                            <img style="min-width: 100px;" src="<?php echo TMPL_URI; ?>/assets/images/no-image.png" />
                        </div>
                        <i class="fa fa-chevron-down info-opener" title="Show Contact No and other details"></i>
                        <div class="content">
                            <h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></h4>
                            <?php echo get_max_chars($post->post_content); ?>
                        </div>
                        <div class="caption"><?php echo date("d M, Y", strtotime($post->post_modified)); ?></div>
                        <div class="info">
                            <span class="author"><a href=""><i class="fa fa-user"></i> John Abraham</a></span>

                            <!-- <span><a href=""><i class="fa fa-twitter-square"></i> Twitter</a></span>
                            <span><a href=""><i class="fa fa-facebook-square"></i> Facebook</a></span> -->
                            <span><i class="fa fa-eye"></i> Views: 120</span>

                            <button class="show-contacts-btn fR"><i class="fa fa-phone-square"></i> Show Contacts</button>
                            <div class="show-contacts-details fR none">
                                <span ><a href=""><i class="fa fa-mobile"></i> 9566041710</a></span>
                                <span ><a href=""><i class="fa fa-envelope"></i> j81k@outlook.com</a></span>
                            </div>
                        </div>
                    </div>

                <?php
                endforeach;

            endif;
        
        else :
            // No Results
            ?>
                <div class="no-results">Sorry, No results!</div>
            <?php
            
        endif;
        
        ?>
            <input type="hidden" class="ajax-hidden" value="<?php echo json_encode($hidden); ?>" />
        <?php
        
    break;

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


echo !empty($results) ? json_encode( $results ) : '';

