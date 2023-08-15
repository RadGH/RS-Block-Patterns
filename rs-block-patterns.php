<?php
/*
Plugin Name: RS Block Patterns
Description: Create custom block patterns for use in the Block Editor.
Version: 1.0.0
Author: Radley Sustaire
Author URI: https://radleysustaire.com/
*/

define( 'RSBP_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'RSBP_PATH', __DIR__ );

class RSBP_Plugin {
	
	// Singleton instance
	static $instance = null;
	
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	// Properties
	public $plugin_name = 'RS Block Patterns';
	
	public $missing_plugins = array();
	
	// Methods
	public function __construct() {
		
		// Finish loading the plugin after all other plugins have loaded
		add_action( 'plugins_loaded', array( $this, 'initialize_plugin' ), 20 );
		
		// When plugin is activated from the plugins page, call $this->plugin_activated()
		register_activation_hook( __FILE__, array( $this, 'plugin_activated' ) );
		
		// When plugin is deactivated from the plugins page, call $this->plugin_deactivated()
		register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivated' ) );
		
	}
	
	/**
	 * Initialize the plugin - called after plugins have loaded.
	 */
	public function initialize_plugin() {
		
		// ----------------------------------------
		// 1. Check dependencies
		
		// Advanced Custom Fields Pro
		if ( ! function_exists('acf') ) {
			$this->missing_plugins[] = 'Advanced Custom Fields Pro';
		}
		
		// Bail if any required plugins are missing
		if ( ! empty($this->missing_plugins) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_dependencies' ) );
			return;
		}
		
		// ----------------------------------------
		// 2. Include acf fields
		require_once( RSBP_PATH . '/fields/post.php' );
		require_once( RSBP_PATH . '/fields/settings.php' );
		
		// ----------------------------------------
		// 3. Include general functions
		require_once( RSBP_PATH . '/includes/blocks.php' );
		require_once( RSBP_PATH . '/includes/fields.php' );
		require_once( RSBP_PATH . '/includes/post-type.php' );
		
	}
	
	/**
	 * Displayed on admin dashboard if a required plugin is not active
	 *
	 * @return void
	 */
	public function admin_notice_missing_dependencies() {
		?>
		<div class="notice notice-error">
			<p>
				<strong><?php echo $this->plugin_name; ?>:</strong>
				The following plugins are required: <?php echo implode(', ', $this->missing_plugins); ?>.
				Install or activate the plugin(s) from the <a href="<?php echo esc_attr(admin_url('plugins.php')); ?>">plugins page</a>.
			</p>
		</div>
		<?php
	}
	
	/**
	 * Only triggered when the plugin is activated, typically through the plugin dashboard
	 *
	 * @return void
	 */
	public function plugin_activated() {
		// Include classes that add rewrite rules
		require_once( RSBP_PATH . '/includes/post-type.php' );
		
		// Register the post type now
		rsbp_register_post_type();
		
		// Flush rewrite rules
		flush_rewrite_rules();
	}
	
	/**
	 * Only triggered when the plugin is deactivated
	 *
	 * @return void
	 */
	public function plugin_deactivated() {
		// Flush rewrite rules
		flush_rewrite_rules();
	}
}

function rs_block_patterns() {
	return RSBP_Plugin::get_instance();
}

rs_block_patterns();