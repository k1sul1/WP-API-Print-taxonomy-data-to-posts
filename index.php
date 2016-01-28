<?php
/**
* Plugin Name: WP-API: Print taxonomy data to posts
* Description: A plugin to print taxonomy data to posts and custom post types, just like in V1 of WP-API.
* Version: 1.0
* Author: Christian Nikkanen
* Author URI: http://christiannikkanen.me
* License: MIT
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action("rest_api_init",function(){
  $post_types = get_post_types(); // get all post type names

  foreach($post_types as $post_type){
  // loop all post types and add field "terms" to api output.
   register_rest_field(
    $post_type,
    "terms",
    array(
     "get_callback" => function($post){
        $taxonomies = get_post_taxonomies($post['id']);
        $terms_and_taxonomies = [];

        foreach($taxonomies as $taxonomy_name){
          $terms_and_taxonomies[$taxonomy_name] = wp_get_post_terms($post['id'],$taxonomy_name);
        }

        return $terms_and_taxonomies; // return array with taxonomy & term data
      }
    )
    );

 }

});
