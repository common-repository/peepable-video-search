<?php

/* 
 * Peepable plugin admin page
 */


add_action('admin_menu', 'peepablewidget_plugin_setup_menu');
function peepablewidget_plugin_setup_menu() {
	
    add_menu_page ( 
        'Peepable Options', 
        'Peepable', 
        'manage_options', 
        'peepable_options', 
        'peepable_options_page_callback' // function which renders the options page
    ); // was peepablewidget_admin_init
   
}


add_action('admin_init', 'peepable_options');
function peepable_options (){
    
    // General Options
    add_settings_section( 
        'peepable_options_general',          // The unique ID - the slug - for this section
        'General',          // The text to the display in the browser when this section is active
        'peepable_options_general_callback',   // The function used to render this page to the screen              
        'peepable_options_page_general' // slug of page on which to display this content
    );
 
    add_settings_field(  
        'general_clientid', // slug of the field
        'Client ID', //field title          
        'peepable_options_general_clientid_callback',   // function to fill the field
        'peepable_options_page_general',   // page on which to show the section
        'peepable_options_general', // section in which to show the field    
        array( 'label_for' => 'general_clientid' ) // 'label for' and 'class'
    );
    add_settings_field(  
        'general_pluginversion', // slug of the field
        'Peepable version', //field title          
        'peepable_options_general_pluginversion_callback',   // function to fill the field
        'peepable_options_page_general',   // page on which to show the section
        'peepable_options_general', // section in which to show the field    
        array( 'label_for' => 'general_pluginversion' ) // 'label for' and 'class'
    );

     // API Key Section
    add_settings_section(   
        'peepable_options_apikey',          // The unique ID - the slug - for this section
        'API Key',          // The text to the display in the browser when this section is active
        'peepable_options_apikey_callback',   // The function used to render this page to the screen              
        'peepable_options_page_apikey' // slug of page on which to display this content
    );
    
    add_settings_field(  
        'apikey_clientid', // slug of the field
        'API Client ID', //field title          
        'peepable_options_apikey_clientid_callback',   // function to fill the field
        'peepable_options_page_apikey',   // page on which to show the section
        'peepable_options_apikey', // section in which to show the field    
        array( 'label_for' => 'apikey_clientid' ) // 'label for' and 'class'
    );
    
        add_settings_field(  
        'apikey_clientsecret', // slug of the field
        'API Client Secret', //field title          
        'peepable_options_apikey_clientsecret_callback',   // function to fill the field with data  
        'peepable_options_page_apikey',   // page on which to show the section
        'peepable_options_apikey', // section in whcih to show the field    
        array( 'label_for' => 'apikey_clientsecret' ) // 'label for' and 'class'
    );
        
    
    // Search Defaults section
    add_settings_section( 
        'peepable_options_searchdefaults',          // The unique ID - the slug - for this section
        'Search Defaults',          // The text to the display in the browser when this section is active
        'peepable_options_searchdefaults_callback',   // The function used to render this page to the screen              
        'peepable_options_page_searchdefaults' // slug of page on which to display this content
    );
  
    add_settings_field( 
        'searchdefaults_domainkey', // slug of the field
        'Domain Key', //field title          
        'peepable_options_searchdefaults_domainkey_callback',   // function to fill the field with data  
        'peepable_options_page_searchdefaults',   // page on which to show the section
        'peepable_options_searchdefaults', // section in whcih to show the field    
        array( 'label_for' => 'searchdefaults_domainkey' ) // 'label for' and 'class'
    );
    
     add_settings_field( 
        'searchdefaults_collectionkey', // slug of the field
        'Collection Key', //field title          
        'peepable_options_searchdefaults_collectionkey_callback',   // function to fill the field with data  
        'peepable_options_page_searchdefaults',   // page on which to show the section
        'peepable_options_searchdefaults', // section in whcih to show the field    
        array( 'label_for' => 'searchdefaults_collectionkey' ) // 'label for' and 'class'
    );
     
    add_settings_field( 
        'searchdefaults_hco', // slug of the field
        'HCO', //field title          
        'peepable_options_searchdefaults_hco_callback',   // function to fill the field with data  
        'peepable_options_page_searchdefaults',   // page on which to show the section
        'peepable_options_searchdefaults', // section in whcih to show the field    
        array( 'label_for' => 'searchdefaults_hco' ) // 'label for' and 'class'
    );
      
    add_settings_field( 
        'searchdefaults_facebookappid', // slug of the field
        'Facebook App ID', //field title          
        'peepable_options_searchdefaults_facebookappid_callback',   // function to fill the field with data  
        'peepable_options_page_searchdefaults',   // page on which to show the section
        'peepable_options_searchdefaults', // section in whcih to show the field    
        array( 'label_for' => 'searchdefaults_facebookappid' ) // 'label for' and 'class'
    );

    add_settings_field( 
        'searchdefaults_keywords', // slug of the field
        'Search Keywords', //field title          
        'peepable_options_searchdefaults_keywords_callback',   // function to fill the field with data  
        'peepable_options_page_searchdefaults',   // page on which to show the section
        'peepable_options_searchdefaults', // section in whcih to show the field    
        array( 'label_for' => 'searchdefaults_keywords' ) // 'label for' and 'class'
    );
    
    add_settings_field( 
        'searchdefaults_searchurltemplate', // slug of the field
        'Search Results Page', //field title          
        'peepable_options_searchdefaults_searchurltemplate_callback',   // function to fill the field with data  
        'peepable_options_page_searchdefaults',   // page on which to show the section
        'peepable_options_searchdefaults', // section in whcih to show the field    
        array( 'label_for' => 'searchdefaults_searchurltemplate' ) // 'label for' and 'class'
    );

    // Style settings
    add_settings_section( 
        'peepable_options_style',          // The unique ID - the slug - for this section
        'Style',          // The text to the display in the browser when this section is active
        'peepable_options_style_callback',   // The function used to render this page to the screen              
        'peepable_options_page_style' // slug of page on which to display this content
    );

        add_settings_field( 
        'style_buttoncolor', // slug of the field
        'Button Color', //field title          
        'peepable_options_style_buttoncolor_callback',   // function to fill the field with data  
        'peepable_options_page_style',   // page on which to show the section
        'peepable_options_style', // section in whcih to show the field    
        array( 'label_for' => 'style_buttoncolor' ) // 'label for' and 'class'
    );
    
    add_settings_field( 
        'style_displaybublisheddate', // slug of the field
        'Display Published Date', //field title          
        'peepable_options_style_displaybublisheddate_callback',   // function to fill the field with data  
        'peepable_options_page_style',   // page on which to show the section
        'peepable_options_style', // section in whcih to show the field    
        array( 'label_for' => 'style_displaybublisheddate' ) // 'label for' and 'class'
    );
    
    add_settings_field( 
        'style_continueatpeepend', // slug of the field
        'Continue at Peep End', //field title          
        'peepable_options_style_continueatpeepend_callback',   // function to fill the field with data  
        'peepable_options_page_style',   // page on which to show the section
        'peepable_options_style', // section in whcih to show the field    
        array( 'label_for' => 'style_continueatpeepend' ) // 'label for' and 'class'
    );
    
    // Affiliate Program Section
    add_settings_section( 
        'peepable_options_affiliateprogram',          // The unique ID - the slug - for this section
        'Affiliate Program',          // The text to the display in the browser when this section is active
        'peepable_options_affiliateprogram_callback',   // The function used to render this page to the screen              
        'peepable_options_page_affiliateprogram' // slug of page on which to display this content
    );

    add_settings_field( 
        'affiliateprogram_displaypoweredbylink', // slug of the field
        'Display Powered By', //field title          
        'peepable_options_affiliateprogram_displaypoweredbylink_callback',   // function to fill the field with data  
        'peepable_options_page_affiliateprogram',   // page on which to show the section
        'peepable_options_affiliateprogram', // section in whcih to show the field    
        array( 'label_for' => 'affiliateprogram_displaypoweredbylink' ) // 'label for' and 'class'
    );
    
        add_settings_field( 
        'affiliateprogram_affiliateid', // slug of the field
        'Affiliate ID', //field title          
        'peepable_options_affiliateprogram_affiliateid_callback',   // function to fill the field with data  
        'peepable_options_page_affiliateprogram',   // page on which to show the section
        'peepable_options_affiliateprogram', // section in whcih to show the field    
        array( 'label_for' => 'affiliateprogram_affiliateid' ) // 'label for' and 'class'
    );
    // now register all the options
    register_setting('peepable_options_page_general', 'peepable_options_page_general');
    register_setting('peepable_options_page_apikey', 'peepable_options_page_apikey');
    register_setting('peepable_options_page_searchdefaults', 'peepable_options_page_searchdefaults');
    register_setting('peepable_options_page_style', 'peepable_options_page_style', 'peepable_validate_style_options');
    register_setting('peepable_options_page_affiliateprogram', 'peepable_options_page_affiliateprogram', 'peepable_validate_affiliateprogram_options');

}

