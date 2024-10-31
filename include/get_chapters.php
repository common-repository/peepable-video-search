<?php

//defined( 'ABSPATH' ) or die( 'No permission to go here!' );

/* 
 * fetch a list of chapters from the publishers site using API
 * Use the Peepable API Key specified in the plugin settings
 * Retunr as JSON
 */


function peepable_getChapters(){

   global $wpdb;
   $domainoptions = getpeepabledomainoptions();

    //print_r($_REQUEST);
    //$video_id = get_query_var ('video_id', '');
    $video_id = $_REQUEST['video_id'];
    //echo $video_id;
    
    $api_clientid = $domainoptions['api_clientid'];
    $api_clientsecret = $domainoptions['api_clientsecret'];
    //echo $api_clientid + ' ' + $api_client;secret;
    // get a oauth token
    
    $authurl = 'https://publishers.peepable.com/?oauth=token';
    
    $args = array( 'headers' => array( 
        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8' ),
        'body' => 'grant_type=client_credentials&client_id=' . $api_clientid . '&client_secret=' . $api_clientsecret); 
    
    $response = wp_remote_post( $authurl, $args );
    
    // extract auth token from body here *NEEDS DOING
    $bodystr = wp_remote_retrieve_body($response);
    $body = json_decode($bodystr);
    $access_token = $body->access_token; 
    
    $url = 'https://publishers.peepable.com/api/v1/media/chapters/' . $video_id . '/?access_token=' .$access_token;
    $response = wp_remote_get( $url );
    
 	//Check for error
	if ( is_wp_error( $response ) ) {
		return sprintf( 'The URL %1s could not be retrieved.', $url );
	}
	
	//get just the body
	$chapters = wp_remote_retrieve_body( $response );
	
	//return if not an error
	if ( ! is_wp_error( $chapters )  ) {
 
		//decode and return
		echo $chapters ;
	}
    
    die();
 
}
add_action('wp_ajax_peepable_getChapters', 'peepable_getChapters');
add_action( 'wp_ajax_nopriv_peepable_getChapters', 'peepable_getChapters' );