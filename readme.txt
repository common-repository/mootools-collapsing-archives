=== Moo Collapsing Archives ===
Contributors: 3dolab
Homepage: http://www.3dolab.net/en/mootools-collapsing-categories-and-archives
Tags: archives, sidebar, widget, navigation, menu, posts, collapsing, collapsible, mootools
Requires at least: 2.8
Tested up to: 4.4.2
Stable tag: 0.5.8

This plugin uses Javascript based on MooTools framework to dynamically expand or collapse the yearly/monthly post archive listing.

== Description ==

This is a relatively simple plugin that uses Javascript based on MooTools framework to
make the Archive links in the sidebar collapsable by year and/or month. Fork of Rob Felty's Collapsing Archives.

Multiple languages content is now fully supported through compatibility with qTranslate and WPML Multilingual CMS

[Plugin Homepage: http://www.3dolab.net/en/mootools-collapsing-categories-and-archives](http://www.3dolab.net/en/mootools-collapsing-categories-and-archives "MooTools Collapsing Categories & Archives @ 3dolab")

[Running Demo](http://www.3dolab.net/en/ "MooTools Collapsing Archives Demo")

*[banner image by Karora](https://commons.wikimedia.org/wiki/File:Tree_fern_frond_at_Akatarawa.jpg)*
*[icon by Jdforrester](https://commons.wikimedia.org/wiki/File:VisualEditor_-_Icon_-_Collapse.svg)*

= What's new? =

See the CHANGELOG for more information

== Installation ==

IMPORTANT!
Please deactivate before upgrading, then re-activate the plugin. 

= MANUAL INSTALLATION =

Unpack the contents to wp-content/plugins/ so that the files are in a
collapsing-archives directory. Now enable the plugin. To use the plugin,
change the following here appropriate (most likely sidebar.php):

Change From:

    <ul>
     `<?php wp_get_archives(); ?>`
    </ul>

To something of the following:
`
    <?php
     if( function_exists('collapsArch') ) {
      collapsArch();
     } else {
      echo "<ul>\n";
      wp_get_archives();
      echo "</ul>\n";
     }
    ?>
`
You can specify options for collapsArch. See options section.


= WIDGET INSTALLATION =

For those who have widget capabilities, (default in Wordpress 2.3+), installation is easier. 

Unzip contents to wp-content/plugins/ so that the files are in a
mootools-collapsing-archives/ directory.  You must enable the plugin, 
then simply go the Presentation > Widgets section and add the Widget.

== Frequently Asked Questions ==

=  How do I change the style of the collapsing archives lists? =

The collapsing archives plugin uses several IDs and classes which can be
styled with CSS. These can be changed from the settings page. You may have to
rename some of the id statements. For example, if your sidebar is called
"myawesomesidebar", you would rewrite the line 

  #sidebar li.collapsArch {list-style-type:none}
  to
  #myawesomesidebar li.collapsArch {list-style-type:none}

If you are using the plugin manually (i.e. inserting code into your theme),
you may want to replace #sidebar with #collapsArchList

= There seems to be a newline between the collapsing/expanding symbol and the category name. How do I fix this? =

If your theme has some css that says something like
  #sidebar li a {display:block}
that is the problem. 
You probably want to add a float:left to the .sym class

=  How do I include/exclude pages, or posts belonging to certain categories? =

Check the corrisponding boxes in the widget settings.
If you are using WPML, please enter each category multiple times as the ID/name
of the translations is required alongside the default language.
See OPTIONS AND CONFIGURATIONS for manual triggering.


== Other notes ==


= Options and configuration =

`$defaults=array(
  'noTitle' => '',
  'inExcludeCat' => 'exclude',
  'inExcludeCats' => '',
  'inExcludeYear' => 'exclude',
  'inExcludeYears' => '',
  'sort' => 'DESC',
  'showPages' => false, 
  'linkToArch' => true,
  'showYearCount' => true,
  'expandCurrentYear' => true,
  'expandMonths' => true,
  'expandYears' => true,
  'expandCurrentMonth' => true,
  'showMonthCount' => true,
  'showPostTitle' => true,
  'expand' => '0',
  'showPostDate' => false,
  'postDateFormat' => 'm/d',
  'animate' => 0,
  'postTitleLength' => '',
  'debug' => '0',
  );
`

* noTitle
    * If your posts don't have title, specify a string to show in place of the
      title
* inExcludeCat
    * Whether to include or exclude certain categories 
        * 'exclude' (default) 
        * 'include'
* inExcludeCats
    * The categories which should be included or excluded
* inExcludeYear
    * Whether to include or exclude certain years 
        * 'exclude' (default) 
        * 'include'
* inExcludeYears
    * The years which should be included or excluded
* showPages
    * Whether or not to include pages as well as posts. Default if false
* showYearCount
    *  When true, the number of posts in the year will be shown in parentheses 
* showMonthCount
    *  When true, the number of posts in the month will be shown in parentheses 
* linkToArch
    * 1 (true), clicking on a the month or year will link to the archive (default)
    * 0 (false), clicking on a month or year expands and collapses 
* sort
    * Whether posts should be sorted in chronological  or reverse
      chronological order. Possible values:
        * 'DESC' reverse chronological order (default)
        * 'ASC' chronological order
* expand
    * The symbols to be used to mark expanding and collapsing. Possible values:
        * '0' Triangles (default)
        * '1' + -
        * '2' [+] [-]
        * '3' images (you can upload your own if you wish)
        * '4' custom symbols
* customExpand
    * If you have selected '4' for the expand option, this character will be
      used to mark expandable link categories
* customCollapse
    * If you have selected '4' for the expand option, this character will be
      used to mark collapsible link categories
 
* expandYears
    * 1 (true): Years collapse and expand to show months (default)
    * 0 (false): Only links to yearly archives are shown
* expandMonths
    * 1 (true): Months collapse and expand to show posts (default)
    * 0 (false): Only links to yearly and monthly archives are shown
* expandCurrentMonth
    * When true, the current month will be expanded by default
* expandCurrentYear
    * When true, the current year will be expanded by default
* showPostTitle
    * 1 (true): The title of each post is shown (default)
* showPostDate
    * 1 (true): Show the date of each post 
* postDateFormat
    * The format in which the date should be shown (default: 'm/d')
* postTitleLength
    * Truncate post titles to this number of characters (default: 0 = don't
      truncate)
* animate
    * When set to true, collapsing and expanding will be animated
* debug
    * When set to true, extra debugging information will be displayed in the
      underlying code of your page (but not visible from the browser). Use
      this option if you are having problems

= Examples =

`collapsArch('animate=1&sort=ASC&expand=3,inExcludeCats=general,uncategorized')`
This will produce a list with:
* animation on
* shown in chronological order
* using images to mark collapsing and expanding
* exclude posts from  the categories general and uncategorized


= Fallback =

This plugin relies on Javascript, but does degrade
gracefully if it is not present/enabled to show all of the
archive links as usual.


== Screenshots ==

1. the widget in action
2. the Admin Widget Settings page


== CHANGELOG ==

= 0.5.8 (2016.02.06) =
    * WP v.4 compatibility
	
= 0.5.7 (2013.10.22) =
    * Added Serbo-Croatian translation

= 0.5.6 (2011.07.12) =
    * Switch between MooTools ver. 1.2.5 and 1.3.2
    * CSS (ultimate?) fix for MSIE browsers

= 0.5.5 (2011.06.21) =
    * Added compatibility for WPML Multilingual CMS (tested with ver 2.3.0)
    * Fixed localization in admin screens
    * Added full Italian translation

= 0.5.4 (2011.06.06) =
    * Fixed plugin textdomain for translations
    * New JavaScript for compatibility with the Moo Collapsing Categories plugin

= 0.5.3 (2011.01.03) =
    * Bugfix: close Year list when there are less than two months

= 0.5.2 (2010.12.07) =
    * DEFINITIVE fix for Unicode Triangle Entities not rendered on MSIE

= 0.5.1 (2010.11.01) =
    * Bugfix: CSS widget sidebar reference and preview images

= 0.5 (2010.10.30) =
    * Bugfix: HTML character entities not rendered on MSIE

= 0.4.1 (2010.10.21) =
    * Bugfix: register script array

= 0.4 (2010.10.20) =
    * Bugfix: removed redundant closing 'li' breaking layout and validation
    * Bugfix: restored random missing entries on last month

= 0.3 (2010.09.25) =
    * Full compatibility with Wordpress 3.0.1
    * Updated according to Rob Felty's Collapsing Archives v.1.3.1
    * Bugfix: title attribute of expand / collapse linksnks

= 0.2 (2010.06.28) =
    * Relies on MooTools 1.2.4

= 0.1 (2010.06.16) =
    * Initial release
    * Based on Rob Felty's Collapsing Archives v.1.2.1
    * Relies on MooTools 1.1.1