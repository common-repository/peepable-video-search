<?php
/**
 * Plugin Name: Peepable
 * Plugin URI: http://about.peepable.com/widget
 * Description: This is a simple way to add Peepable video search to your Wordpress website without writing any code. Peepable allows users to search for a phrase across a collection of publisher's videos, and go straight to the point where the phrase was spoken, then instantly share a clip from within a video.
 * Version: 1.4.0
 * Author: Peepable Pty Ltd
 * Author URI: http://publishers.peepable.com
 * License: GPL2
 * Licence URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: 
 * Domain Path: 
 *
 *  Copyright 2015-2016 Peepable Pty Ltd (email : sales@peepable.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package peepable
 * @author Alex French
 * @version 
 */

defined( 'ABSPATH' ) or die( 'No permission to go here!' );

//include (dirname(__FILE__) . '/include/get_chapters.php'); // only included with some Peepable subscriptions
include (dirname(__FILE__) . '/admin/admin.php');

function peepable_load_scripts_and_styles() {
    
    wp_register_style('peepable-styles', plugins_url('css/style.css', __FILE__) );
    wp_enqueue_style('peepable-styles');
    wp_register_script('get_chapters', plugins_url('js/get_chapters.js', __FILE__));
    wp_enqueue_script('get_chapters');
}

add_action( 'wp_enqueue_scripts', 'peepable_load_scripts_and_styles' );


