<?php

/**
* Author		: Jai K
* Purpose		: Default Taxonomy Page
* Created On 	: 2017-05-14 20:30
*/

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );


get_header();
?>

    <section id="main-content" class="parallel" data-width="60">
        <input type="text" class="input-box quick-search-box" placeholder="Filter ..." name="quick-search"  value="" />
        <div>
            <?php echo get_breadcumb_html('sub-cat'); ?>
            <div id="search-count" class="sub-title-small fR">10/89</div>
        </div>    
        <div id="browse-box" class="win-height">
            <div id="sub-cat-list" class="list results" data-type="sub-cat" data-term-id="<?php echo $term->term_id; ?>" data-post-type="<?php echo $post->post_type; ?>" >
                
            </div>
        </div>
    </section>
<?php
	get_sidebar();
	
get_footer();