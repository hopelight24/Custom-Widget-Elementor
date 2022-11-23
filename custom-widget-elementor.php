<?php
/**
 * Plugin Name: Custom Widget Elementor
 * Description: We building Elementor Extention for our official project. 
 * Plugin URI:  https://github.com/hopelight24/Custom-Widget-Elementor
 * Version:     1.0.0
 * Author:      Sazzad Mahmud
 * Author URI:  https://github.com/hopelight24
 * Text Domain: Custom-Widget-Elementor
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */

final class Inovate_Elementor_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Inovate_Elementor_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Inovate_Elementor_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'custom-widget-elementor', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ] );

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

        // Category Init
		add_action( 'elementor/init', [ $this, 'elementor_common_category' ] );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'custom-widget-elementor' ),
			'<strong>' . esc_html__( 'Custom Widget Elementor', 'custom-widget-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'custom-widget-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'custom-widget-elementor' ),
			'<strong>' . esc_html__( 'Custom Widget Elementor', 'custom-widget-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'custom-widget-elementor' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'custom-widget-elementor' ),
			'<strong>' . esc_html__( 'Custom Widget Elementor', 'custom-widget-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'custom-widget-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		 require_once( __DIR__ . '/widgets/it-city-hero.php' );
		 require_once( __DIR__ . '/widgets/it-place-hero.php' );
		 require_once( __DIR__ . '/widgets/it-accordion.php' );
		 require_once( __DIR__ . '/widgets/it-author-box.php' );
		 require_once( __DIR__ . '/widgets/it-posts.php' );
		 require_once( __DIR__ . '/widgets/it-posts2.php' );
		
		 require_once( __DIR__ . '/widgets/it-city.php' );
		 require_once( __DIR__ . '/widgets/it-place.php' );



		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new City_Hero_Widget() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Place_Hero_Widget() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IT_Accordion_Widget() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Author_Box_Widget() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IT_Posts_Widget() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IT_Posts_Widget_Two() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IT_City_Widget() );
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IT_Place_Widget() );


	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_controls() {

		/*
		* Todo: this block needs to be commented out when the custom control is ready
		*
		*
		// Include Control files
		require_once( __DIR__ . '/controls/test-control.php' );
		// Register control
		\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );
		*/

	}

	// Custom CSS
	public function widget_styles() {

		wp_register_style( 'custom-widget-main', plugins_url( 'assets/css/custom-widget-main.css', __FILE__ ), array(), time( ) );
		wp_enqueue_style( 'custom-widget-main' );
		
	}	

    // Custom JS
	public function widget_scripts() {

		wp_register_script( 'custom-widget-main', plugins_url( 'assets/js/custom-widget-main.js', __FILE__ ), array( ), time( ) );
		wp_enqueue_script( 'custom-widget-main' );
	}

    // Custom Category
    public function elementor_common_category () {

	   \Elementor\Plugin::$instance->elements_manager->add_category( 
	   	'custom-widget-category',
	   	[
	   		'title' => __( 'Custom Widget', 'custom-widget-elementor' ),
	   		'icon' => 'fa fa-plug', //default icon
	   	]
	   );

	}


}

Inovate_Elementor_Extension::instance();


// Change wordpress default logo
function wpb_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {     
        background-repeat: no-repeat;
        padding-bottom: 10px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wpb_login_logo' );