function peepable_searchresults_function($atts) {
	extract ( shortcode_atts ( array (
            'afl' => 'development',
            'client_id' => 'widgetabc123',
            'url_template' => '/wp/peepable/search/?q={{search-criteria}}',
            'hco' => '' ,
            'facebookappid' => '',
            'domain_key' => '', //client_id is now domain_key
            'collection_key' => '', //afl is now collection_id
            'continueAtPeepEnd' => '',
            'displayPublishedDate' => '',
            'displayPoweredBy' => 'true',
            'affiliateID' => '',
            'default_search' => ''
	), $atts ) );
	
    if ($atts['collection_key'] == ''){
        $atts['collection_key'] = $atts['afl'];
    }

    $collection_key_opt =  get_query_var( 'collection_key', '' );
    if ($collection_key_opt  == ''){    
    }else{
        $atts['collection_key'] = $collection_key_opt;
    }

      $url_template_opt =  get_query_var( 'url_template', '' );
    if ($url_template_opt  == ''){    
    }else{
        $atts['url_template'] = $url_template_opt;
    }

    if ($atts['domain_key'] == ''){
        $atts['domain_key'] = $atts['client_id'];
    }
    
    $domainoptions = peepable_getdomainoptions();
    
    // use the search in the query parameter or default to a setting from the shortcode
    if (ISSET ($_GET["q"])){
        $defaultSearchCriteria = $_GET["q"];
    } else {
        $defaultSearchCriteria = $atts['default_search'];
    }
    
    
    $html = '';
    $html .= '<link rel="stylesheet" href="' . $domainoptions['csspath']. '">';
    
    $html .= '<div class="peepable-search-results"></div>';
    $html .= '<!--Peepable Widget-->';
    $html .= '<script';
    $html .= ' src="' . $domainoptions['widgetpath'] . '"';
    $html .=  ' type="text/javascript"></script>';
    $html .= ' <script type="text/javascript">';
    $html .= ' PeepableToolkit.initialise({';
    $html .= ' afl: "' . $atts['collection_key'] . '",';
    $html .= ' client_id: "' . $atts['domain_key'] . '",';  
    $html .= ' searchCriteria: "' . $defaultSearchCriteria . '",';
    $html .= ' search_url_template: "' . $atts['url_template'] . '",';
    $html .= ' hco: "' . $atts['hco'] . '",';
    $html .= ' FacebookAppId: "' . $domainoptions['facebookappid'] . '",';
    $html .= ' continueAtPeepEnd: ' . $domainoptions['continueAtPeepEnd'] . ',';
    $html .= ' displayPublishedDate: ' . $domainoptions['displayPublishedDate'];    

    if ($domainoptions['displayPoweredByLink'] != ""){
        $html .= ', displayPoweredBy: ' . $domainoptions['displayPoweredByLink']  ; 
    }

    if ($domainoptions['affiliateid'] != ""){ 
        $html .= ', affiliateID: "' . $domainoptions['affiliateid'] .'"' ; 
    }
 
    $html .= '  });';
    $html .= '</script>';
    
    wp_register_script( 'peepable_events-js', plugins_url('js/peepable_events.js', __FILE__) ); 
    wp_enqueue_script( 'peepable_events-js');
    
    $upload_dir = wp_upload_dir();
    wp_register_style('peepable_publisher_options', esc_url( $upload_dir['baseurl']) . '/peepable/css/peepable_publisher.css'); 
    wp_enqueue_style('peepable_publisher_options');
    
    
    return $html;

}
function peepable_searchbox_function() {
	extract ( shortcode_atts ( array (
            'afl' => 'development',
            'client_id' => 'widgetabc123',
            'url_template' => '/wp/peepable/search/?q={{search-criteria}}',
            'hco' => '',
            'facebookappid' => '',
            'domain_key' => '', //client_id is now domain_key
            'collection_key' => '',
            'continueAtPeepEnd' => '',
            'displayPublishedDate' => '',
            'displayPoweredBy' => 'true',
            'affiliateID' => ''

	), $atts ) );
	
              if ($atts['collection_key'] == ''){
            $atts['collection_key'] = $atts['afl'];
        }
        
        if ($atts['domain_key'] == ''){
            $atts['domain_key'] = $atts['client_id'];
        }
        $domainoptions = peepable_getdomainoptions();
        
	// return html don't echo so it appears in correct place in page
        $html = '';
    $html .= '<link rel="stylesheet" href="' . $domainoptions['csspath']. '">';
    //$hmtl .= '<link rel="stylesheet" href="' . plugins_url('css/publisher_options.css' , __FILE__) . '">';
    $html .= '<div class="peepable-search-box"></div>';
    $html .= '<script';
    $html .= ' src="' . $domainoptions['widgetpath'] . '"';
    $html .=  ' type="text/javascript"></script>';
    $html .= ' <script type="text/javascript">';
    $html .= ' PeepableToolkit.initialise({';
    $html .= ' afl: "' . $atts['collection_key'] . '",';
    $html .= ' client_id: "' . $atts['domain_key'] . '",';
    $html .= ' searchCriteria: "' . $_GET["q"] . '",';
    $html .= ' search_url_template: "' . $atts['url_template'] . '",';
    $html .= ' hco: "' . $atts['hco'] . '",';
    $html .= ' FacebookAppId: "' . $domainoptions['facebookappid'] . '",';
    $html .= ' continueAtPeepEnd: ' . $domainoptions['continueAtPeepEnd'] . ',';
    $html .= ' displayPublishedDate: ' . $domainoptions['displayPublishedDate'];
    
    if ($domainoptions['affiliateid'] != ""){ 
        $html .= ', affiliateID: "' . $domainoptions['affiliateid'] .'"' ; 
    }

    if ($domainoptions['displayPoweredByLink'] != ""){
        $html .= ', displayPoweredBy: ' . $domainoptions['displayPoweredByLink']  ; 
    }
    
    $html .= '  });';
    $html .= '</script>';
    
  $upload_dir = wp_upload_dir();
    wp_register_style('peepable_publisher_options', esc_url( $upload_dir['baseurl']) . '/peepable/css/peepable_publisher.css'); 
    wp_enqueue_style('peepable_publisher_options');
    
    return $html;
}

function peepable_chapter_info_function (){
    extract ( shortcode_atts ( array (
            'style' => '',
            ), $atts ) );
	
    // adds a DIV for the chapter info wherever the website admin puts this shortcode

    if ($atts['style'] == ''){
        return '<div id="peepable_chapter_info"></div>'; 
    }else{
            return '<div class="peepable_chapter_style" id="peepable_chapter_info" style=' + $atts['style'] + '></div>'; 
    }
    
}

add_shortcode ('peepable_results', 'peepable_searchresults_function' );
add_shortcode ('peepable_searchbox', 'peepable_searchbox_function' );
add_shortcode ('peepable_chapter_info', 'peepable_chapter_info_function');

