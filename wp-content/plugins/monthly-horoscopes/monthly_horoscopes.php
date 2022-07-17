<?php
/*
Plugin Name: Monthly Horoscopes
Plugin URI: https://astrologyyard.com/astrology-plugins-wordpress.php
Description: Add sun sign monthly horoscopes to your site's pages and posts for your readers. This <a href="https://astrologyyard.com/astrology-plugins-wordpress.php" target="_blank">astrology wordpress plugin</a> uses a service provided by My<a href="https://www.myastrologycharts.com" target="_blank">Astrology Charts</a>.com to fetch data.
Version: 1.3
Tested up to: 5.8.1 
Author: Seeing With Stars 
Author URI: http://seeingwithstars.net
License: GPLv2 
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 
Monthly Horoscopes is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Monthly Horoscopes is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details. 
*/


/*
   Adds the shortcode so using the shortcode [monthly_horoscopes] in the text displays the horoscopes
*/

add_shortcode("monthly_horoscopes", "monthly_horoscopes");

/*
    Called when the Plugin is Activated
*/

function activate_monthly_horoscopes_plugin () 
{
    $apikey = uniqid();
    $initialnumbermonths = 1;
    delete_option('horoscopes_options');
    delete_option('generatedapikey');
    add_option('generatedapikey',$apikey);
    delete_option('initialnumbermonths');
    add_option('initialnumbermonths',$initialnumbermonths);
    $horoscopesclientpath = 'https://www.myastrologycharts.com/';
    $horoscopesclientinsert = 'horoscopesclientinsert.php';
    $params = sprintf('<horoscopesRequest apikey="%s" numbermonths="%d"></horoscopesRequest>',$apikey,$initialnumbermonths);
    $url = sprintf ("%s%s?requestxml=%s",$horoscopesclientpath,$horoscopesclientinsert,urlencode($params));
    $body = wp_remote_get($url);
/*
    $filename = './debugactivationhoroscopes.txt';
    if (!$handle = fopen($filename, 'w'))
    {
        print "Cannot open file ($filename)";
        exit;
    }
    fprintf ($handle,"url is %s\n",$url);
*/
}
register_activation_hook( __FILE__, 'activate_monthly_horoscopes_plugin');

/*
    Called when the Plugin is Deactivated
*/

function deactivate_monthly_horoscopes_plugin()
{
    $apikey = get_option('generatedapikey');
/*
    $filename = './debugdeactivationhoroscopes.txt';
    if (!$handle = fopen($filename, 'w'))
    {
        print "Cannot open file ($filename)";
        exit;
    }
    fprintf ($handle,"apikey is %s\n",$apikey);
*/
    $horoscopesclientpath = 'https://www.myastrologycharts.com/';
    $horoscopesclientdelete = 'horoscopesclientdelete.php';
    $params = sprintf('<horoscopesRequest apikey="%s"></horoscopesRequest>',$apikey);
    $url = sprintf ("%s%s?requestxml=%s",$horoscopesclientpath,$horoscopesclientdelete,urlencode($params));
    $body = wp_remote_get($url);
}
register_deactivation_hook( __FILE__, 'deactivate_monthly_horoscopes_plugin');

/*
    Addis the submenu to the Wordpress Dashboard
*/

function monthly_horoscopes_admin_menu_setup()
{
    add_submenu_page
    (
        'options-general.php',
        'Monthly Horoscopes Settings',
        'Monthly Horoscopes',
        'manage_options',
        'horoscopes',
        'monthly_horoscopes_admin_page_screen'
    );
}
add_action('admin_menu', 'monthly_horoscopes_admin_menu_setup');

/*
    Display the Horoscopes Admin Page
*/

