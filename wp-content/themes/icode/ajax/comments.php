<?php

/*
 * comments.php (ajax)
 */

// Include WP Loads
$load_url = explode( 'wp-content', dirname(__FILE__) );
include $load_url[0]. 'wp-load.php';

$data = $_POST['data'];
if( !isset( $data ) || empty( $data ) ) return false;

$act = $data['act'];

/*
 * User Id
 */
if( is_user_logged_in() ) $user_id = get_current_user_id ();
$user_id = 0;

if( !empty( $data['commentParent'] ) ) $comment_parent = $data['commentParent'];
else $comment_parent = 0;

$today_date = date("Y-m-d H:i:s");

$args = array(
    'comment_post_ID'   => $data['postId'],
    'comment_author'    => $data['commentAuthor'],
    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
    'comment_date'      => $today_date,
    'comment_date_gmt'  => $today_date,
    'comment_content'   => $data['content'],
    'comment_parent'    => $comment_parent,
    'user_id'           => $user_id,
    'comment_approved'  => 0
);

// Check Email is not empty.
if( !empty( $data['commentEmail'] ) ) $args['comment_author_email'] = $data['commentEmail']; 

$wpdb->insert( $wpdb->prefix.'comments', $args );
$insert_id = $wpdb->insert_id;

// Comment Author Twitter
if( !empty( $data['commetAuthorTwitter'] ) ) update_comment_meta( $insert_id, 'commet_author_twitter', $data['commetAuthorTwitter']);

echo 'success';
?>