function peepable_options_page_callback (){
    
// render the options page
    ?>
    <div class="wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2>Peepable Options</h2>  
        <?php settings_errors(); ?>  

        <?php  
                $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'options_general';  
        ?>  

        <h2 class="nav-tab-wrapper">  
            <a href="?page=peepable_options&tab=options_general" class="nav-tab <?php echo $active_tab == 'options_general' ? 'nav-tab-active' : ''; ?>">General</a>  
            <a href="?page=peepable_options&tab=options_apikey" class="nav-tab <?php echo $active_tab == 'options_apikey' ? 'nav-tab-active' : ''; ?>">API Key</a>  
            <a href="?page=peepable_options&tab=options_searchdefaults" class="nav-tab <?php echo $active_tab == 'options_searchdefaults' ? 'nav-tab-active' : ''; ?>">Search Defaults</a>  
            <a href="?page=peepable_options&tab=options_style" class="nav-tab <?php echo $active_tab == 'options_style' ? 'nav-tab-active' : ''; ?>">Style</a>  
            <a href="?page=peepable_options&tab=options_affiliateprogram" class="nav-tab <?php echo $active_tab == 'options_affiliateprogram' ? 'nav-tab-active' : ''; ?>">Affiliate Program</a>  
        </h2>  


        <form method="post" action="options.php">  

                       <?php 
            if( $active_tab == 'options_general' ) {  
                settings_fields( 'peepable_options_page_general' );
                do_settings_sections( 'peepable_options_page_general' ); 
            } else if( $active_tab == 'options_apikey' ) {
                settings_fields( 'peepable_options_page_apikey' );
                do_settings_sections( 'peepable_options_page_apikey' ); 
            } else if( $active_tab == 'options_searchdefaults' ) {
                settings_fields( 'peepable_options_page_searchdefaults' );
                do_settings_sections( 'peepable_options_page_searchdefaults' ); 
            } else if( $active_tab == 'options_style' ) {
                settings_fields( 'peepable_options_page_style' );
                do_settings_sections( 'peepable_options_page_style' ); 
            } else if( $active_tab == 'options_affiliateprogram' ) {
                settings_fields( 'peepable_options_page_affiliateprogram' );
                do_settings_sections( 'peepable_options_page_affiliateprogram' );     
                }
            ?>             
            <?php submit_button(); ?>  
        </form> 

    </div> 
<?php
    
}

