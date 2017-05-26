<?php

/*
 * search.php (includes)
 */

$keyword = $_POST['search-key'];

$theme_options = json_decode(get_option('theme-options'));

// Posts per page
$per_page = $theme_options->misc->limits->per_page;
if( empty( $per_page ) ) $per_page = 10;

$start_limit = 0;

// Get results.
$query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE ( `post_title` LIKE '%".$keyword."%' OR `post_content` LIKE '%".$keyword."%' OR `post_excerpt` LIKE '%".$keyword."%' ) AND ( `post_status` = 'publish' ) AND ( `post_type` != 'attachment' AND `post_type` != 'nav_menu_item' AND `post_type` != 'revision' AND `post_type` != 'page' ) ORDER BY `post_title` ASC";//;
$results = $wpdb->get_results( $query );
$total = count( $results );

// Apply Pagination filter.
$results = $wpdb->get_results( $query.' LIMIT '.$start_limit.','.$per_page );


/*
 * Check whether the Advanced search option is set.
 */
if( isset( $_POST['advanced-search-value'] ) && !empty( $_POST['advanced-search-value'] ) ) :
    $advanced = $_POST['advanced-search-value'];
    $tmp_arr = array();
    foreach( $results as $k => $result ) :
        if( $advanced == 'viewed' ) :
            $tmp_arr[get_post_visit_count( $result->ID ).$k] = $result;
        elseif( $advanced == 'shared' ) :
            //$order_by = ' ORDER BY `post_title` ASC ';
            $tmp_arr[] = $result;
        else :
            // Commented
            $comment_count = get_comment_count( $result->ID );
            $tmp_arr[$comment_count['approved'].$k] = $result;
        endif;
        
    endforeach;
    
    // Sort.
    krsort( $tmp_arr );
    
    // Assign it.
    $results    = (Object) $tmp_arr;
    
    //echo "<pre>Visit"; print_r($results); die;
endif;


?>
    <div class="container">
  <div class="row mainSection">
      
    <div class="col-xs-8 articleSection">
      <div class="col-xs-12">
        <div class="searchMain">
          <h1>Search</h1>
          <div>
            <form action="" method="post">
                <input type="text" placeholder="Search using keywords..." value="<?php echo $keyword; ?>" name="search-key" id="search-key" data-attr="<?php echo $total.'`'.$start_limit.'`'.$per_page.'`'.$keyword; ?>"/>
                <input type="hidden" value="" name="advanced-search-value" id="advanced-search-value" />
                <input type="submit" value="&#xf002;" class="btn btnSubmit"/>
                
            </form>
          </div>
          <?php
          
            if( !empty( $results ) && count( $results ) > 0 ) :
          ?>
          <div class="searchOptions">
            <h3>Search Results</h3>
            <select class="selectMenu" id="advanced">
              <option selected disabled>Advance Search</option>
              <option value="viewed" <?php if( $advanced == 'viewed' ) echo 'selected'; ?> >Most Viewed</option>
              <option value="shared" <?php if( $advanced == 'shared' ) echo 'selected'; ?> >Most Shared</option>
              <option value="commented" <?php if( $advanced == 'commented' ) echo 'selected'; ?> >Most Commented</option>
            </select>
          </div>
          <?php 
            endif;
          ?>
        </div>
        <div id="search-posts">  
            <?php
                $is_loader = true;
                include 'list-posts.php';
            ?>
        </div>
      </div>  
    </div>
    <?php
        /*
         * Display Sidebar
         */
        get_sidebar();
      ?>
  </div>
</div>
<?php
get_footer();
exit();