<?php
   
    // if uninstall.php is not called by WordPress, die
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        die;
    }
 
      delete_option ( 'peepable_opt_collection_key');
      delete_option ( 'peepable_opt_domain_key');
      delete_option ( 'peepable_opt_search_url_template');
      delete_option ( 'peepable_opt_hco');
      delete_option ('peepable_opt_facebookappid');
      delete_option ('peepable_opt_domainkeywords');
      delete_option ('peepable_opt_pluginversion');
      delete_option ('peepable_opt_continueAtPeepEnd');
      delete_option ('peepable_opt_displayPublishedDate');
      delete_option ('peepable_opt_api_clientid');
      delete_option ('peepable_opt_api_clientsecret');
      delete_option ('peepable_opt_displayPoweredByLink');
      delete_option ('peepable_opt_affiliateid');
      