// callbacks to render the options sections 
function peepable_options_general_callback () {
// render the options_general page
    
    /* Use the client id to check if they have an account at publishers.peepable.com
     * if not, show a text panel which tells them where to sign up
    */
       
    
    $options = get_option('peepable_options_page_general');  // use last parameter of add_settings_section
    
    $html = '';
    if (!ISSET ($options['general_clientid'])){
        $html .= '<p>Before you can add Peepable search to your video collection and website/s, you will need to get a Peepable publisher account.</p>'
                . '<p>Please sign up a for a Peepable subscription plan at <a href="http://publishers.peepable.com/peepable-plans/" target="_blank"> publishers.peepable.com/plans</a></p>';
    }else{
        $html .= '<p>Check out the <a href="http://publishers.peepable.com/peepable-plans/" target="_blank">Peepable website</a> for more information on setting up Peepable.</p>';
                    }
    echo $html;
}

function peepable_options_apikey_callback () {
    // render the options_apikey page
    echo '<p class="description">Your API key/s can be found on your <a href="http://publishers.peepable.com/api-keys/" target="_blank"> API Keys page</a>. Use of an API key is is not supported in the free version of the plugin.</p></td>';
}

function peepable_options_affiliateprogram_callback () {
// render the options_affiliateprogram page

}
function peepable_options_style_callback () {
// render the style options page

}

function peepable_options_searchdefaults_callback () {
    // render the options_searchdefaults page

}

// callbacks to render the fields on the options pages
function peepable_options_apikey_clientid_callback (){
    
    $options = get_option('peepable_options_page_apikey');  // use last parameter of add_settings_section
    
    //apikey_clientid
    $html = '<input type="text" id="apikey_clientid" name="peepable_options_page_apikey[apikey_clientid]" value="' . $options['apikey_clientid'] . '" size="50"></input>';
    echo $html;
  
}

