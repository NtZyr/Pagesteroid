<?php
/*
    Plugin Name: Pagesteroid – Page Builder
    Plugin URI: https://ntzyr.xyz
    Description: Very simple and geek page builder.
    Version: 0.2.0
    Author: Vladislav Surikov
    Author URI: https://ntzyr.xyz
    Text Domain: pagesteroid
    Domain Path: /languages
*/

/**
 * Require classes
 */
require plugin_dir_path( __FILE__ ) . 'inc/class-wrapper.php';

/**
 * Widgets
 */

function wrapper_menu() {
?>
<div class="wrapper-adds">
    <button type="button" class="wrapper-btn wrapper-add dashicons dashicons-plus"><?= __( 'Add...', 'pagesteroid' ); ?></button>
    <button type="button" class="wrapper-btn wrapper-remove dashicons dashicons-no-alt"><?= __( 'Remove', 'pagesteroid' ); ?></button>
    <?php $widgets = new Pagesteroid\Widget_List(
        array(
            new Pagesteroid\Widget( 'textblock', __( 'Text Block', 'pagesteroid' ) ),
            new Pagesteroid\Widget( 'posttype', __( 'Post Type Block', 'pagesteroid' ) ),
            new Pagesteroid\Widget( 'slider', __( 'Slider', 'pagesteroid' ) )
        )
    ); ?>
</div>
<?php
}

add_action( 'theme_page_templates', function ( $templates ){
    $templates['templates/pagesteroid.php'] = __( 'Pagesteroid', 'pagesteroid' );
    return $templates;
} );

add_action( 'edit_form_after_editor', function ( $post ) {
    if( 'page' !== $post->post_type ) {
        return;
    }

    
    $pagesteroid = get_post_meta( $post->ID, 'pagesteroid', true );
    // var_dump( $pagesteroid );
    // $pagesteroid = null;
?>
    <div id="pagesteroid">
        <?php wp_nonce_field( "pagesteroid_nonce_action", "pagesteroid_nonce" ); ?>
        <div class="pagesteroid-wrappers-controls">
            <button class="add-wrap button-primary button-large" data-wrapper="full-wrapper"><?= __( 'Add wrapper', 'pagesteroid' ); ?></button>
        </div>

        <div class="pagesteroid-rows">
            <?php if( $pagesteroid && is_array( $pagesteroid ) ) : ?>
                <?php foreach( $pagesteroid as $wrapper_num => $wrapper ) {
                    // var_dump( $wrapper['items'] );
                    Pagesteroid\Wrapper::admin( $wrapper['type'], $wrapper_num, $wrapper['id'], $wrapper['classes'], $wrapper['items'] );
                } ?>
            <?php else : ?>
                <?php Pagesteroid\Wrapper::admin( 'full-wrapper' ); ?>
            <?php endif; ?>
        </div>
    </div>
<?php
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    global $post_type;

    if( 'page' == $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
        wp_enqueue_script( 'admin-editor-toggle', plugin_dir_url( __FILE__ ) . '/assets/admin/js/editor-toggle.js', array( 'jquery' ) );
        wp_enqueue_style( 'admin-pagesteroid-style', plugin_dir_url( __FILE__ ) . '/assets/admin/css/style.css' );
        wp_enqueue_script( 'admin-pagesteroid-js', plugin_dir_url( __FILE__ ) . '/assets/admin/js/pagesteroid.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0', true );
        wp_localize_script( 'admin-pagesteroid-js', 'ajax_url', admin_url('admin-ajax.php') );
    }
} );

add_action( 'save_post', function( $post_id ) {
    global $post;
    $request = stripslashes_deep( $_POST );

    if ( ! isset( $request['pagesteroid_nonce'] ) || ! wp_verify_nonce( $request['pagesteroid_nonce'], 'pagesteroid_nonce_action' ) ){
        return $post_id;
    }

    if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    $post_type = get_post_type_object( $post->post_type );
    if ( 'page' != $post->post_type || !current_user_can( $post_type->cap->edit_post, $post_id ) ){
        return $post_id;
    }

    $saved_data = get_post_meta( $post_id, 'pagesteroid', true );
    
    // $submitted_data = isset( $request['pagesteroid'] ) ? pagesteroid_sanitize( $request['pagesteroid'] ) : null;
    // $submitted_data = isset( $request['pagesteroid'] ) ? json_encode( $request['pagesteroid'], JSON_UNESCAPED_UNICODE ) : null;
    $submitted_data = isset( $request['pagesteroid'] ) ? $request['pagesteroid'] : null;

    if ( $submitted_data && '' == $saved_data ){
        add_post_meta( $post_id, 'pagesteroid', $submitted_data, true );
    } elseif( $submitted_data && ( $submitted_data != $saved_data ) ){
        update_post_meta( $post_id, 'pagesteroid', $submitted_data );
    } elseif ( empty( $submitted_data ) && $saved_data ){
        delete_post_meta( $post_id, 'pagesteroid' );
    }
} );

add_filter( 'the_content', function() {
    global $post;
    
    if( is_page() && 'templates/pagesteroid.php' == get_page_template_slug( get_the_ID() ) ){
        $pagesteroid = get_post_meta( $post->ID, 'pagesteroid', true );

        $out = '';

        foreach( $pagesteroid as $wrapper ) {
            $out .= Pagesteroid\Wrapper::front( $wrapper['type'], $wrapper['id'], $wrapper['classes'], $wrapper['items'] );;
        }
        
        return $out;
    }
} );

function get_widget() {
    $widget_name = $_POST['widget'];
    $wrapper = $_POST['wrapper'];
    $num = $_POST['num'];
    Pagesteroid\Widget::admin( $widget_name, $wrapper, $num );
    wp_die();
}

add_action('wp_ajax_get_widget', 'get_widget');
add_action('wp_ajax_nopriv_get_widget', 'get_widget');

function get_wrapper() {
    $wrapper_name = $_POST['wrapper'];
    $num = $_POST['num'];
    Pagesteroid\Wrapper::admin( $wrapper_name, $num );

    wp_die();
}

add_action('wp_ajax_get_wrapper', 'get_wrapper');
add_action('wp_ajax_nopriv_get_wrapper', 'get_wrapper');

function get_slide() {
    $data = array(
        'wrapper' => $_POST['wrapper'],
        'item' => $_POST['item'],
        'num' => $_POST['num']
    );

    Pagesteroid\Widget::particial( 'slider', 'slide', $data );

    wp_die();
}

add_action('wp_ajax_get_slide', 'get_slide');
add_action('wp_ajax_nopriv_get_slide', 'get_slide');