// Creating the Peepable sidebar widget
class peepable_sidebar_widget extends WP_Widget {
	function __construct() {
		parent::__construct ( 
				// Base ID of your widget
				'peepable_sidebar_widget', 
				
				// Widget name will appear in UI
				__ ( 'Peepable Search Box', 'peepable_sidebar_widget_domain' ), 
				
				// Widget description
				array (
						'description' => __ ( 'Peepable widget add Peepable search box to sidebar ', 'peepable_sidebar_widget_domain' ) 
				) );
	}
	
// Creating widget front-end
public function widget($args, $instance) {
    $title = apply_filters ( 'widget_title', $instance ['title'] );
    // before and after widget arguments are defined by themes
    echo $args ['before_widget'];
    if (! empty ( $title ))
            echo $args ['before_title'] . $title . $args ['after_title'];
    $puboptions = peepable_getpublisheroptions();
    $domainoptions = peepable_getdomainoptions();

    $html = '<div>';
    $html .= '<link rel="stylesheet" href="' . $domainoptions['csspath']. '">';
    //$hmtl .= '<link rel="stylesheet" href="' . plugins_url('css/publisher_options.css' , __FILE__) . '">';
    $html .= '<div class="peepable-search-box"></div>';
    $html .= '<script';
    $html .= ' src="' . $domainoptions['widgetpath'] . '"';
    $html .=  ' type="text/javascript"></script>';
    $html .= ' <script type="text/javascript">';
    $html .= ' PeepableToolkit.initialise({';
        $html .= ' afl: "' . $puboptions['collection_key'] . '",';
    $html .= ' client_id: "' . $puboptions['domain_key'] . '",';
    $html .= ' searchCriteria: "' . $_GET["q"] . '",';
    $html .= ' search_url_template: "' . $puboptions['url_template'] . '",';
    $html .= ' hco: "' . $puboptions['hco'] . '",';
    $html .= ' FacebookAppId: "' . $domainoptions['facebookappid'] . '",';
    $html .= ' continueAtPeepEnd: ' . $domainoptions['continueAtPeepEnd'] . ',';
    $html .= ' displayPublishedDate: ' . $domainoptions['displayPublishedDate'];
    
    if ($domainoptions['affiliateid'] != ""){ 
        $html .= ', affiliateID: "' . $domainoptions['affiliateid'] .'"' ; 
    }

    if ($domainoptions['displayPoweredByLink'] != ""){
        $html .= ', displayPoweredBy: ' . $domainoptions['displayPoweredByLink']  ; 
    }
    
    $html .= '  });';
    $html .= '</script>';
    $html .= '</div>';
    echo $html;
    
    $upload_dir = wp_upload_dir();
    wp_register_style('peepable_publisher_options', esc_url( $upload_dir['baseurl']) . '/peepable/css/peepable_publisher.css'); 
    wp_enqueue_style('peepable_publisher_options');
    
    		
    // End of Peepable search box code
    echo $args ['after_widget'];

    $upload_dir = wp_upload_dir();
    wp_register_style('peepable_publisher_options', esc_url( $upload_dir['baseurl']) . '/peepable/css/peepable_publisher.css'); 
    wp_enqueue_style('peepable_publisher_options');
}
	
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
		?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<?php 
		}
	
	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array ();
		$instance ['title'] = (! empty ( $new_instance ['title'] )) ? strip_tags ( $new_instance ['title'] ) : '';
		return $instance;
	}
} // Class peepable_sidebar_widget ends here
  
// Register and load the widget
function peepable_load_widget() {

    	register_widget ( 'peepable_sidebar_widget' );
}
add_filter('query_vars', 'peepable_parameter_queryvars' );
function peepable_parameter_queryvars( $qvars )
{
    $qvars[] = 'keyword';
    $qvars[] = 'collection_key'; // added so we can override the collection key from a url option
    $qvars[] = "url_template"; // added so we can override the url template (search results page) from a url option
return $qvars;
}

