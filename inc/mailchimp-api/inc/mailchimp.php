<?php
add_action( 'wp_enqueue_scripts', 'sunday_news_toolkit_mailchimp_enqueue_scripts' );
function sunday_news_toolkit_mailchimp_enqueue_scripts() {
    wp_enqueue_script( 'sunday-news-toolkit-mailchimp-script', SUNDAY_NEWS_TOOLKIT_DIR . 'inc/mailchimp-api/js/mailchimp.js', array( 'jquery' ), null );
    wp_localize_script( 'sunday-news-toolkit-mailchimp-script', 'sunday_news_toolkit_mailchimp', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'process' => esc_html__( 'Processing ...', 'sunday-news-lite-toolkit' )
    ));
}

add_action( 'wp_ajax_sunday_news_toolkit_add_subscriber_list', 'sunday_news_toolkit_add_subscriber_list' );
add_action( 'wp_ajax_nopriv_sunday_news_toolkit_add_subscriber_list', 'sunday_news_toolkit_add_subscriber_list' );
function sunday_news_toolkit_add_subscriber_list() {
    if ( ! isset($_REQUEST['email']) || ! $_REQUEST['email'] ) {
        die( esc_html__( 'Please enter your email address.', 'sunday-news-lite-toolkit' ) );
    }

    if ( ! preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_REQUEST['email'] ) ) {
        die( esc_html__( 'Email address is invalid.', 'sunday-news-lite-toolkit' ) );
    }

    $nonce   = $_REQUEST['nonce'];
    $nonce_d = sunday_news_toolkit_encrypt_decrypt('decrypt', $nonce);

    if ( ! wp_verify_nonce( $nonce_d, 'sunday_news_toolkit_mailchimp' ) ) {
        die( esc_html__( 'Security check', 'sunday-news-lite-toolkit'  ) );
    }

    if ( ! isset( $_REQUEST['api_key'] ) || ! $_REQUEST['api_key'] ||
        ! isset( $_REQUEST['list_id'] ) || ! $_REQUEST['list_id']
    ) {
        die( esc_html__( 'API Key or List ID is incorrect.', 'sunday-news-lite-toolkit'  ) );
    }

    require_once( SUNDAY_NEWS_TOOLKIT_PATH . '/inc/mailchimp-api/inc/mailchimp-api-class.php');
    // grab an API Key from http://admin.mailchimp.com/account/api/

    $data_api_key = sunday_news_toolkit_encrypt_decrypt( 'decrypt', $_REQUEST['api_key'] );
    $data_email   = esc_attr( $_REQUEST['email']);
    $data_list_id = sunday_news_toolkit_encrypt_decrypt( 'decrypt', $_REQUEST['list_id'] );

    $api = new MCAPI( $data_api_key );
    // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
    // Click the "settings" link for the list - the Unique Id is at the bottom of that page.

    if ( true === $api->listSubscribe( $data_list_id, $data_email, '' ) ) {
        die( esc_html__( 'Success! Check your email to confirm sign up.', 'sunday-news-lite-toolkit'  ) );
    } else {
        // An error ocurred, return error message
        die( 'Error: ' . $api->errorMessage );
    }
    die();
}

function sunday_news_toolkit_encrypt_decrypt( $action, $string ) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key     = 'kopasoft sunday-news';
    $secret_iv      = 'kopasoft sunday-news';

    // hash
    $key = hash( 'sha256', $secret_key );

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt( $string, $encrypt_method, $key, 0, $iv );
        $output = base64_encode( $output );
    }
    else if ( $action == 'decrypt' ) {
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    return $output;
}