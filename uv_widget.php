<?php
/*
Copyright: 2011 MediaSlurp
License: Apache 2.0

Plugin Name: UserVoice Idea List Widget

Plugin URI: http://mediaslurp.com/download/uservoice-idea-list-widget/

Description: A widget that displays the most popular ideas within a specific UserVoice forum. To configure, edit the widget via Appearance>>Widgets>>UserVoice Idea List Widget.

Version: 1.6

Author: Maintained by TJ Downes of MediaSlurp. Rob Knight. Originally produced by Shane & Peter, Inc.
Author URI: http://mediaslurp.com/download/uservoice-idea-list-widget/

Maintained by: MediaSlurp development team - TJ Downes, Vicky Ryder and Ben Farrell
Maintainer URI: http://mediaslurp.com/download/uservoice-idea-list-widget/

See the readme.txt for install instructions if you are doing an manual install.

History:
1.6
	* ADDED: There is now an Order By feature that allows you to specify the order of feedback. 
	  All of the available order by arguments are used, so if you need other order by paramters and dont see 
	  it in the list, ask UserVoice to add it to the API!

1.5
	* CHANGED: IMPORTANT!!!! Migrated to the "new" plugin/widget API. This means that this plugin may not work 
	  on some older installations of WordPress. This allows the widget to be put into multiple sidebars. 
	  Backup your existing installation BEFORE upgrading. Please remember to report any errors, as this is an 
	  almost complete rewrite of the widget.

1.4
	* You can now turn off the "powered by" logo by using the "Hide Credits" option in the widget options
	* You can now add text to the footer of the widget using the "Footer Text" option in the widget options. You are responsible for styling. Override the default id, uv_footer_text to style it yourself.
	* Updated installer doc for info on API key
	* Code cleanup
	* CHANGED: Cleaner "powered by" logo, in PNG format. Thanks UV!
	* Fixed break in widget admin on account name

1.3
	* Updated for the most recent UV API (version 1). This should have gone into 1.2 but there were bugs that we weren't certain we would have fixed on time
	* Now requires API KEY!!!!
	* account name has been updated and you should only require the account name, not the full uservoice subdomain (mediaslurp instead of mediaslurp.uservoice.com)

1.2
	* Updated widget to fix URL, wehich was broken and did not allow plugin to function
	* reformatted code for readability
	* updated some text elements for usability, in management console
	* updated classes on text inputs in widget editor so they would span entire width of the widget editor
*/

class UserVoiceIdeaListWidget extends WP_Widget
{
    var $id = "uservoice-suggestions";
	var $name = "UserVoice";
	var $classname = "uservoice_suggestions_widget";
	var $optionsname = "uservoice_suggestions_widget_option";
	var $description = "UserVoice suggestions widget";
	
	/** constructor */
	function UserVoiceIdeaListWidget()
	{
		parent::WP_Widget(false, $name = 'UserVoice Idea List Widget');	
	}
	
    /** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$account = apply_filters('widget_account', $instance['account']);
		$forum_id = apply_filters('widget_forum_id', $instance['forum_id']);
		$order_by = apply_filters('widget_order_by', $instance['order_by']);
		$count = apply_filters('widget_count', $instance['count']);
		$api_key = apply_filters('widget_api_key', $instance['api_key']);
		$hide_credits = apply_filters('widget_hide_credits', $instance['hide_credits']);
		$footer_text = apply_filters('widget_footer_text', $instance['footer_text']);
		
        echo $before_widget;        
        echo $before_title . $title . $after_title;
		
        //Run function to return HTML with suggestions	
        echo $this->uservoice_get_suggestions($account, $forum_id, $order_by, $count, $api_key, $hide_credits, $footer_text);   
        echo $after_widget;
    }

    // Widget Panel
    /** @see WP_Widget::form */
    function form($instance) 
	{
		$title = esc_attr($instance['title']);
		$account = esc_attr($instance['account']);
		$forum_id = esc_attr($instance['forum_id']);
		$order_by = esc_attr($instance['order_by']);
		$count = esc_attr($instance['count']);
		$api_key = esc_attr($instance['api_key']);
		$hide_credits = esc_attr($instance['hide_credits']);
		$footer_text = esc_attr($instance['footer_text']);
		
		$hide_credits_options = '<label for="'.$this->get_field_name('hide_credits').'">Hide Credits: <br /><input type="radio" value="true" name="'.$this->get_field_name('hide_credits').'"';
		
		if($hide_credits == "true") 
		{
			$hide_credits_options .= ' checked="checked" />Yes';
		}
		else 
		{
			$hide_credits_options .= ' />Yes';
		}
		
		$hide_credits_options .= ' <input type="radio" value="false" name="'.$this->get_field_name('hide_credits').'"';
		
		if($hide_credits != "true") 
		{
			$hide_credits_options .= ' checked="checked" />No';
		}
		else 
		{
			$hide_credits_options .= ' />No';
		}
		
		$hide_credits_options .= '</label><br />';

		// Display the widget control panel
		echo '<label for="'.$this->get_field_name('title').'">Widget Title:<br /><input type="text" value="'.$title.'" name="'.$this->get_field_name('title').'" class="widefat" /></label><br />';

		echo '<label for="'.$this->get_field_name('account').'">Account Name:<br /><input type="text" value="'.$account.'" name="'.$this->get_field_name('account').'" class="widefat" /></label><br />';

		echo '<label for="'.$this->get_field_name('forum_id').'">Forum ID: <br /><input type="text" value="'.$forum_id.'" name="'.$this->get_field_name('forum_id').'" class="widefat" /></label><br />';
		
		echo '<label for="'.$this->get_field_name('order_by').'">Order By: <br /><select name="'.$this->get_field_name('order_by').'" class="widefat">';
	
		if($order_by == "votes")
		{
			echo '<option value="votes" selected="selected">votes</option>';
		}
		else
		{
			echo '<option value="votes">votes</option>';
		}
		
		if($order_by == "hot")
		{
			echo '<option value="hot" selected="selected">hot</option>';
		}
		else
		{
			echo '<option value="hot">hot</option>';
		}
		
		if($order_by == "oldest")
		{
			echo '<option value="oldest" selected="selected">oldest</option>';
		}
		else
		{
			echo '<option value="oldest">oldest</option>';
		}
		
		if($order_by == "newest")
		{
			echo '<option value="newest" selected="selected">newest</option>';
		}
		else
		{
			echo '<option value="newest">newest</option>';
		}
		
		echo '</select></label><br />';
		
		echo '<label for="'.$this->get_field_name('count').'">Count: <br /><input type="text" value="'.$count.'" name="'.$this->get_field_name('count').'" /></label><br />';
		
		echo '<label for="'.$this->get_field_name('api_key').'">API Key: <br /><input type="text" value="'.$api_key.'" name="'.$this->get_field_name('api_key').'" class="widefat" /></label>';
		
		echo $hide_credits_options;
		
		echo '<label for="'.$this->get_field_name('footer_text').'">Footer Text (optional): <br /><textarea name="'.$this->get_field_name('footer_text').'" class="widefat">'.$footer_text.'</textarea></label>';

		echo '<input type="hidden" id="submit" name="Save" value="1" class="widefat" /></p>';
	} 
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['account'] = strip_tags($new_instance['account']);
		$instance['forum_id'] = strip_tags($new_instance['forum_id']);
		$instance['order_by'] = strip_tags($new_instance['order_by']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['api_key'] = strip_tags($new_instance['api_key']);
		$instance['hide_credits'] = strip_tags($new_instance['hide_credits']);
		$instance['footer_text'] = strip_tags($new_instance['footer_text']);
        
		return $instance;
    }
		
