<?php

if ( ! function_exists( 'sunday_news_ajax_send_contact_widget' ) ) {

    function sunday_news_ajax_send_contact_widget() {

        if ( ! check_ajax_referer( 'sunday_news_send_contact_widget', 'ajax_nonce_sunday_news_send_contact_widget', false ) ) {
            die( esc_html__( 'Oops! errors occured.', 'sunday-news-lite-toolkit' ) );
        }

        foreach ( $_POST as $key => $value ) {
            if ( ini_get('magic_quotes_gpc') ) {
                $_POST[ $key ] = stripslashes( $_POST[$key] );
            }
            $_POST[ $key ] = htmlspecialchars( strip_tags( $_POST[$key] ) );
        }

        $name    = esc_html( $_POST["name"] );
        $email   = esc_html( $_POST["email"] );
        $subject = esc_html( $_POST['subject'] );
        $message = esc_html( $_POST["message"] );

        $message_body = "Name: {$name}" . PHP_EOL ."Subject: {$subject}". PHP_EOL. "Message: {$message}";

        $to = get_bloginfo( 'admin_email' );

        if ( isset( $_POST["subject"] ) && $_POST["subject"] != '' ) {
            $subject = "Contact Form: $name - {$_POST['subject']}";
        } else {
            $subject = "Contact Form: $name";
        }

        $headers[] = 'From: ' . $name . ' <' . $email . '>';
        $headers[] = 'Cc: ' . $name . ' <' . $email . '>';

        $result = esc_html__( 'Oops! errors occured.', 'sunday-news-lite-toolkit' );

        if (wp_mail($to, $subject, $message_body, $headers)) {
            $result = esc_html__( 'Success! Your email has been sent.', 'sunday-news-lite-toolkit' );
        }

        echo json_encode($result);
        die();
    }

    add_action( 'wp_ajax_sunday_news_send_contact_widget', 'sunday_news_ajax_send_contact_widget' );
    add_action( 'wp_ajax_nopriv_sunday_news_send_contact_widget', 'sunday_news_ajax_send_contact_widget' );
}
