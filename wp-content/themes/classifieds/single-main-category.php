<?php

/**
 * Author		: Jai K
 * Purpose		: Sub Category Listing Page
 * Created On 	: 2017-05-14 23:58
*/

//echo '<pre>Sing:'; print_r($post); die;


get_header();
?>

    <section id="main-content" class="parallel" data-width="60">
        <input type="text" class="input-box quick-search-box" placeholder="Filter ..." name="quick-search"  value="" />
        <div>
            <?php echo get_breadcumb_html(); ?>
        </div>    
        <div id="browse-box" class="win-height">
            <div id="sub-cat" class="grid" >
                <div class="row">
                    <?php

                        /*
                         * Get all Sub Categories
                         */

                        $sub_cat = $post;

                        $arg = array(
                            'hide_empty'    => FALSE, 
                            //'child_of'    => $post->ID,
                            'parent'        => '0',
                            'orderby'       => 'term_order', 
                            'order'         => 'ASC'
                        );

                        $results = get_terms($sub_cat->post_name . '-tax', $arg);
                        $results_cnt = count($results);

                        if( $results_cnt > 0 ) :    
                            
                            //echo '<pre>'; print_r( $results ); die;
                            
                            foreach( $results as $k => $result ) :
                                ?>
                                    <div class="block col-xs-3">
                                        <a href="<?php echo site_url('/'.$sub_cat->post_name.'/'.$result->slug.'/' ); //get_permalink($result->term_id); ?>">
                                            <div>
                                                <h4><?php echo $result->name; ?></h4>
                                                <i class="<?php echo !empty( $result->description ) ? $result->description : $post->post_excerpt; ?>"></i>
                                                <div class="info"><?php echo $result->description; ?></div>
                                                <div class="caption">Items: <?php echo $result->count; ?></div>
                                            </div>
                                        </a>    
                                    </div>
                                <?php

                                echo $k+1 % 3 == 0 ? '</div> <div class="row">' : '';

                            endforeach;
                        else :
                            // NO sub categories
                            ?>
                                <div class="no-results">Sorry, No sub categories found under "<?php echo $sub_cat->post_title; ?>"</div> 
                            <?php
                        endif;    
                    ?>
                </div>    

            </div>
        </div>
    </section>
<?php
	get_sidebar();
	
get_footer();