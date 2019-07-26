<?php
/**
 * Child-Theme functions and definitions
 */

function prolingua_child_scripts() {
    wp_enqueue_style( 'prolingua-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'prolingua_child_scripts' );
 
?>