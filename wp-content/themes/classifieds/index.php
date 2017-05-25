<?php

/**
 * Template Name: Home
 * Author		: Jai K
 * Purpose		: Main Index file
 * Created On 	: 2017-05-06 22:04
*/
//preg_match('/\/category\/(.*?)[\/|]$/', $_SERVER['REQUEST_URI'], $mtchs);

get_header();
?>

	<section id="main-content" class="parallel" data-width="60">
            <input type="text" class="input-box quick-search-box" placeholder="Quick Search ..." name="quick-search"  value="" />
            <div id="browse-box" class="win-height">
                <div id="main-cat-sec" class="grid" >
                    <div class="row">
                        <?php

                            /*
                             * Get all Main Categories
                             */
                            $main_cats = get_main_categories();

                            foreach( $main_cats as $k => $result ) :
                                $post_meta = get_post_meta($result->ID);
                            
                                echo '<pre>Pos: '; print_r( $post_meta ); die;
                                
                                ?>
                                    <div class="block col-xs-4">
                                        <a href="<?php echo get_permalink($result->ID); ?>">
                                            <div>
                                                <h4><?php echo $result->post_title; ?></h4>
                                                <i class="<?php echo $result->post_excerpt; ?>"></i>
                                                <div class="info">The description of the Job</div>
                                                <div class="caption">Items: 678</div>
                                            </div>
                                        </a>    
                                    </div>
                                <?php

                                echo $k+1 % 3 == 0 ? '</div> <div class="row">' : '';

                            endforeach;
                        ?>
                    </div>
                    
                </div>    
            </div>
        </section>

<?php
	get_sidebar();
	
get_footer();