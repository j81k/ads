<?php

/*
 * list-posts.php
 */

// User Social links.
$user_social = json_decode( get_user_meta( get_current_user_id(), 'social-links', true ) ) ;

/**
 * Pagination
 */
 if( !$is_loader && empty( $_POST['search-key'] ) ) :
     // ignore Search page.
     
     // Posts per page
     $per_page = $theme_options->misc->limits->per_page;
     if( empty( $per_page ) ) $per_page = 10;

     $start_limit     = 0; 
     $pid = 1;
      if( empty( $_REQUEST['total'] ) ) :

         // Get posts.
         $results = get_posts($args);
         $total = count( $results );
     else :

         // Page id 
         if( empty( $_REQUEST['pid'] ) ) $pid = 1;
         else $pid = $_REQUEST['pid'];

         $total         = $_REQUEST['total'];
         $start_limit   = $_REQUEST['start']; 
     endif;

     $args['offset'] = ( $pid-1 )*$per_page;
     $args['posts_per_page'] = $per_page;
     
     // Get posts.
    $results = get_posts($args);
    $results = (array) $results;

 endif;


if( !empty( $results ) && count( $results ) > 0 ) :
    $results_count = count( $results );
    
    $k = 1;
    $html = '';
    $results = (Object) $results;
    foreach($results as $post_id => $result ) :
        $post = get_post( $result->ID );
        $content = apply_filters('the_excerpt', $post->post_excerpt);
        if( empty( $content ) ) $content = get_limited_words( apply_filters('the_content', $post->post_content), $post );

        $img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        

        $visit_count = get_post_visit_count($post->ID);
        $comment_count = get_comment_count( $post->ID );
        $comment_approved_count = $comment_count['approved'];

        
        
        $html .= '
           
        <div class="col-xs-6 articleDesc">'; 
                if( !empty( $img_url ) ) : 
                    $html .= '<img src="'.TMPL_URI.'/thumb.php?src='.$img_url.'&w=360&h=207" alt="'.$post->post_title.'"/>'; 
                endif;
            $html .= '<a href="'.get_permalink( $post->ID ).'"><h2>'.$post->post_title.'</h2></a>'.wpautop( $content  ).'
            
            <div class="bottomFeature">
              <div class="firstFeature">'; 
                    if( $visit_count > 0 ) : 
                        $html .= '<span class="eyeNum">'. $visit_count.'</span>';
                    endif;
                    $html .= '
                    <div class="sharePost">
                      <ul class="clearfix">
                        <li><a href="#" class="addthis_button_facebook" addthis:url="'.get_permalink( $post->ID ).'"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="addthis_button_twitter" addthis:url="'.get_permalink( $post->ID ).'" ><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://plus.google.com/share?url={'.get_permalink( $post->ID ).'}" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><i class="fa fa-google-plus"></i></a></li>
                      </ul>
                    </div>';
                    if( $comment_approved_count > 0 ) :
                        $html .= '<span class="commentNum">'.$comment_approved_count.'</span>';
                    endif; 
              $html .= '</div>
              <div class="secondFeature"> <span class="postedOn"><i class="fa fa-clock-o"></i>'.date("d M y", strtotime($post->post_date)).'</span> </div>
            </div>
            </div>';
        //if( $k % 2 != 0 || ($k % 2 != 0 && ($k+1) == $results_count) || ( $results_count == 1 ) || ($k+1) == $results_count ) echo '</div>';

            if( $k % 2 == 0 || ($results_count == $k ) ) :
                echo '<div class="row blogPost">'.$html.'</div>';
                $html = '';
            endif;
        $k++;

    endforeach;
    
    /**
     * Pagination
     */
    // Pages count
    $pages_count = ceil( $total/$per_page );
    if( $pages_count > 1) :
         
        if( $is_loader ) :
            if( ( $start_limit+$per_page ) < $total ) :
        ?>
            <div class="pagination"> <a class="load-more"><i class="fa fa-refresh"></i>Load More</a> </div>
        <?php
            endif;
        else:
            $pagination_type = $theme_options->general->pagination_type;
            if( $pagination_type == 'block' ) :
                echo '<div class="pagiNum">';
                
                for( $i = 1; $i <= $pages_count; $i++  ) :
                    echo '<a href="'.  get_permalink( $page_post->ID ).'?total='.$total.'&pid='.$i.'">'.$i.'</a>';
                endfor;
                
                echo '</div>';
            else :
                ?>
                <div class="pagination clearfix">
                    <?php
                        if( $pid > 1 ) :
                            echo '<a href="'.  get_permalink( $page_post->ID ).'?total='.$total.'&pid='.( $pid-1 ).'" class="fL">Newer Post</a>';
                        endif;
                        
                        if( $pid >= 1 && $pid < $pages_count ) :
                            echo '<a href="'.  get_permalink( $page_post->ID ).'?total='.$total.'&pid='.( $pid+1 ).'" class="fR">Older Post</a>';
                        endif;
                    ?> 
                </div>
                <?php
            endif;
        endif;
    
    endif; // per_page
else:
    /*
     * No search results.
     */
?>
<div class="row blogPost">
    <div class="col-xs-12 articleDesc"> 
        <?php
            if( !empty( $keyword ) ) :
                $no_search_results = $theme_options->msgs->no_search_results;
                if( empty( $no_search_results ) ) :
                    $no_search_results = 'Sorry, No search results for "'.$keyword.'"';
                else :
                    $no_search_results = preg_replace( '/\\\/', '', $no_search_results );
                    $no_search_results = preg_replace( '/\{keyword\}/', $keyword, $no_search_results );
                endif;
        ?>
                <h2><?php echo $no_search_results; ?></h2>
        <?php
            else :
                $no_results = $theme_options->msgs->no_results;
                if( empty( $no_results ) ) $no_results = 'Sorry, No results found.';
        ?>
                <h2><?php echo $no_results?></h2>
        <?php        
            endif;
        ?>
    </div>
</div>    
<?php      
endif;    
?>
