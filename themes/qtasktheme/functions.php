<?php
add_action('admin_post_api_login', 'prefix_admin_api_login');
add_action('admin_post_nopriv_api_login', 'prefix_admin_api_login');

function prefix_admin_api_login()
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $url = 'https://symfony-skeleton.q-tests.com/api/v2/token';
    $response = wp_remote_post($url, array(
        'method' => 'POST',
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode(array('email' => $email, 'password' => $password))
    ));
    $response_code = wp_remote_retrieve_response_code($response);

    $response_body = json_decode(wp_remote_retrieve_body($response));
    if ($response_code == 200) {
        if (!empty($response_body->token_key)) {
            setcookie('qss_access_token', $response_body->token_key, time() + (86400 * 30), "/");
            echo "<h1>SUCCESS!</h1>";
            exit;
        }
    } else {
        wp_redirect(home_url());
        exit;
    }
}