function peepable_options_apikey_clientsecret_callback (){
    
    $options = get_option('peepable_options_page_apikey');  // use last parameter of add_settings_section
    //apikey_clientid
    $html = '<input type="text" id="apikey_clientsecret" name="peepable_options_page_apikey[apikey_clientsecret]" value="' . $options['apikey_clientsecret'] . '" size="50"></input>';
    echo $html;
}

//searchdefaults options call back
function peepable_options_searchdefaults_collectionkey_callback(){
    $options = get_option('peepable_options_page_searchdefaults');  // use last parameter of add_settings_section
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_searchdefaults[searchdefaults_collectionkey]"';
    $html .= 'value="' . $options['searchdefaults_collectionkey'] . '" size="50">';
    $html .= '<p class="description">Your collection key/s can be found on your <a href="http://publishers.peepable.com/collections/" target="_blank"> collections page</a>.</p></td>    ';
    echo $html;
}

function peepable_options_searchdefaults_domainkey_callback(){
    $options = get_option('peepable_options_page_searchdefaults');  // use last parameter of add_settings_section
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_searchdefaults[searchdefaults_domainkey]"';
    $html .= 'value="' . $options['searchdefaults_domainkey'] . '" size="50">';
    $html .=  '<p class="description">Your domain key/s can be found on your <a href="http://publishers.peepable.com/domains//" target="_blank"> domains page</a>.</p></td>';
    echo $html;
}

function peepable_options_searchdefaults_searchurltemplate_callback(){
    $options = get_option('peepable_options_page_searchdefaults');  // use last parameter of add_settings_section
    
    if (!ISSET ($options['searchdefaults_searchurltemplate'])){
        $options['searchdefaults_searchurltemplate'] = '/peepable/?q={{search-criteria}}';
    }
    
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_searchdefaults[searchdefaults_searchurltemplate]"';
    $html .= 'value="' . $options['searchdefaults_searchurltemplate'] . '" size="50">';
    $html .=  '<p class="description">The page entered in this field will be used to display the Peepable search results. Please add a new page with this URL and enter the following shortcode text into the body of the new page.</p>';
    $html .=  '<p></p>'; 
    $html .=  '<p class="description">[peepable_results domain_key="{your domain_key}" collection_key="{your collection_key}" url_template="{your URL template}"]</p>';
    $html .=  '<p>For example:</p>';
    
    $collectionkey = $options['searchdefaults_collectionkey'];
    $domainkey = $options['searchdefaults_domainkey'];
    $searchpage = $options['searchdefaults_searchurltemplate'];
    $html .=  '<p class="description">[peepable_results domain_key="' . $domainkey . '" collection_key="' . $collectionkey . '" url_template="' . $searchpage . '"]</p>';
    echo $html;
}

function peepable_options_searchdefaults_hco_callback(){
    $options = get_option('peepable_options_page_searchdefaults');  // use last parameter of add_settings_section
    
    if (!ISSET ($options['searchdefaults_hco'])){
        $options['searchdefaults_hco'] = "4.5";
    }else{
        if ($options['searchdefaults_hco'] == ""){
            $options['searchdefaults_hco'] = "4.5";
        }
    }
    
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_searchdefaults[searchdefaults_hco]"';
    $html .= 'value="' . $options['searchdefaults_hco'] . '" size="4">';
    $html .=  '<p class="description">Enter the value into this field if advised by the Peepable support team. (default value 4.5)</p>';
    echo $html;
}

function peepable_options_searchdefaults_facebookappid_callback(){
    $options = get_option('peepable_options_page_searchdefaults');  // use last parameter of add_settings_section
    
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_searchdefaults[searchdefaults_facebookappid]"';
    $html .= 'value="' . $options['searchdefaults_facebookappid'] . '" size="16">';
    
    $html .=  '<p class="description">Enter the Facebook App ID as advised by the Peepable support team.</p>';
    echo $html;
}

function peepable_options_searchdefaults_keywords_callback(){
    $options = get_option('peepable_options_page_searchdefaults');  // use last parameter of add_settings_section
    
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_searchdefaults[searchdefaults_keywords]"';
    $html .= 'value="' . $options['searchdefaults_keywords'] . '" size="50">';
    
    $html .=  '<p class="description">Enter the most common search keywords/phrases which your users will use to discover your content.</p>';
    echo $html;
}

