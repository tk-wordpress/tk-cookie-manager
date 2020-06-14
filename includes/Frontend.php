<?php
namespace TimonKreis\CookieManager;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Frontend
{
	/**
	 * Add required stylesheets and javascripts.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'wpEnqueueScripts']);
		add_action('wp_head', [$this, 'wpHead']);
	}

	/**
	 * Add default CSS and JavaScript to frontend.
	 *
	 * @since 1.0.0
	 */
	public function wpEnqueueScripts() : void
	{
		wp_enqueue_style(
			'tk_cookie_manager_frontend',
			plugin_dir_url(CookieManager::FILE) . 'public/css/frontend.css',
			[],
			CookieManager::VERSION
		);

		wp_enqueue_script(
			'tk_cookie_manager_frontend',
			plugin_dir_url(CookieManager::FILE) . 'public/js/frontend.min.js',
			[],
			CookieManager::VERSION,
			true
		);
	}

	/**
	 * Add custom CSS to head.
	 *
	 * @since 1.0.0
	 */
	public function wpHead() : void
	{
		$settings = get_option('tk_cookie_manager', []);

		/**
		 * Fires before applying custom CSS to frontend.
		 *
		 * @since 1.0.0
		 */
		$css = apply_filters('tk_cookie_manager/general/css', $settings['general']['css'] ?? '');

		if ($css) {
			CookieManager\TemplateLoader::load(
				'frontend/css',
				[
					'css' => $css,
				]
			);
		}
	}
}