function monthly_horoscopes_admin_page_screen()
{
    global $submenu;
    $page_data = array();
    foreach($submenu['options-general.php'] as $i => $menu_item) 
    {
        if($submenu['options-general.php'][$i][2] == 'horoscopes')
            $page_data = $submenu['options-general.php'][$i];
    }
?>
    <div class="wrap">
    <?php screen_icon();?>
<?php
    $options = get_option('horoscopes_options');
    if ($options)
    {
        $websitename = (isset($options['websitename_template'])) ? $options['websitename_template'] : '';
        $apikey = (isset($options['apikey_template'])) ? $options['apikey_template'] : '';
        $contactemail = (isset($options['contactemail_template'])) ? $options['contactemail_template'] : '';
        $numbermonths  = (isset($options['numbermonths_template'])) ? $options['numbermonths_template'] : '';
        $horoscopesclientpath = 'https://www.myastrologycharts.com/';
        $horoscopesclientupdate = 'horoscopesclientupdate.php';
        $params = sprintf('<astroRequest apikey="%s" websitename="%s" email="%s" numbermonths="%d"></astroRequest>',$apikey,$websitename,$contactemail,$numbermonths);
        $url = sprintf ("%s%s?requestxml=%s",$horoscopesclientpath,$horoscopesclientupdate,urlencode($params));
        $body = wp_remote_get($url);
    }
?>
    <h2><?php echo $page_data[3];?></h2>
    <form id="horoscopes_options" action="options.php" method="post">
<?php
    settings_fields('horoscopes_options');
    do_settings_sections('horoscopes'); 
    submit_button('Save options', 'primary', 'horoscopes_options_submit');
?>
    </form>
    </div>
<?php
}

/*
    Add the setting link on the Plugins page pointing to the Admin Page
*/