function peepable_getdomainoptions(){
    
    // these are the options that apply to the settings for Peepable across the whole website
    // Read in existing options from database for use by the search box

    //affiliate program
    $affiliateprogramoptions = get_option('peepable_options_page_affiliateprogram');
    $affiliateid = $affiliateprogramoptions ['affiliateprogram_affiliateid'];
    if (ISSET($affiliateprogramoptions ['affiliateprogram_displaypoweredbylink'])){
        $displayPoweredByLink = 'true';
    }else{
        $displayPoweredByLink = 'false';
    }
    
    // style options
    $styleoptions = get_option('peepable_options_page_style');
    if (ISSET ($styleoptions ['style_continueatpeepend'])){
        $continueAtPeepEnd = 'true';
    }else {
        $continueAtPeepEnd = 'false';
    }
    if (ISSET ($styleoptions ['style_displaypublisheddate'])){
        $displayPublishedDate = 'true';
    }else{
        $displayPublishedDate = 'false';
    }
    
    if (ISSET ($styleoptions ['style_buttoncolor'])){
        $buttoncolor = $styleoptions ['style_buttoncolor'];
    }
        
    //search defaults
    $searchdefaultoptions = get_option('peepable_options_page_searchdefaults');
    $facebookappid  = $searchdefaultoptions ['searchdefaults_facebookappid'];
    $domainkeywords = $searchdefaultoptions ['searchdefaults_keywords'];
    
    // general options
    $generaloptions = get_option('peepable_options_page_general');
    $pluginversion = $generaloptions ['general_pluginversion'];
    
    // API key options
    $apikeyoptions = get_option('peepable_options_page_apikey');
    //$apiclientid = decrypt(get_option ('peepable_opt_api_clientid'),  AUTH_KEY);
    $apiclientid = $apikeyoptions ['apikey_clientid'];
    $apiclientsecret = $apikeyoptions ['apikey_clientsecret'];

    if (isset ($pluginversion)){
        if ($pluginversion == ''){ // default to live version 
            $pluginversion = 'Latest stable release';
        }
    }
    else {
        $pluginversion = 'Latest stable release';
    }

    // changed to https on 17/6/2016
    if ($pluginversion == 'Development'){ //dev version
        // keep this version on s3 - rapid deployment over for dev
        $csspath = 'https://d2rxypunpdbu7x.cloudfront.net/2016-10/css/main.css';
        $widgetpath = 'https://d2rxypunpdbu7x.cloudfront.net/2016-10-17/js/main.js';
    }
    else{
        if ($pluginversion == 'Latest stable release'){ //live version
            //$csspath = 'https://d2rxypunpdbu7x.cloudfront.net/css/main.css?v=2015-09-25th';
            //$widgetpath = 'https://d2rxypunpdbu7x.cloudfront.net/js/main.js?v=2015-09-25th';
            $csspath = 'https://d2rxypunpdbu7x.cloudfront.net/2016-10-17/css/main.css';
            $widgetpath = 'https://d2rxypunpdbu7x.cloudfront.net/2016-10-17/js/main.js';
        }else{ //beta test version only 
            $csspath = 'https://d2rxypunpdbu7x.cloudfront.net/css/main.css?v=2015-08-12th';
            $widgetpath = 'https://d2rxypunpdbu7x.cloudfront.net/js/main.js?v=2015-08-12th';
        }
    }
    return array (
                    'csspath' => $csspath,
                    'widgetpath' => $widgetpath,
                    'facebookappid' => $facebookappid,
                    'domainkeywords' => $domainkeywords ,
                    'pluginversion' => $pluginversion,
                    'continueAtPeepEnd' => $continueAtPeepEnd,
                    'displayPublishedDate' => $displayPublishedDate,
                    'api_clientid' => $apiclientid,
                    'api_clientsecret' => $apiclientsecret,
                    'affiliateid' => $affiliateid, 
                    'buttoncolor' => $buttoncolor,
                    'displayPoweredByLink' => $displayPoweredByLink
	);
}

function peepable_getpublisheroptions (){
    
    // these are the options that apply only to a single collection/publsiher, 
    // separted from peepabledomainoptions so that we can have more than one publisher/colection shown on different pages of the same website
    // different publisheroptions are not allowed for in admin page just yet but are in shortcode options
    
    $searchdefaultoptions = get_option('peepable_options_page_searchdefaults');
    $collection_key = $searchdefaultoptions ['searchdefaults_collectionkey'];
    $domain_key = $searchdefaultoptions ['searchdefaults_domainkey'];
    $url_template = $searchdefaultoptions ['searchdefaults_searchurltemplate'];
    $hco = $searchdefaultoptions ['searchdefaults_hco'];

  
    return array (
			'domain_key' => $domain_key,
			'url_template' => $url_template,
                        'collection_key' => $collection_key,
			'hco' => $hco
                  );
}

add_action ( 'widgets_init', 'peepable_load_widget' );

if (!function_exists('encrypt')) {
    function encrypt($input_string, $key){
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $h_key = hash('sha256', $key, TRUE);
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $h_key, $input_string, MCRYPT_MODE_ECB, $iv));
    }
}

if (!function_exists('decrypt')) {
    function decrypt($encrypted_input_string, $key){
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $h_key = hash('sha256', $key, TRUE);
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $h_key, base64_decode($encrypted_input_string), MCRYPT_MODE_ECB, $iv));
    }
}