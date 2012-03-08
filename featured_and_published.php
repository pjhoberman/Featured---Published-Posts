<?php
/**
 * @package Featured_Posts
 * @version 1.0
 */
/*
Plugin Name: Featured & Published Posts
Plugin URI: 
Description: Adds a link to the admin view all posts page that filters on published featured articles
Author: PJ Hoberman
Version: 1.0
Author URI: http://denveroffthewagon.com
*/

add_action('pre_get_posts', 'query_add_filter' );
function query_add_filter( $wp_query ) {
    if( is_admin()) {
        add_filter('views_edit-post', 'Add_My_filter');
    }
}

// add filter
function Add_My_filter($views) {
    global $wp_query;
    unset($views['mine']);
    $my_cat = 74;

    $query = array(
        //'author'      => $current_user->ID,
        'post_type'   => 'post',
        'post_status' => 'publish',
        'cat'         => $my_cat
    );
    $result = new WP_Query($query);
    $class = ($wp_query->query_vars['cat'] == 'featured') ? ' class="current"' : '';
    $views['publish_f'] = sprintf(__('<a href="%s"'. $class .'>Featured & Published <span class="count">(%d)</span></a>', 'Featured & Published'),
        admin_url('edit.php?post_status=publish&post_type=post&cat='.$my_cat),
        $result->found_posts);

    return $views;
}
