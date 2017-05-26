<?php

/*
 * subscribe.php (ajax)
 */

// Include WP Loads
$load_url = explode( 'wp-content', dirname(__FILE__) );
include $load_url[0]. 'wp-load.php';

$email = $_POST['email'];
if( empty($email) ) return false;

$args = array(
    'email' => $email
);

$wpdb->insert($wpdb->prefix.'subscribers', $args);

if( !empty($wpdb->insert_id) ) echo 'success';
else echo 'error';


?>
