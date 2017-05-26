<?php

/*
 * search-more.php
 */

// Include WP Loads
$load_url = explode( 'wp-content', dirname(__FILE__) );
include $load_url[0]. 'wp-load.php';

$total = $_REQUEST['total'];
$start_limit = $_REQUEST['startLimit'];
$per_page = $_REQUEST['perPage'];
$keyword = $_REQUEST['data'];

$query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE ( `post_title` LIKE '%".$keyword."%' OR `post_content` LIKE '%".$keyword."%' OR `post_excerpt` LIKE '%".$keyword."%' ) AND ( `post_status` = 'publish' ) AND ( `post_type` != 'attachment' AND `post_type` != 'nav_menu_item' AND `post_type` != 'revision' AND `post_type` != 'page' ) ORDER BY `post_title` ASC LIMIT ".$start_limit.",".$per_page;
$results = $wpdb->get_results( $query );


$is_loader = true;
$_POST['search-key'] = $keyword;
include '../includes/list-posts.php';

?>
