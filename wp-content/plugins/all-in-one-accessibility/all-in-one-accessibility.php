<?php

/**
 * Plugin Name:         All in One Accessibility
 * Plugin URI:          https://www.skynettechnologies.com/all-in-one-accessibility
 * Description:         A plugin to create ADA Accessibility
 * Version:             1.7
 * Requires at least:   4.9
 * Requires PHP:        7.0
 * Author:              Skynet Technologies USA LLC
 * Author URI:          https://www.skynettechnologies.com
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 */

$aioa_current_url_parse = parse_url(get_site_url());
$aioa_website_hostname = $aioa_current_url_parse['host'];

$aioa_url = 'https://ada.skynettechnologies.us/check-website';
$aioa_args = ['sslverify' => false, 'body' => array('domain' =>  $aioa_website_hostname)];
$aioa_curl_result = wp_remote_post($aioa_url, $aioa_args);
$settingURLObject = (object)json_decode(wp_remote_retrieve_body($aioa_curl_result), true);


//print_r($settingURLObject);
//die();

add_action("admin_menu", "ada_accessibility_menu");
if (!function_exists("ada_accessibility_menu")) {
    function ada_accessibility_menu()
    {
        $page_title = "All in One Accessibility Settings";
        $menu_title = "All in One Accessibility";
        $capability = "manage_options";
        $menu_slug = "ada-accessibility-info";
        $function = "ADAC_info_page";
        $icon_url = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNi4wLjMsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAxNiAxNiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTYgMTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiM5Q0EyQTc7fQ0KPC9zdHlsZT4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04LDNDNS4zLDMsMyw1LjIsMyw4czIuMiw1LDUsNXM1LTIuMiw1LTVTMTAuNywzLDgsM3ogTTgsNC4xYzAuNSwwLDAuOCwwLjQsMC44LDAuOFM4LjUsNS44LDgsNS44DQoJCVM3LjIsNS40LDcuMiw1QzcuMiw0LjUsNy41LDQuMSw4LDQuMXogTTEwLjYsNi41TDguNyw3LjFjLTAuMSwwLTAuMiwwLjEtMC4yLDAuMmMwLDAuMywwLDEsMC4xLDEuMmMwLjIsMC43LDEsMi42LDEsMi42DQoJCWMwLjEsMC4yLDAsMC41LTAuMiwwLjZjLTAuMSwwLTAuMSwwLTAuMiwwYy0wLjIsMC0wLjMtMC4xLTAuNC0wLjNMOCw5LjdsLTAuOSwxLjhjLTAuMSwwLjItMC4yLDAuMy0wLjQsMC4zYy0wLjEsMC0wLjEsMC0wLjIsMA0KCQljLTAuMi0wLjEtMC4zLTAuNC0wLjItMC42YzAsMCwwLjgtMS45LDEtMi42YzAuMS0wLjIsMC4xLTAuOSwwLjEtMS4yYzAtMC4xLTAuMS0wLjItMC4yLTAuMkw1LjQsNi41QzUuMiw2LjUsNSw2LjIsNS4xLDYNCgkJczAuMy0wLjMsMC42LTAuM2MwLDAsMS43LDAuNSwyLjMsMC41czIuMy0wLjYsMi4zLTAuNmMwLjItMC4xLDAuNSwwLjEsMC41LDAuM0MxMC45LDYuMiwxMC44LDYuNSwxMC42LDYuNXoiLz4NCgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOCwwQzMuNiwwLDAsMy42LDAsOHMzLjYsOCw4LDhzOC0zLjYsOC04UzEyLjQsMCw4LDB6IE04LDE0Yy0zLjMsMC02LTIuNy02LTZzMi43LTYsNi02czYsMi43LDYsNg0KCQlTMTEuMywxNCw4LDE0eiIvPg0KPC9nPg0KPC9zdmc+DQo=";
        $position = 4;
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
    }
    // Call update_ADAC_info function to update database
    
}
if (!function_exists("ADAC_info_page")) {
    function ADAC_info_page()
    {
        global $aioa_website_hostname, $settingURLObject ;
        wp_enqueue_script("ADA_Accessibility_Validation_js", plugins_url("js/validation.js", __FILE__));
        wp_enqueue_script("ADA_Accessibility_Color_js", plugins_url("/js/jscolor.js", __FILE__));
       
        ?>
        <h1>All in One Accessibility™</h1>
        <hr>
        <style>
            .get-strated-btn, .get-strated-btn:hover {
            background-color: #2855d3;
            color: white;
            padding: 5px 5px;
            text-decoration: none;
            }

              .aioa-cancel-button {
                  text-decoration: none;
                  display: inline-block;
                  vertical-align: middle;
                  border: 2px solid #dd2755;
                  border-radius: 4px 4px 4px 4px;
                  background-color: #ea2362;
                  box-shadow: 0px 0px 2px 0px #333333;
                  color: #ffffff;
                  text-align: center;
                  box-sizing: border-box;
                  padding: 10px;
              }
            .aioa-cancel-button:hover {
                border-color: #e21f4a;
                background-color: white;
                box-shadow: 0px 0px 2px 0px #333333;
            }

            .aioa-cancel-button:hover .mb-text {
                color: #e82757;
            }

        </style>
        <table class="form-table" style="max-width: 1440px;">
            <tr valign="top">
                <th colspan="2">
                    All in One Accessibility widget improves website ADA compliance and browser experience for ADA, WCAG 2.1
                    & 2.2, Section 508, California Unruh Act, Australian DDA, European EAA EN 301 549, UK Equality Act (EA),
                    Israeli Standard 5568, Ontario AODA, Canada ACA, German BITV, France RGAA, Brazilian Inclusion Law (LBI
                    13.146/2015), Spain UNE 139803:2012, JIS X 8341 (Japan), Italian Stanca Act and Switzerland DDA
                    Standards without changing your website's existing code.

                </th>
            </tr>


            <tr valign="top">
                <th colspan="2" >
                    <?php
                        try{
                            

                                /*echo "<pre>";
                                print_r($settingURLObject);
                                echo "</pre> done";*/

                            if(isset($settingURLObject->status) && $settingURLObject->status == 3)
                            { ?>
                                <h3 style="color: #aa1111">It appears that you have already registered! Please click on the "Manage Subscription" button to renew your subscription.<br> Once your plan is renewed, please refresh the page.</h3>
                                <div style="text-align: left; width:100%; padding-bottom: 10px;"><a target="_blank" class="aioa-cancel-button"  href="<?php echo $settingURLObject->settinglink;?>">Manage Subscription</a></div>
                            <?php }
                            else if(isset($settingURLObject->status) && $settingURLObject->status > 0 && $settingURLObject->status < 3)
                            {
                                ?>
                                    <h2>Widget Preferences:</h2>
                                    <div style="text-align: right; width:100%; padding-bottom: 10px;"><a target="_blank" class="aioa-cancel-button"  href="<?php echo $settingURLObject->manage_domain;?>">Manage Subscription</a></div>
                                    <iframe id="aioamyIframe" width="100%" style="max-width: 1920px;" height="2900px"  src="<?php echo $settingURLObject->settinglink; ?>"></iframe>
                                     
                                <?php                          
                                 
                            }                                                
                            else{

                                ?>
                                <iframe src="https://ada.skynettechnologies.us/trial-subscription?isframe=true&website=<?php echo $aioa_website_hostname;?>&platform=wordpress&utm_source=wordpress-plugin&utm_medium=create-account&utm_campaign=trial-subscription" height="1100px;" width="80%" style="border: none;"></iframe>
                                <?php
                                } 
                        } catch(Exception $e){}

                    ?>
                </th>                
            </tr>
        </table>
        
            <?php
           
    }
}

   
function aioa_add_code_snippet(){
    global $settingURLObject;
    $aioalicenseKey = "";
    if(isset($settingURLObject->api_key))
    {
        $aioalicenseKey = $settingURLObject->api_key;
    }
    ?>
    <script>
        setTimeout(() => {
            let aioa_script_tag = document.createElement("script");
            aioa_script_tag.src = "https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?aioa_reg_req=true&colorcode=&token=<?php echo $aioalicenseKey;?>&position=bottom_left";
            aioa_script_tag.id = "aioa-adawidget";
            aioa_script_tag.defer = true;
            document.getElementsByTagName("head")[0].appendChild(aioa_script_tag);
        }, 1000);
    </script>
    <?php
}
add_action("wp_head", "aioa_add_code_snippet", 10);
?>
