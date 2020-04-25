<?php 

//registering addon
require_once plugin_dir_path( __FILE__  ) . 'api.php';

$mailChimp = new MailChimp();

add_filter('gutenberg_forms_integrations', function($integrations) {


    $guide = plugin_dir_path( __FILE__ ) . 'guide/guide.html';

    $arguments = array(
        'title' => 'Mail Chimp',
        'is_pro'  => true,
        'type'  => 'autoResponder',
        'guide' => file_get_contents( $guide ),
        'description' => 'Bring new life to your lists with upgraded Mailchimp signup forms for WordPress! Easy to build and customize with no code required. Link to lists and interest groups!',
        'banner' => 'https://us20.admin.mailchimp.com/release/1.1.132c826603d26483f97297c92082b7e461f3c8cb4/images/brand_assets/logos/mc-freddie-dark.svg',
        'fields' => array(
            'api_key' =>  array(
                'label' => 'Api Key',
                'default' => '',
                'type' => 'string',
            )
        ),
        'query_fields' => array(
            'list' => array(
                'label' => 'Select List',
                'value' => 'hola',
                'type'  => 'select'
            ),
            'tags' => array(
                'label' => 'Tags',
                'type'  => 'tags',
                'value' => []
            )
        ),
        'api_fields' => array(
            'EMAIL' => array(
                'label' => 'Email'
            ),
            'FNAME' => array(
                'label' => 'First Name'
            ),
            'LNAME' => array(
                'label' => 'Last Name'
            ),
            'PHONE' => array(
                'label' => 'Phone'
            ),
            'ADDRESS_1' => array(
                'label' => 'Address 1'
            ),
            'STATE' => array(
                'label' => 'State'
            ),
            'ZIP' => array(
                'label' => 'Zip Code'
            ),
            'COUNTRY' => array(
                'label' => 'Country'
            ),
            'CITY'  => array(
                'label' => 'City'
            )
        )
    ); 

    $integrations['mailchimp'] = $arguments;

    return $integrations;

});


add_action('gutenberg_forms_submission_mailchimp', function($entry) {

    $mailChimp->post( $entry  );

});