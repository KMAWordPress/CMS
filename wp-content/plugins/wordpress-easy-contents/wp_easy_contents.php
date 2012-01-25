<?php
/*
Plugin Name: WordPress Easy Contents
Version: 1.1.3
Plugin URI: http://crispijnverkade.nl/blog/wordpress-easy-contents
Description: WordPress Easy Contents will create an table of contents for your WordPress Blog posts
Author: Crispijn Verkade
Author URI: http://crispijnverkade.nl/

Copyright (c) 2009
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

	INSTALL: 
	Just install the plugin in your blog and activate
*/ 

if(!defined('PHP_EOL')){
	define('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");
}

//add the stylesheet to the blog's header
function wpec_header(){
	global $wpdb, $post, $table_prefix, $mootools12;

	echo PHP_EOL.'<link rel="stylesheet" type="text/css" media="screen" href="'.get_settings('siteurl').'/wp-content/plugins/wordpress-easy-contents/wp_easy_contents.css" />'.PHP_EOL;
}

//break long headings
function wp_break_maxchar($val){
	global $post;
	
	$char = stripslashes(get_option('wpec_char'));
	
	if(strlen($val) > $char){
		return substr($val, 0, $char).'...'.PHP_EOL;
	}else{
		return $val;
	}
}

//nice urls
function nice_url($match){
	return strtolower(str_replace(' ', '-', $match));
}

//creates an places the table in the content
function wp_get_table($content){
	global $post;
	
	if(is_single() || is_page()){	
		if(!preg_match('|<!--contents-->|', $content)) {
			return $content;
		}else{
			//get the options
			$heading = stripslashes(get_option('wpec_title'));
			$element = stripslashes(get_option('wpec_element'));
			$char = stripslashes(get_option('wpec_char'));
			$top = stripslashes(get_option('wpec_top'));
			$add = explode("\r\n",get_option('wpec_add'));
			$float = stripslashes(get_option('wpec_float'));
			
			//scan the text for heading elements
			preg_match_all('#\<'.$element.'>(.+?)\</'.$element.'>#si', $content, $matches, PREG_SET_ORDER);
			
			//build the table
			$table = '<div id="easy_contents"';
			
			if(count($matches) > $float){
				$table .= ' class="easylargecontents" '; 
			}else{
				$table .= ' class="easysmallcontents" ';
			}
			
			$table .= '>'.PHP_EOL.'<a id="table" name="table"></a><span class="easycontentshead">'.$heading.'</span>'.PHP_EOL.'<ol>'.PHP_EOL;
			
			//add the headings to the table
			foreach ($matches as $i=>$val) {
				$table .= "\t".'<li><a href="'.get_permalink().'#'.nice_url($val[1]).'" title="'.$val[1].'">'.wp_break_maxchar($val[1]).'</a></li>'.PHP_EOL;
			}
			foreach($add as $val){
				if(!empty($val)){
					$table .= "\t".'<li><a href="'.get_permalink().'#'.nice_url($val).'" title="'.$val.'">'.wp_break_maxchar($val).'</a></li>'.PHP_EOL;
				}
			}
			
			$table .= '</ol>'.PHP_EOL.'</div>'.PHP_EOL.PHP_EOL;
			
			function niceUrl($var){
				global $post;
				
				$top = stripslashes(get_option('wpec_top'));
				$element = stripslashes(get_option('wpec_element'));
				
				$link = strtolower(str_replace(' ', '-', $var[1]));
			
				return sprintf('<'.$element.'><a href="'.get_permalink().'#'.$top.'" id="%s" name="%s">'.$var[1].'</a></'.$element.'>',$link,$var[1]);
			}
			
			$content = preg_replace_callback('#\<'.$element.'>(.+?)\</'.$element.'>#si', 'niceUrl', $content);

			return str_replace('<!--contents-->', $table, $content);
		}
	}else{
		return $content;
	}
}

//add a button to the default editor
function wpec_add_wysiwyg(){
	
}



//add a optionspage to the settings list
function wpec_add_options_page(){
	add_options_page('Easy Contents Settings', 'Easy Contents', 8, basename(__FILE__),'wpeasy_contents_subpanel');
}

//create the optionpage
function wpeasy_contents_subpanel(){
	load_plugin_textdomain('wpec',$path = $wpcf_path);
	$location = get_option('siteurl') . '/wp-admin/options-general.php?page=wp_easy_contents.php'; // Form Action URI
	
	/*Lets add some default options if they don't exist*/
	add_option('wpec_title', __('Table of Contents', 'wpec'));
	add_option('wpec_element', __('h2', 'wpec'));
	add_option('wpec_char', __('35', 'wpec'));
	add_option('wpec_top', __('table', 'wpec'));
	add_option('wpec_add', __('Leave a Reply', 'wpec'));
	add_option('wpec_float', __('5', 'wpec'));
	
	/*check form submission and update options*/
	if ('process' == $_POST['stage']){
		update_option('wpec_title', $_POST['wpec_title']);
		update_option('wpec_element', $_POST['wpec_element']);
		update_option('wpec_char', $_POST['wpec_char']);
		update_option('wpec_top', $_POST['wpec_top']);
		update_option('wpec_add', $_POST['wpec_add']);
		update_option('wpec_float', $_POST['wpec_float']);
	}
	
	/*Get options for form fields*/
	$wpec_title = stripslashes(get_option('wpec_title'));
	$wpec_element = stripslashes(get_option('wpec_element'));
	$wpec_char = stripslashes(get_option('wpec_char'));
	$wpec_top = stripslashes(get_option('wpec_top'));
	$wpec_add = stripslashes(get_option('wpec_add'));
	$wpec_float = stripslashes(get_option('wpec_float'));
	?>
	
	<div class="wrap"> 
        <h2>WordPress Easy Contents Settings</h2>
        <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
            <input type="hidden" name="stage" value="process" />
            <table class="form-table">
            <tr valign="top">
            <th scope="row"><label for="wpec_title">Table heading</label></th>
            <td><input name="wpec_title" type="text" id="wpec_title" value="<?php echo $wpec_title; ?>" class="regular-text code" /></td>
            </tr>
            
            <tr valign="top">
            <th scope="row"><label for="wpec_element">Elements to add to table</label></th>
            <td><input name="wpec_element" type="text" id="wpec_element" value="<?php echo $wpec_element; ?>" size="40" class="regular-text code" /><br />
                <em>Specify the element. For example: h1, h2, h3 etc.</em></td>
            </tr>
            
            <tr valign="top">
            <th scope="row"><label for="wpec_char"><?php _e('Shorten') ?></label></th>
            <td><input name="wpec_char" type="text" id="wpec_char" value="<?php echo $wpec_char; ?>" size="40" class="regular-text code" /><br />
                <em>Max characters to show in the table.</em></td>
            </tr>

            <tr valign="top">
            <th scope="row"><label for="wpec_char">Top anchor</label></th>
            <td><input name="wpec_top" type="text" id="wpec_top" value="<?php echo $wpec_top; ?>" size="40" class="regular-text code" /></td>
            </tr>

            <tr valign="top">
            <th scope="row"><label for="wpec_ignore">Add headings</label></th>
            <td><textarea name="wpec_add" id="wpec_add" rows="4" cols="50" class="regular-text code"><?php echo $wpec_add; ?></textarea><br />
                <em>Add each value of elements that have to be add on a new line.</em></td>
            </tr>
            
            <tr valign="top">
            <th scope="row"><label for="wpec_float">Float</label></th>
            <td><input name="wpec_float" type="text" id="wpec_float" value="<?php echo $wpec_float; ?>" size="40" class="regular-text code" /><br />
                <em>If a table contains less then x items the table is aligned right.</em></td>
            </tr>

            </table>
            <p class="submit">
              <input type="submit" name="Submit" value="Update Options &raquo;" class="button-primary" />
            </p>
		</form>
        <ul>
        	<li><a href="http://crispijnverkade.nl/">Go to the author page</a></li>
            <li><a href="http://crispijnverkade.nl/blog/wordpress-easy-contents">Go to the project page</a></li>
            <li><a href="http://wordpress.org/extend/plugins/wp-easyindex/">Go to the project page in the Plugin Directory</a></li>
        </ul>
        
        <form class="donate" method="post" action="https://www.paypal.com/cgi-bin/webscr">
        	<input value="1.00" name="amount" type="hidden">
            <input value="_xclick" name="cmd" type="hidden">
            <input value="crispijnverkade@gmail.com" name="business" type="hidden">
            <input value="Donate for this great plugins!" name="item_name" type="hidden">
            <input value="1" name="no_shipping" type="hidden">
            <input value="http://crispijnverkade.nl/blog" name="return" type="hidden">
            <input value="http://crispijnverkade.nl/blog" name="cancel_return" type="hidden">
            <input value="EUR" name="currency_code" type="hidden">
            <input value="0" name="tax" type="hidden">
            <input alt="PayPal - The safer, easier way to pay online" name="submit" style="border: 0pt none ;" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" type="image">
		</form>
	</div>

<?php
} //end wpcontactform_subpanel()

//add_action('admin_head', 'wpec_header_admin');
add_action('admin_menu', 'wpec_add_options_page');

add_action('wp_head', 'wpec_header');
add_filter('the_content', 'wp_get_table', 7);
?>