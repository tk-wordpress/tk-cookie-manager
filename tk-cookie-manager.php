<?php
/**
 * @package           tk-cookie-manager
 * @author            Timon Kreis <mail@timonkreis.de>
 * @license           GPL-3.0
 * @link              https://github.com/tk-wordpress/tk-cookie-manager
 *
 * @wordpress-plugin
 * Plugin Name:       Cookie Manager
 * Plugin URI:        https://github.com/tk-wordpress/tk-cookie-manager
 * Description:       Inform visitors about used cookies and block scripts until consent is given. In addition, block automatically embedded external contents until visitor accepts the platform.
 * Description:       Show cookie consent modal on page visit and control script execution.
 * Version:           1.1.1
 * Author:            Timon Kreis
 * Author URI:        https://www.timonkreis.de/
 * Text Domain:       tk_cookie_manager
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.md
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/tk-wordpress/tk-cookie-manager
 * Requires PHP:      7.1
 * Requires at least: 5.1.0
 */
namespace TimonKreis;

defined('ABSPATH') || die;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class CookieManager
{
	public const VERSION = '1.0.0';
	public const FILE = __FILE__;

	/**
	 * @since 1.0.0
	 */
	public function __construct()
	{
		spl_autoload_register(
			function(string $class) : void {
				if (strpos($class, __CLASS__) === 0) {
					$length = strlen(__CLASS__) + 1;
					$path = __DIR__ . '/includes/' . str_replace('\\', '/', substr($class, $length)) . '.php';

					if (@is_file($path)) {
						/** @noinspection PhpIncludeInspection */
						require_once $path;
					}
				}
			},
			false,
			true
		);

		add_action('init', [$this, 'loadPluginTextdomain']);

		if (is_admin()) {
			new CookieManager\Admin\DonationLink();
			new CookieManager\Admin\Settings();
		} else {
			new CookieManager\Frontend();
			new CookieManager\Frontend\EmbeddedContents();
			new CookieManager\Frontend\Infobox();
		}

		new CookieManager\Page();
		new CookieManager\Shortcodes();
	}

	/**
	 * Load translations.
	 *
	 * @since 1.0.0
	 */
	public function loadPluginTextdomain() : void
	{
		load_plugin_textdomain('tk_cookie_manager', false, basename(__DIR__) . '/languages');
	}
}

new CookieManager();
