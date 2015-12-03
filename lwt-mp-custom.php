<?php
####################################################
/**
 * @purpose - remove most seek not required features by wp default
 * @author: AjayKwatra
 * @author_uri: http://limewebtech.com/
 * @author_email: ajaykwatra@gmail.com
 * @donate: akpayment@paypal.com
 * @version: 1.0.0
 * @tested: wordpress multisite environment
 * */
 #####################################################
 
 
/**
 * @purpose: WPMU marketpress whitelable for setting pages etc.
 * @ no-db insert etc.
 * @safe to use
 * 
 **/
 
function storeSettingCss(){

if(!is_super_admin()){

	echo <<<STYLE

<style>

#mp-settings-general-advanced-settings{ display:none}

#mp-settings-general-advanced-settings + p.submit {display:none}

.update-nag{display:none} /*hide mp notices*/

.mp_image {display:none}

.mp_title {display:none}

.mp_title + p {display:none}

</style>


STYLE;

}


}

add_action('admin_footer','storeSettingCss');


/**
 * @purpose: marketpress remove unwanted WPMU - MP menu.
 * @ no-db insert etc.
 * @safe to use
 * 
 **/
//filter mp store menu
function mp_store_sub_menus(){

	//admin.php?page=store-settings-capabilities

	if(!is_super_admin()){
		global $menu;
		global $submenu;
    
    $store_setting_arr = $submenu['store-settings'];	
    $exclude = array('User Capabilities','MP Mojo');
    
    foreach($store_setting_arr as $key => $val){

    	if( in_array($val[0], $exclude) ){

    		unset($store_setting_arr[$key]);
    	}
    }

$submenu['store-settings'] = $store_setting_arr;

    //_db($store_setting_arr);
	
	}


}

add_action( 'admin_menu', 'mp_store_sub_menus' , 999 );



/**
/* to hack for MP force submit paypal id
* http://demo.lcl/wp-admin/network/settings.php?page=network-store-settings
* @fixed - hack 
***/
function wmpu_mp_network_setting_disable_paypal_id_on_save_lwt(){
	// - to hack for MP force submit paypal id - network settting page
    echo $jsc =  <<<JSC
        
    <script type="text/javascript">

        jQuery(function(){

            jQuery("input[name='gateways[paypal_chained][email]']").removeAttr("data-rule-required");
            jQuery("input[name='gateways[paypal_chained][email]']").removeAttr("data-rule-email");
            jQuery("input[name='gateways[paypal_chained][email]']").removeAttr("aria-required");

        } );


    </script>


JSC;



}

add_action('admin_footer','wmpu_mp_network_setting_disable_paypal_id_on_save_lwt');
