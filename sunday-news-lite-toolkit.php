<?php
/*
Plugin Name: Sunday News Lite Toolkit
Description: A specific plugin use in Sunday News Lite Theme, included some custom widgets, shortcodes, layouts.
Version: 1.0.0
Author: Kopa Theme
Author URI: http://kopatheme.com
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Sunday News Lite Toolkit plugin, Copyright 2014 Kopatheme.com
Sunday News Lite Toolkit is distributed under the terms of the GNU GPL

Requires at least: 4.4
Tested up to: 4.4.2
Text Domain: sunday-news-lite-toolkit
Domain Path: /languages/
*/

define( 'SUNDAY_NEWS_TOOLKIT_DIR', plugin_dir_url(__FILE__) );
define( 'SUNDAY_NEWS_TOOLKIT_PATH', plugin_dir_path(__FILE__) );

add_action( 'plugins_loaded', array('Sunday_News_Toolkit', 'plugins_loaded') );	
add_action( 'after_setup_theme', array('Sunday_News_Toolkit', 'after_setup_theme'), 25 );
add_action( 'admin_enqueue_scripts', array( 'Sunday_News_Toolkit', 'admin_enqueue_scripts'), 25 );

class Sunday_News_Toolkit {
	
	function __construct() {

		add_action( 'category_add_form_fields',  array( $this, 'add_category_image_field') );
        add_action( 'category_edit_form_fields',  array( $this, 'edit_category_meta_field') );
        add_action( 'edited_category',  array( $this, 'save_category_meta') );  
        add_action( 'create_category',  array( $this, 'save_category_meta') );
        add_filter( 'user_contactmethods', array( $this, 'modify_user_profile' ) );
        add_action( 'admin_init', 'sunday_news_register_page_post_options' );

		add_filter( 'excerpt_more', '__return_null' );

		// FUNCTIONS
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/functions.php';
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/ajax.php';
        require SUNDAY_NEWS_TOOLKIT_PATH . '/inc/metabox.php';
		
		// WIDGETS.
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/two-cols-black-bg.php';
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/carousel.php';
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/one-col-small-thumb.php';
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/ads.php';	
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/socials.php';	
		require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/tabs.php';	
        require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/subscrible.php';		
        require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/contact-form.php';
        require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/contact-info.php';
        require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/three-cols.php';
        require SUNDAY_NEWS_TOOLKIT_PATH . 'inc/widgets/two-cols-postformat.php';
        

        add_image_size( 'sunday-news-353-430', 353, 430, true );
        add_image_size( 'sunday-news-78-60', 78, 60, true );
        add_image_size( 'sunday-news-189-133', 189, 133, true );
        add_image_size( 'sunday-news-283-215', 283, 215, true );  

        // SHORTCODES.
		require_once( SUNDAY_NEWS_TOOLKIT_PATH . 'inc/shortcode-util.php' );
		$sunday_news_toolkit_dirs = 'inc/shortcodes/';

		$path = SUNDAY_NEWS_TOOLKIT_PATH . $sunday_news_toolkit_dirs . '*.php';
		$files = glob( $path );

		if ( $files ) {
		    foreach ( $files as $file ) {
		        require_once $file;
		    }
		}		
	}

	public static function plugins_loaded() {
		load_plugin_textdomain( 'sunday-news-lite-toolkit', false, SUNDAY_NEWS_TOOLKIT_PATH . '/languages/' );
	}

	public static function admin_enqueue_scripts() {
        global $pagenow;
        
        if ( in_array( $pagenow, array( 'edit-tags.php' ) ) ) {
            wp_enqueue_style( 'kopa_font_awesome' );
            wp_enqueue_style( 'kopa_jquery_ui_structure' );
            wp_enqueue_style( 'kopa_jquery_ui_theme' );
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_style( 'kopa_widget' );
        }

    }

    public static function add_category_image_field() {
        ?>
        <div class="form-field term-description-wrap">
            <label for="tag-description"><?php esc_html_e( 'Icon', 'sunday-news-lite-toolkit' ); ?></label>
            <a class="kf-icon-picker" href="#"><?php esc_html_e( 'Select icon', 'sunday-news-lite-toolkit' ); ?></a>
            <input type="hidden" name="term_meta[icon]" id="term_meta[icon]" value="" autocomplete="off" class="large-text kf-icon-picker-value">
            <span class="kf-icon-picker-preview"><i class=""></i></span>
        </div>
    <?php
    }

    public static function edit_category_meta_field( $term ) {
        $term_id   = $term->term_id;
        $term_meta = get_option( "taxonomy_$term_id" );
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="term_meta[icon]"><?php esc_html_e( 'Icon', 'sunday-news-lite-toolkit' ); ?></label></th>
            <td>
            <a class="kf-icon-picker" href="#"><?php esc_html_e( 'Select icon', 'sunday-news-lite-toolkit' ); ?></a>
            <input type="hidden" name="term_meta[icon]" id="term_meta[icon]" value="<?php echo esc_attr( $term_meta['icon'] ); ?>" autocomplete="off" class="large-text kf-icon-picker-value">
            <span class="kf-icon-picker-preview"><i class="<?php echo esc_attr( $term_meta['icon'] ); ?>"></i></span>
            </td>
        </tr>
    <?php
    }

    public static function save_category_meta( $term_id ) {
        if ( isset( $_POST['term_meta'] ) ) {
            $term_meta = get_option( "taxonomy_$term_id" );
            $cat_keys  = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ) {
                if ( isset ( $_POST['term_meta'][ $key ] ) ) {
                    $term_meta[ $key ] = esc_html( $_POST['term_meta'][ $key ] );
                }
            }
            update_option( "taxonomy_$term_id", $term_meta );
        }
    }  

    public static function modify_user_profile( $profile_fields ) {
        $socials = sunday_news_lite_get_profile_socials();
        if ( $socials ) {
            foreach ( $socials as $key => $social ) {
                $profile_fields[ $key ] = $social['title'];
            }
        }
        return $profile_fields;
    }

	public static function after_setup_theme() {
		if ( class_exists( 'Kopa_Framework' ) && defined( 'SUNDAY_NEWS_LITE_PREFIX' )){
			new Sunday_News_Toolkit();
		}
	}

}	
