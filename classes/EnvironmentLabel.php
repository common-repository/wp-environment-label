<?php

/**
 * Class EnvironmentLabel
 */
class EnvironmentLabel
{
	/**
	 * @var bool
	 */
	private static $initiated = false;
	/**
	 * @var string
	 */
	private static $environment_label = null;

	public static function init()
	{
		if (!self::$initiated) {

			self::init_admin_hooks();
			self::$environment_label = defined('WP_ENVIRONMENT_LABEL') ? WP_ENVIRONMENT_LABEL : get_option('wp_environment_label');

			if (self::$environment_label) {
				self::init_hooks();
			}
		}
	}

	public function onActivate()
	{
	}

	public function onDeactivate()
	{
		delete_option('wp_environment_label');
	}

	private static function init_hooks()
	{
		self::$initiated = true;
		add_action('wp_footer', [__CLASS__, 'render'], 999);
		add_action('admin_footer', [__CLASS__, 'render']);
	}

	private static function init_admin_hooks()
	{
		add_action('admin_init', [__CLASS__, 'wp_environment_label_settings_init']);
		add_action('admin_menu', [__CLASS__, 'wp_environment_label_settings']);
	}

	public static function render()
	{
		ob_start();
		echo '<div style="background-color: mediumturquoise; border-bottom-left-radius: 20%; z-index: 999999; padding: 10px; bottom: 20px; color: white; position: -webkit-sticky; position: sticky; float: right; font-size: 14px; font-family: arial; opacity: 0.8">';
		echo self::$environment_label;
		echo '</div>';
		ob_end_flush();
	}

	/**
	 * custom option and settings
	 */
	public static function wp_environment_label_settings_init()
	{
		register_setting('wp_environment_label_settings', 'wp_environment_label');
	}

	public static function wp_environment_label_settings()
	{
		add_menu_page(
			'WP Environment Label',
			'WP Environment Label',
			'manage_options',
			'wp_environment_label_settings',
			[__CLASS__, 'wp_environment_label_settings_html'],
			null,
			120
		);
	}

	public static function wp_environment_label_settings_html()
	{
		if (!current_user_can('manage_options')) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form action="options.php" method="post">
				<?php if (defined('WP_ENVIRONMENT_LABEL')) : ?>
					<input type="text" name="wp_environment_label"
						   value="<?php echo WP_ENVIRONMENT_LABEL; ?>" readonly/>
					<p>You have already set
					<pre>define('WP_ENVIRONMENT_LABEL', <?php echo WP_ENVIRONMENT_LABEL; ?>)</pre> in your config.</p>

				<?php else : ?>
					<input type="text" name="wp_environment_label"
						   value="<?php echo get_option('wp_environment_label'); ?>"/>
				<?php endif; ?>
				<?php
				settings_fields('wp_environment_label_settings');
				do_settings_sections('wp_environment_label_settings');
				submit_button('Save Environment Label');
				?>
			</form>
		</div>
		<?php
	}

	function php_version_too_old_message() {
		$class = 'notice notice-error';
		$message = __( 'Irks! An error has occurred. Your PHP version is too old for WP Environment Label. Please see readme.txt file.', 'wp-environment-label' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	function wordpress_version_too_old_message() {
		$class = 'notice notice-error';
		$message = __( 'Irks! An error has occurred. Your wordpress version is too old for WP Environment Label. Please update Wordpress core.', 'wp-environment-label' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}