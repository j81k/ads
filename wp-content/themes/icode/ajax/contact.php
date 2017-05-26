<?php

/*
 * contact.php ( ajax )
 */

// Include WP Loads
$load_url = explode( 'wp-content', dirname(__FILE__) );
include $load_url[0]. 'wp-load.php';

if( empty( $_POST['data'] ) ) return false;

$args = array();
foreach( $_POST['data'] as $k => $data  ) :
    $db_column = str_replace( '-', '_', $data['name'] );
    $args[$db_column] = $data['value'];
endforeach;

$args['posted_date'] = date("Y-m-d H:i:s");

// Insert into DB
$wpdb->insert( $wpdb->prefix.'contact_us', $args  );
echo 'success';

?>
