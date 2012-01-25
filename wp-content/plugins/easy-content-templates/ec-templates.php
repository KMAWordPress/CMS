<?php
/*
Plugin Name: Easy Content Templates
Plugin URI: http://japaalekhin.llemos.com/easy-content-templates
Description: This plugin lets you define content templates to quickly apply to new posts or pages.
Version: 1.0
Author: Japa Alekhin Llemos
Author URI: http://japaalekhin.llemos.com/
License: GPL2

Copyright 2011  Japa Alekhin Llemos  (email : japaalekhin@llemos.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class ec_templates {

// Internals *******************************************************************

// Essentials ******************************************************************
    
    static function exists($id){
        global $wpdb;
        return $wpdb->get_var("SELECT `id` FROM `" . $wpdb->posts . "` WHERE `id` = '" . intval($id) . "' AND `post_type` = 'ec-template'") != null;
    }
    
    static function get_contents($id){
        if(!self::exists($id)) return array('success' => false, 'message' => 'Template does not exist!');
        $template = get_post($id);
        return array(
            'success' => true,
            'message' => 'Template loaded!',
            'title' => apply_filters('the_title', $template->post_title),
            'content' => apply_filters('the_content', $template->post_content),
            'excerpt' => apply_filters('the_excerpt', $template->post_excerpt),
        );
    }

// Actions *********************************************************************

    static function action_init(){
        register_post_type('ec-template', array(
            'label' => 'Template',
            'labels' => array(
                'name' => 'Templates',
                'singular_name' => 'Template',
                'add_new' => 'Add New',
                'all_items' => 'Templates',
                'add_new_item' => 'Add New Template',
                'edit_item' => 'Edit Template',
                'new_item' => 'New Template',
                'view_item' => 'View Template',
                'search_items' => 'Search Templates',
                'not_found' => 'No templates found',
                'not_found_in_trash' => 'No templates found in trash',
                'menu_name' => 'Templates',
            ),
            'description' => 'AWM Shop - Products',
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => array(
                'title', 'editor', 'thumbnail',
            ),
        ));
        wp_enqueue_script('jquery');
    }
    
    static function action_add_meta_boxes(){
        $post_types = get_post_types(array(), 'objects');
        foreach($post_types as $post_type){
            if($post_type->show_ui && 'ec-template' != $post_type->name){
                add_meta_box('mtb_ec_templates', 'Easy Content Template', array('ec_templates', 'action_metabox_render'), $post_type->name, 'side', 'high');
            }
        }
    }
    
    static function action_metabox_render(){
        ob_start();
        include plugin_dir_path(__FILE__) . 'ec-templates-metabox.php';
        echo ob_get_clean();
    }
    
    static function action_ajax_ect_get_contents(){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode(self::get_contents(isset($_POST['template_id']) ? intval($_POST['template_id']) : 0));
        exit;
    }

// Filters *********************************************************************

// Template Tags ***************************************************************

// Shortcodes ******************************************************************

}

add_action('init',                              array('ec_templates',   'action_init'),                 1000);
add_action('add_meta_boxes',                    array('ec_templates',   'action_add_meta_boxes'),       1000);
add_action('wp_ajax_nopriv_ect_get_contents',   array('ec_templates',   'action_ajax_ect_get_contents'));
add_action('wp_ajax_ect_get_contents',          array('ec_templates',   'action_ajax_ect_get_contents'));

?>