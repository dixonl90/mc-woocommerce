<?php

//Set up the script to access WordPress functions
define('APP_ENV', 'prod');
putenv('APP_ENV='.APP_ENV);
define('WP_USE_THEMES', false);
require_once("/opt/bitnami/apps/wordpress/htdocs/dashboard/wp-load.php");

//WP DB
global $wpdb;

$plugin_name = 'mailchimp-woocommerce';

function flagStopSync()
{
    mailchimp_log('sync.completed', "Finished Sync :: ".date('D, M j, Y g:i A'));

    // this is the last thing we're doing so it's complete as of now.
    setData('sync.syncing', false);
    setData('sync.completed_at', time());

    // flag the store as sync_finished
    mailchimp_get_api()->flagStoreSync(mailchimp_get_store_id(), false);
}

function setResourceCompleteTime($resource = "orders")
{
    return setData('sync.'.$resource.'.completed_at', time());
}

function setData($key, $value)
{
    update_option('mailchimp-woocommerce-'.$key, $value);
}

setResourceCompleteTime();
flagStopSync();
mailchimp_log('sync.orders.completed', 'Done with the order sync.');

?>