function monthly_horoscopes_plugin_add_settings_link( $links )
{
    $settings_link = '<a href="options-general.php?page=horoscopes">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'monthly_horoscopes_plugin_add_settings_link' );

function monthly_horoscopes_settings_init()
{

    register_setting
    (
        'horoscopes_options',
        'horoscopes_options',
        'monthly_horoscopes_options_validate'
    );

    /*
       Add the Settings Section
    */

    add_settings_section
    (
        'horoscopes_settings',
        '', 
        'monthly_horoscopes_headertext',
        'horoscopes'
    );

    /*
        Add the various fields to be displayed on the screem
    */

    add_settings_field
    (
        'horoscopes_websitename_template',
        'Website URL', 
        'monthly_horoscopes_websitename_field',
        'horoscopes',
        'horoscopes_settings'
    );

    add_settings_field
    (
        'horoscopes_contactemail_template',
        'Contact Email', 
        'monthly_horoscopes_contactemail_field',
        'horoscopes',
        'horoscopes_settings'
    );

    add_settings_field
    (
        'horoscopes_numbermonths_template',
        'Number of Months Displayed', 
        'monthly_horoscopes_numbermonths_field',
        'horoscopes',
        'horoscopes_settings'
    );

    add_settings_field
    (
        'horoscopes_apikey_template',
        'Apikey', 
        'monthly_horoscopes_apikey_field',
        'horoscopes',
        'horoscopes_settings'
    );

    add_settings_field
    (
        'horoscopes_getexternaldata_template',
        'Get External Data', 
        'monthly_horoscopes_getexternaldata_field',
        'horoscopes',
        'horoscopes_settings'
    );

    add_settings_field
    (
        'horoscopes_displaycopyright_template',
        'Display Copyright Message', 
        'monthly_horoscopes_displaycopyright_field',
        'horoscopes',
        'horoscopes_settings'
    );

}
add_action('admin_init', 'monthly_horoscopes_settings_init');

/* 
    Validates Input. Not currently Used.
*/

function monthly_horoscopes_options_validate($input)
{
    return $input;
}

function monthly_horoscopes_headertext()
{
    echo "<p>Please enter your Website URL, Contact Email & Number of Months</p>";
}

function monthly_horoscopes_websitename_field()
{
    $options = get_option('horoscopes_options');
    $websitename = (isset($options['websitename_template'])) ? $options['websitename_template'] : '';
    $websitename = esc_textarea($websitename); //sanitise output
?>
    <input id="websitename_template" name="horoscopes_options[websitename_template]" value="<?php echo$websitename?>">
<?php
}

function monthly_horoscopes_contactemail_field()
{
    $options = get_option('horoscopes_options');
    $contactemail = (isset($options['contactemail_template'])) ? $options['contactemail_template'] : '';
    $contactemail = esc_textarea($contactemail); //sanitise output
?>
    <input id="contactemail_template" name="horoscopes_options[contactemail_template]" value="<?php echo$contactemail?>">
<?php
}

function monthly_horoscopes_numbermonths_field()
{
    $options = get_option('horoscopes_options');
    $numbermonths  = (isset($options['numbermonths_template'])) ? $options['numbermonths_template'] : '';
    $numbermonths = esc_textarea($numbermonths); //sanitise output

    /*
        If Number Months is not set make it the initial value on activation
    */

    if (!$numbermonths)
        $numbermonths = get_option('initialnumbermonths');
?>
    <input id="numbermonths_template" name="horoscopes_options[numbermonths_template]" value="<?php echo$numbermonths?>">
<?php
}

function monthly_horoscopes_apikey_field()
{
    $options = get_option('horoscopes_options');
    $apikey = (isset($options['apikey_template'])) ? $options['apikey_template'] : '';
    $apikey = esc_textarea($apikey); //sanitise output
    /*
        If APikey is not set make it the generated API
    */
    if (!$apikey)
       $apikey = get_option('generatedapikey');
?>
    <input readonly="readonly" id="apikey_template" name="horoscopes_options[apikey_template]" value="<?php echo$apikey?>">
<?php
}

function monthly_horoscopes_getexternaldata_field()
{
    $options = get_option('horoscopes_options');
    $getexternaldata = (isset($options['getexternaldata_template'])) ? $options['getexternaldata_template'] : '';
?>
    <input <?php if ($getexternaldata == 'Y') printf (" checked "); ?> id="getexternaldata_template" name="horoscopes_options[getexternaldata_template]" type="checkbox" value="Y">
<?php
}

function monthly_horoscopes_displaycopyright_field()
{
    $options = get_option('horoscopes_options');
    $displaycopyright = (isset($options['displaycopyright_template'])) ? $options['displaycopyright_template'] : '';
?>
    <input <?php if ($displaycopyright == 'Y') printf (" checked "); ?> id="displaycopyright_template" name="horoscopes_options[displaycopyright_template]" type="checkbox" value="Y">
<?php
}

function monthly_horoscopes()
{
    $options = get_option('horoscopes_options');
    $websitename = (isset($options['websitename_template'])) ? $options['websitename_template'] : '';
    $contactemail = (isset($options['contactemail_template'])) ? $options['contactemail_template'] : '';
    $numbermonths = (isset($options['numbermonths_template'])) ? $options['numbermonths_template'] : get_option('initialnumbermonths');
    $apikey = (isset($options['apikey_template'])) ? $options['apikey_template'] : get_option('generatedapikey');
    $options = get_option('horoscopes_options');
    $getexternaldata = (isset($options['getexternaldata_template'])) ? $options['getexternaldata_template'] : '';
    $displaycopyright = (isset($options['displaycopyright_template'])) ? $options['displaycopyright_template'] : '';
/*
    if (!$websitename || !$contactemail)
    {
        printf ("<p>Please setup both the Website Name & Contact Email</p>");
        printf ("You can do this via the Plugins/Horoscopes Settings Link</p>");
        return;
    }
*/

    if ($getexternaldata != 'Y')
    {
        printf ("<p>Please tick the Get External Data box in the settings to receive Horoscope Data</p>");
        return;
    }
/*
    $filename = './debughoroscopes.txt';
    if (!$handle = fopen($filename, 'w'))
    {
        print "Cannot open file ($filename)";
        exit;
    }
*/

    $enginepath = "https://www.myastrologycharts.com/";
    $enginename = "horoscopesservice.php";
    $params = sprintf('<astroRequest responseFormat="xml">
        <reports numbermonths="%d">
        </reports>
        <auth siteId="iPhone" apiKey="%s"/>
      </astroRequest>',$numbermonths,$apikey);

    $url = sprintf ("%s%s?requestxml=%s",$enginepath,$enginename,urlencode($params));

    $body = wp_remote_retrieve_body(wp_remote_get($url));
    $returnxmlstring = simplexml_load_string($body);
    $Interpretations = $returnxmlstring->Interpretations;

     $copywrite = array
     (
       array("http://www.seeingwithstars.net", "SeeingWithStars.net"),
       array("https://www.myastrologycharts.com", "MyAstrologyCharts.com"),
       array("https://www.zodiacsigns.biz", "ZodiacSigns.biz"),
       array("https://www.myastrologycharts.com", "MyAstrologyCharts.com"),
       array("https://www.myastrologycharts.com", "MyAstrologyCharts.com"),
       array("https://www.thebirthchart.com", "TheBirthChart.com"),
       array("https://www.thebirthchart.com", "TheBirthChart.com"),
       array("https://www.thebirthchart.com", "TheBirthChart.com"),
       array("https://www.starsign-compatibility.com", "StarSign-Compatibility.com"),
       array("https://www.zodiacsigns.biz", "ZodiacSigns.biz"),
       array("https://birthchartcompatibility.com/aquarius-zodiac-sign", "BirthChartCompatibility.com"), 
       array("https://www.myastrologycharts.com", "MyAstrologyCharts.com"),
    );
   

    foreach ($Interpretations->Interpretation as $Interpretation)
    {
       /* fprintf ($handle,"Processing %s %s\n", $Interpretation["month"],$Interpretation["year"]) */
       
       /* $retstring = sprintf("%s<p style=\"font-size:120%%; font-weight:bold\">Monthly Horoscopes %s %s</p>",$retstring,$Interpretation["month"],$Interpretation["year"]); */

        $retstring = sprintf("%s<p style=\"font-size:120%%; font-weight:bold\"><a style=\"color:black; text-decoration:none\" href=\"https://astrologyyard.com/astrology-plugins-wordpress.php\" target=\"_blank\">Monthly Horoscopes</a> %s %s</p>",$retstring,$Interpretation["month"],$Interpretation["year"]);  

        foreach ($Interpretation->Intro as $Intro)
        {
            $retstring = sprintf("%s<p style=\"font-weight:bold\">Introduction</p>",$retstring);
            $Intro->content = str_ireplace("<![CDATA[","",$Intro->content );
            $Intro->content = str_ireplace("]]>","",$Intro->content );
            $retstring = sprintf("%s<p style=\"text-align:justify\">%s</p",$retstring,$Intro->content);
        }
 
        $counter = 0;
  
        foreach ($Interpretation->SunSigns->Sign as $Sign)
        {
           $retstring = sprintf("%s<p style=\"font-weight:bold\">",$retstring); 
         
           $retstring = sprintf("%s<a style=\"color:black; text-decoration:none\" href=%s>", $retstring, $copywrite[$counter][0]);
         
           $retstring = sprintf("%s%s",$retstring,$Sign["name"]);
           
           $retstring = sprintf("%s</a>",$retstring);

           $retstring = sprintf("%s (%s)</p>",$retstring,$Sign["dates"]); 
            
           $Sign->content = str_ireplace("<![CDATA[","",$Sign->content );
           $Sign->content = str_ireplace("]]>","",$Sign->content );
            
           $retstring = sprintf("%s<p style=\"text-align:justify\">%s</p>",$retstring,$Sign->content);
           $counter = $counter + 1;
        }          
    }

    $returnxmlstring->Footer->content = str_ireplace("<![CDATA[","",$returnxmlstring->Footer->content);
    $returnxmlstring->Footer->content = str_ireplace("]]>","",$returnxmlstring->Footer->content);
    if ($returnxmlstring->Footer->content != '')
        $retstring = sprintf("%s%s",$retstring,$returnxmlstring->Footer->content);

    if ($displaycopyright == 'Y') 
        $retstring = sprintf("%s<span style=\"color:black\">&copy %s 
            <a style=\"color:black; text-decoration:none\" href=%s>%s</a> &amp;
            <a style=\"color:black; text-decoration:none\" href=%s>%s</a>",
            $retstring,date("Y"),$copywrite[0][0], $copywrite[0][1],
                                 $copywrite[1][0], $copywrite[1][1]);

    return ($retstring);
   
}
?>