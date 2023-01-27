<?php
/*
   Plugin Name: Movies plugin
   description: Movies plugin
   Version: 1.0
   Author: Mr. Ahmed Saracevic
   Author URI: -
   License: MIT
   */


function movies_post_type()
{
   register_post_type(
      'movies',
      array(
         'labels' => array(
            'name' => 'Movies',
            'singular_name' => 'Movie'
         ),
         'public' => true,
         'show_in_rest' => true,
         'supports' => array('title', 'editor', 'thumbnail'),
         'has_archive' => true,
         'rewrite'   => array('slug' => 'movies'),
         'menu_position' => 5,
         'has_archive' => true
      )
   );
}

function add_movie_title_meta_box()
{
   add_meta_box('movie_title_meta_box', 'Movie Title', 'movie_title_meta_box_callback', 'movies', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_movie_title_meta_box');

function movie_title_meta_box_callback($post)
{
   wp_nonce_field(basename(__FILE__), 'movie_title_meta_box_nonce');
   $movie_title = get_post_meta($post->ID, 'movie_title', true);
   echo '<label for="movie_title_field">Enter movie title </label>';
   echo '<input type="text" id="movie_title_field" name="movie_title_field" value="' . esc_attr($movie_title) . '" size="25" />';
}

function save_movie_title_meta_box_data($post_id)
{
   if (!isset($_POST['movie_title_meta_box_nonce']) || !wp_verify_nonce($_POST['movie_title_meta_box_nonce'], basename(__FILE__)))
      return;

   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;

   if (!current_user_can('edit_post', $post_id))
      return;

   $movie_title = sanitize_text_field($_POST['movie_title_field']);
   update_post_meta($post_id, 'movie_title', $movie_title);
}
add_action('save_post', 'save_movie_title_meta_box_data');
add_action('init', 'movies_post_type');