// style options callbacks
function peepable_options_style_buttoncolor_callback(){
    $options = get_option('peepable_options_page_style');  // use last parameter of add_settings_section
    
    if (!ISSET ($options['style_buttoncolor'])){
        $options['style_buttoncolor'] = '#1a8fbe';
    }
    
    $html =  '<input type="text" name="peepable_options_page_style[style_buttoncolor]" value="' . $options['style_buttoncolor'] . '" class="peepable-button-color-field" data-default-color="#1a8fbe" />';
    echo $html;
}

function peepable_options_style_continueatpeepend_callback(){
    $options = get_option('peepable_options_page_style');  // use last parameter of add_settings_section
    
    if (ISSET ($options['style_continueatpeepend'])){
        if ($options['style_continueatpeepend'] = '1'){
            $checked  = 'checked';
        } else{
            $checked  = '';
        }
    }else{
        $checked  = '';
    }
            
    $html = '<input name="peepable_options_page_style[style_continueatpeepend]" type="checkbox" value="1" '. $checked  . '/>';
    $html .=  '<p class="description">If this option is set, the media will continue to play at the end of a Peep.</p></td>';
    echo $html;
}
 
function peepable_options_style_displaybublisheddate_callback(){

    $options = get_option('peepable_options_page_style');  // use last parameter of add_settings_section
    
    if (ISSET ($options['style_displaypublisheddate'])){
        if ($options['style_displaypublisheddate'] = '1'){
            $checked  = 'checked';
        } else{
            $checked  = '';
        }
    }else{
        $checked  = '';
    }
    
    $html = '<input name="peepable_options_page_style[style_displaypublisheddate]" type="checkbox" value="1" '. $checked . '/>';
    $html .=  '<p class="description">If this option is set, the publisher date will be displayed for each video.</p></td>';
    echo $html;
}
    
function peepable_enqueue_color_picker(  ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('js/admin.js', dirname(__FILE__)) , array( 'wp-color-picker' ), false, true ); 
} 
add_action( 'admin_enqueue_scripts', 'peepable_enqueue_color_picker' );

function peepable_options_affiliateprogram_displaypoweredbylink_callback(){

    $options = get_option('peepable_options_page_affiliateprogram');  // use last parameter of add_settings_section
    
    if (ISSET ($options['affiliateprogram_displaypoweredbylink'])){
        if ($options['affiliateprogram_displaypoweredbylink'] = '1'){
            $checked  = 'checked';
        } else{
            $checked  = '';
        }
    }
    
    $html = '<input name="peepable_options_page_affiliateprogram[affiliateprogram_displaypoweredbylink]" type="checkbox" value="1" '. $checked . '/>';
    $html .=  '<p class="description">Unset this option to remove the Powered By Peepable logo. (Always checked if you are an <a href="http://publishers.peepable.com/partners" target="_blank">Affiliate Program</a> member).</p></td>';
    echo $html;
}

function peepable_options_affiliateprogram_affiliateid_callback(){
    
    $options = get_option('peepable_options_page_affiliateprogram');  // use last parameter of add_settings_section
  
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_affiliateprogram[affiliateprogram_affiliateid]"';
    $html .= 'value="' . $options['affiliateprogram_affiliateid'] . '" size="5">';
    $html .=  '<p class="description">Enter your <a href="http://publishers.peepable.com/partners" target="_blank">Peepable Affiliate Program ID</a> to receive commission on sales arising when people find us by clicking the Powered by Peepable link on your website.</p>';
    echo $html;
}

function peepable_options_general_pluginversion_callback(){
    
    $options = get_option('peepable_options_page_general');  // use last parameter of add_settings_section
    
    if (!ISSET ($options['general_pluginversion'])){
        $options['general_pluginversion'] = 'Latest stable release';
    }
    
    $html = '<select name="peepable_options_page_general[general_pluginversion]">';
    $html .= '<option value="' . $options['general_pluginversion'] .'" >' . $options['general_pluginversion']. '</option>';
    $html .= '<option value="Latest stable release" >Latest stable release</option>';
    $html .= '<option value="Beta test">Beta test</option>';
    $html .= '<option value="Development">Development</option>';
    $html .= '</select>';
    
    $html .=  '<p class="description">Please select <b>Lastest Stable Release</b> unless otherwise advised.</p>';
    echo $html;
}

