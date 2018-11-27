<?php

//Set up the script to access WordPress functions
define('APP_ENV', 'prod');
putenv('APP_ENV='.APP_ENV);
define('WP_USE_THEMES', false);
require_once("/opt/bitnami/apps/wordpress/htdocs/dashboard/wp-load.php");

$products = get_posts(array(
    'post_type' => array_merge(array_keys(wc_get_product_types()), array('product')),
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'ID',
    'order' => 'ASC',
));

?>