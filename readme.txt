=== UserVoice Idea List Widget ===
Contributers: TJ Downes from MediaSlurp, Rob Knight, Produced by Shane & Peter, Inc.
Tags: uservoice, user voice, forum, feedback, widget, community, vote, support, comments, ideas, customer feedback
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 1.6

A widget that displays the most popular ideas within a specific UserVoice forum. 
You can configure the widget to show the number of ideas you want to display. 
You can modify the style of the widget easily with the included CSS.
Orginally developed by Shane and Peter, Inc. Now maintained by the MediaSlurp team at http://www.mediaslurp.com.

== Description ==
IMPORTANT: PLEASE READ CHANGELOG PRIOR TO UPGRADING. THERE ARE CHANGES REQUIRED. CHANGES IN 1.5 MAY BREAK YOUR INSTALLATION!

The UserVoice IdeaList Widget displays the most popular ideas within a specific UserVoice forum. You can configure 
the widget to show the number of ideas you want to display and the order you want them displayed in. The style of 
the widget is easily modified by overriding the included CSS.

Versions newer than 1.2 now use the new UserVoice API. This will require a UserVoice API key! As of version 1.5, the plugin has been almost entirely rewritten using
the newer API for Wordpress plugins and widgets. This means that the plugin may not work correctly in older versions of 
WordPress. If you experience issues, please report them as bugs so that we may fix them in a timely manner!

Orginally developed by Shane and Peter, Inc. Now maintained by the MediaSlurp team at http://www.mediaslurp.com.

== Installation ==

**Prerequisites**
You will need an API key for this to work, with the new API changes. To do so, visit your UserVoice Admin Console and 
click on Apps & Plugins in the left-hand menu. Choose the API tab and click the "Register new API client" button. 
Follow the wizard and a new API key will be generated. Copy and paste the API key into the widget settings after 
you have installed UserVoice Idea List Widget. 

**Install**
1. Unzip the "uservoice.zip" file. 
2. Upload the the "uservoice" folder (not just the files in it!) to your "wp-contents/plugins" folder. If you're using FTP, use 'binary' mode.

**Activate**

1. In your WordPress administration, go to the Plugins page
2. Activate the UserVoice plugin.
3. Go to the Design > Widget page and place the widget in a sidebar
4. Fill in the key information including your uservoice account and the specific forum you want to pull suggestions from

If you find any bugs or have any ideas, please visit http://wordpresswidget.uservoice.com/pages/19484-general/filter/top .

== Changelog ==

=1.6=
* ADDED: There is now an Order By feature that allows you to specify the order of feedback. 
All of the available order by arguments are used, so if you need other order by paramters and dont see 
it in the list, ask UserVoice to add it to the API!
	
= 1.5 =
* CHANGED: IMPORTANT!!!! Migrated to the "new" plugin/widget API. This means that 
this plugin may not work on some older installations of WordPress. This allows 
the widget to be put into multiple sidebars. Backup your existing installation 
BEFORE upgrading. Please remember to report any errors, as this is an almost complete 
rewrite of the widget.

= 1.4 =
* ADDED:	You can now turn off the "powered by" logo by using the "Hide Credits" option in the widget options
* ADDED:	You can now add text to the footer of the widget using the "Footer Text" option in the widget options. You are responsible for styling. Override the default id, uv_footer_text to style it yourself.
* CHANGED: 	Updated installer doc for info on API key
* CHANGED: 	Code cleanup
* CHANGED: 	Cleaner "powered by" logo, in PNG format. Thanks UV!
* FIXED: 	Fixed break in widget admin on account name
	
= 1.3 =
* CHANGED:				Updated for the most recent UV API (version 1). This should have gone into 1.2 but there were bugs that we weren't certain we would have fixed on time
* CHANGED:IMPORTANT: 	Now requires API KEY!!!!
* CHANGED:IMPORTANT: 	Account name has been updated and you only require the account name, not the full uservoice subdomain (mediaslurp instead of mediaslurp.uservoice.com)

= 1.2 =
* FIXED: 	URLs fixed so that plugin now works correctly with the UserVoice API
* CHANGED: 	reformatted code for readability
* CHANGED: 	updated some text elements for usability, in management console
* CHANGED: 	updated classes on text inputs in widget editor so they would span entire width of the widget editor

= 1.1 =
* "Powered by UserVoice" button
* FIXED: 	compatibility with IE 6,7,8
* CHANGED: 	all lowercase classes and ids

= 1.0 =
* WP 2.7.1 Compatibility
* Class encapsulation
* Display # of comments
* Allow widget to define the number of suggestions displayed

== Screenshots ==
1. Image administration screen
2. Widget on public site