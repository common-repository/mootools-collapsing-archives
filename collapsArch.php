<?php
/*
Plugin Name: Moo Collapsing Archives
Plugin URI: http://www.3dolab.net/en/moo-collapsing-categories-and-archives
Description: Allows users to expand and collapse archive links with MooTools. <a href='options-general.php?page=collapsArch.php'>Options and Settings</a> 
Author: 3dolab
Version: 0.5.8
Author URI: http://www.3dolab.net

This work is largely based on the Collapsing Archives plugin by Robert Felty
(http://robfelty.com), which was also distributed under the GPLv2.
His website has lots of informations.

This file is part of Moo Collapsing Archives

    Moo Collapsing Archives is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    Moo Collapsing Archives is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Collapsing Archives; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
$url = get_settings('siteurl');
global $collapsArchVersion;
$collapsArchVersion = '0.5.8';

// LOCALIZATION
function collapsArch_load_domain() {
	load_plugin_textdomain( 'moo-collapsing-arc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('init', 'collapsArch_load_domain'); 


/****************/
if (!is_admin()) {
$MTversion = get_option('MTversion');
  if ($MTversion == '12'){
  wp_register_script('moocore', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/js/mootools-1.2.5-core-yc.js', false, '1.2.5');
  wp_register_script('moomore', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/js/mootools-1.2.5.1-more-yc.js', false, '1.2.5');
  wp_enqueue_script('moocore');
  wp_enqueue_script('moomore');
  wp_enqueue_script('collapsFunctions', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/js/collapsFunctions.js', array('moocore','moomore'), '1.2.5');
  } elseif ($MTversion == '13'){
  wp_register_script('moocore', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/js/mootools-core-1.3.2-full-nocompat-yc.js', false, '1.3.2');
  wp_register_script('moomore', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/js/mootools-more-1.3.2.1-yc.js', false, '1.3.2');
  wp_enqueue_script('moocore');
  wp_enqueue_script('moomore');
  wp_enqueue_script('collapsFunctions', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/js/collapsFunctions-1.3.js', array('moocore','moomore'), '1.3.2');
  }
  add_action( 'wp_head', array('collapsArch','get_head'));
} else {
  // call upgrade function if current version is lower than actual version
  $dbversion = get_option('collapsArchVersion');
  if (!$dbversion || $collapsArchVersion != $dbversion)
    collapsArch::init();
}
add_action('admin_menu', array('collapsArch','setup'));
register_activation_hook(__FILE__, array('collapsArch','init'));

class collapsArch {

	function init() {
    global $collapsArchVersion;
    include('collapsArchStyles.php');
    $dbversion = get_option('collapsArchVersion');
    if ($collapsArchVersion != $dbversion && $selected!='custom') {
      $style = $defaultStyles[$selected];
      update_option( 'collapsArchStyle', $style);
      update_option( 'collapsArchVersion', $collapsArchVersion);
    }
    $defaultStyles=compact('selected','default','block','noArrows','custom');
    if( function_exists('add_option') ) {
      update_option( 'collapsArchOrigStyle', $style);
      update_option( 'collapsArchDefaultStyles', $defaultStyles);
    }
    if (!get_option('collapsArchStyle')) {
			add_option( 'collapsArchStyle', $style);
		}
    if (!get_option('collapsArchSidebarId')) {
      add_option( 'collapsArchSidebarId', 'sidebar');
    }
    if (!get_option('collapsArchVersion')) {
      add_option( 'collapsArchVersion', $collapsArchVersion);
		}
    if (!get_option('MTversion')) {
      add_option( 'MTversion', $MTversion);
		}
	}

	function setup() {
		if( function_exists('add_options_page') && current_user_can('manage_options') ) {
			add_options_page(__('Moo Collapsing Archives', 'moo-collapsing-arc'),__('Moo Collapsing Archives', 'moo-collapsing-arc'),1,basename(__FILE__),array('collapsArch','ui'));
		}
	}

	function ui() {
		include_once( 'collapsArchUI.php' );
	}



	function get_head() {
    $style=stripslashes(get_option('collapsArchStyle'));
    echo "<style type='text/css'>
    $style
    </style>\n
    <!--[if lte IE 8]>
      <style type='text/css'>
	  #".get_option('collapsCatSidebarId')." ul li, #".get_option('collapsCatSidebarId')." ul.collapsing.archives.list li, {
		text-indent:0;
		padding:0;
		margin:0;
	  } 
      </style>
    <![endif]-->";
	}
function phpArrayToJS($array, $name, $options) {
    /* generates javscript code to create an array from a php array */
    print "try { $name" . 
        "['catTest'] = 'test'; } catch (err) { $name = new Object(); }\n";
    if (!$options['expandYears'] && $options['expandMonths']) {
      $lastYear = -1;
      foreach ($array as $key => $value){
        $parts = explode('-', $key);
        $label = $parts[0];
        $year = $parts[1];
        $moreparts = explode(':', $key);
        $widget = $moreparts[1];
        if ($year != $lastYear) {
          if ($lastYear>0)
            print  "';\n";
          print $name . "['$label-$year:$widget'] = '" . 
              addslashes(str_replace("\n", '', $value));

          $lastYear=$year;
        } else {
          print addslashes(str_replace("\n", '', $value));
        }
      }
      print  "';\n";
    } else {
      foreach ($array as $key => $value){
        print $name . "['$key'] = '" . 
            addslashes(str_replace("\n", '', $value)) . "';\n";
      }
    }
  }
}
include_once( 'collapsArchList.php' );

function collapsArch($args='') {
  global $collapsArchItems, $wpdb, $month;
  include('defaults.php');
  $options=wp_parse_args($args, $defaults);
  if (!is_admin()) {
    if (!$options['number'] || $options['number']=='') 
      $options['number']=1;
    $archives = list_archives($options);
    $archives .= "<li style='display:none'><script type=\"text/javascript\">\n";
    $archives .= "// <![CDATA[\n";
      $archives .= '/* These variables are part of the Moo Collapsing Archives Plugin
   * version: 0.5.5
   * Copyright 2010 3DO lab (3dolab.net)
           */' ."\n";
extract($options);
$post_attrs = "post_date != '0000-00-00 00:00:00' AND post_status = 'publish'";
if ($expand==1) {
    $expandSym='+';
    $collapseSym='—';
  } elseif ($expand==2) {
    $expandSym='[+]';
    $collapseSym='[—]';
  } elseif ($expand==3) {
    $expandSym="<img src='". $url .
         "/wp-content/plugins/mootools-collapsing-archives/" . 
         "img/expand.gif' alt='expand' />";
    $collapseSym="<img src='". $url .
         "/wp-content/plugins/mootools-collapsing-archives/" . 
         "img/collapse.gif' alt='collapse' />";
  } elseif ($expand==4) {
    $expandSym=htmlentities($customExpand);
    $collapseSym=htmlentities($customCollapse);
  } else {
    $expandSym='&#9658;';
    $collapseSym='&#9660;';
  }
  if ($expand==3) {
    $expandSymJS='expandImg';
    $collapseSymJS='collapseImg';
  } else {
    $expandSymJS=$expandSym;
    $collapseSymJS=$collapseSym;
  }
  if( $expandCurrentYear ){
	$expandCookieYear = "if (!Cookie.read('collapsArch-".date('Y').":".$number."')){Cookie.write('collapsArch-".date('Y').":".$number."', 'inline');}";
	$archives .= $expandCookieYear;
      }
  if( $expandCurrentMonth ){
	    $expandCookieMonth = "if (!Cookie.read('collapsArch-".date('Y')."-".date('n').":".$number."')){Cookie.write('collapsArch-".date('Y')."-".date('n').":".$number."', 'inline');}";
	    $archives .= $expandCookieMonth;
      }
    $expandText= __('click to expand', 'moo-collapsing-arc');
    $collapseText= __('click to collapse', 'moo-collapsing-arc');
    $archives .= "var expand=\"$expandSymJS\";";
    $archives .= "var collapse=\"$collapseSymJS\";";
    $archives .= "var animate=\"$animate\";";
    $archives .= "var expandSym=\"$expandSym\";\n";
    $archives .= "var collapseSym=\"$collapseSym\";\n";
    $archives .= "var expandText=\"$expandText\";\n";
    $archives .= "var collapseText=\"$collapseText\";\n";
    $archives .= "var useCookies=\"$useCookies\";";
    print $archives;
    // now we create an array indexed by the id of the ul for posts
    collapsArch::phpArrayToJS($collapsArchItems, 'collapsItems', $options);
    print "// ]]>\n</script></li>\n";
  }
}
$version = get_bloginfo('version');
if (preg_match('/^(2\.[8-9]|[3-9]\..*)/', $version))
  include('collapsArchWidget.php');
?>