function peepable_options_general_clientid_callback (){
   
    $options = get_option('peepable_options_page_general');  // use last parameter of add_settings_section
    $html = '<input type="text"';
    $html .= 'name="peepable_options_page_general[general_clientid]"';
    $html .= 'value="' . $options['general_clientid'] . '" size="15">';
    $html .= '<p>Please enter your Client ID from the <a href="https://publishers.peepable.com/userdetails/" target="_blank">https://publishers.peepable.com/userdetails</a> page.</p>';
    echo $html;
}

function peepable_validate_style_options( $fields ) { 
     
    $valid_fields = $fields;
     
      // Validate Button Color
    $buttoncolor = trim( $fields['style_buttoncolor'] );
    $buttoncolor = strip_tags( stripslashes( $buttoncolor ) );
     
    // Check if is a valid hex color
    if( FALSE === peepable_check_color( $buttoncolor ) ) {
     
        // Set the error message
        add_settings_error( 'style_buttoncolor', 'peepable_buttoncolor_error', 'Please insert a valid color for your buttons', 'error' ); // $setting, $code, $message, $type
   
    } else {
     
        $valid_fields['style_buttoncolor'] = $buttoncolor;  
    
    }
     
    if (ISSET ($valid_fields['style_buttoncolor'])){
        // Write out the CSS to peepable_publisher.css 
        peepable_updatepublisheroptionsstylecss ($valid_fields['style_buttoncolor']);
    }
    return apply_filters( 'validate_options', $valid_fields, $fields);
}
 
/**
 * Function that will check if value is a valid HEX color.
 */
function peepable_check_color( $value ) { 
     
    if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
        return true;
    }
    return false;
}

function peepable_validate_affiliateprogram_options( $fields ) { 
     
    $valid_fields = $fields;
    
    $affiliateid = trim( $fields['affiliateprogram_affiliateid'] );
    
    if( !$affiliateid ) {
        
    } else {
        // force the powered by link to on
        $valid_fields['affiliateprogram_displaypoweredbylink'] = '1';  
        $valid_fields['affiliateprogram_affiliateid'] = $affiliateid;
    }

    
    peepable_updatepublisheroptionsaffiliatecss ($valid_fields); //always update in case the poweredby option has changed
    
    return apply_filters( 'validate_options', $valid_fields, $fields);
}

function peepable_updatepublisheroptionsaffiliatecss ( $affiliateprogram)
{
    
}

function peepable_updatepublisheroptionsstylecss ( $buttoncolor)
{
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/peepable/css';
    
    if (!is_dir($upload_dir)) {
        if ( wp_mkdir_p( $upload_dir ) === FALSE ){
            $error = new WP_Error();
            $error->add( 'invalid', "Folder $upload_dir could not be created" );
            return $error;
        }
    }
    
    $publisher_stylesheet =  $upload_dir . '/peepable_publisher.css';
        
    $color = $buttoncolor;
    if (!ISSET ($buttoncolor)){ // function parameter takes precedence
        $styleoptions = get_option('peepable_options_page_style');
        if (ISSET ($styleoptions ['style_buttoncolor'])){
           $color = $styleoptions ['style_buttoncolor'];
        }else {
            $color = '#1a8fbe';
        }
    }
        
        
    $peepable_publisher_options_css = "
        .peepable-button{
            background: none repeat scroll 0 0 {$color};
        }
        .peepable-video-item-circle-dot {
            background-color: {$color};
        }
        .peepable-more-matches {
            background-color: {$color};
            border-color: {$color};
        }
        .peepable-search-button{
            background-color: {$color};
        }
        .peepable-video-item-match.active .peepable-video-item-circle-dot {
            background-color: {$color};
        }
        .peepable-video-item-peep-text em {
            font-style: normal;
            color: {$color};
        }
        .peepable-search-box input, .peepable-search-results input {
            line-height: normal;
            height: 40px;
        }";

    // Write the contents back to the CSS file
    global $wp_filesystem;        
    WP_Filesystem(); 
    if ($wp_filesystem->exists($publisher_stylesheet)){
        $wp_filesystem->delete ($publisher_stylesheet);
        if ($wp_filesystem->exists($publisher_stylesheet)){
            echo "could not delete the peepable publisher stylesheet";
        }
    }
    $wp_filesystem->put_contents( $publisher_stylesheet, $peepable_publisher_options_css, 0644 ); // Finally, store the file :D
}