    /**
     *  uservoice_get_suggestions
     *  Loads the XML from the UserVoice API and puts it into <ul> for display in the widget
     *  @return HTML for widget display
     *  @param $account = The UserVoice username
     *  @param $forum_id = The numeric representation of the forum
     *  @param $count = The number of suggestions to display
     *  @param $api_key = UserVoice API key. Read installer instructions for more info.
     *  @param $footer_text = text to be shown below the widget.
     **/    
    function uservoice_get_suggestions($account, $forum_id, $order_by, $count, $api_key, $hide_credits, $footer_text) 
	{
        $base_url = "http://".$account.".uservoice.com/api/v1/forums/".$forum_id."/suggestions.xml?per_page=".$count."&sort=".$order_by."&client=".$api_key;
        
        // Load the XML with a cURL request
        $xml = $this->load_xml($base_url);
        
        $html = '<div id="uv_box">';
        $suggestions = $xml->suggestions[0]->suggestion;
        $suggestionCount = count($suggestions);
        
        if($suggestionCount)
        {
	        // init the list, then populate with the suggestions
	        $html .= '<ul id="uv_suggestion_list">';
	        
	        for ($i=0; $i < $suggestionCount; $i++) 
			{ 
	            // Show 'comment' or 'comments' depending on the number of comments
	            if ($suggestions[$i]->comments_count == 1) 
				{ 
					$comment_text = "&nbsp;comment"; 
				}
	            else 
				{
					$comment_text = "&nbsp;comments";
				}
	
	            $html .= '<li class="uv_suggestion">';
	
	            $html .= '<span class="uv_votes"><span class="uv_num_votes">'.$suggestions[$i]->vote_count.'</span> votes</span> ';
	
	            $html .= '<a href="'.$suggestions[$i]->url.'">'.$suggestions[$i]->title.'</a> ';
	
	            // Show number of comments if there are any
	
	            if ($suggestions[$i]->comments_count > 0) 
				{
	                $html .= '<br /><a class="uv_comments" href="'.$suggestions[$i]->url.'">'.$suggestions[$i]->comments_count.$comment_text.'</a>';
	            }
				
	            $html .= '</li>';
	        }

       		$html .= '</ul>';
        }
        else
        {
        	$html .= 'No current feedback<br />';
        }
        
        $html .= '<div id="uv_footer_text">'.$footer_text.'</div>';
        
        if($hide_credits == "false")
        {
        	$html .= '<a id="uv_credit" href="http://uservoice.com">Powered By UserVoice.</a>';
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * load_xml function
     * @return XML string of UserVoice suggestions
     * @param $url Where to get the XML from 
     **/
    function load_xml($url) 
	{
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
		
        $data = simplexml_load_string(curl_exec($ch));
        curl_close($ch);
        return $data;
    }
} 
// end Class
/**
*  add_stylesheet function
*  Adds a new stylesheet for the widget
**/
function add_stylesheet() 
{
	$cssURL = WP_PLUGIN_URL . '/uservoice-idea-list-widget/uv_styles.css';
    $cssFile = WP_PLUGIN_DIR . '/uservoice-idea-list-widget/uv_styles.css';

    if (file_exists($cssFile))
    {
    	wp_register_style('myStyleSheets', $cssURL);
    	wp_enqueue_style( 'myStyleSheets');
    }
}
add_action('wp_print_styles', 'add_stylesheet');
add_action('widgets_init', create_function('', 'return register_widget("UserVoiceIdeaListWidget");'));