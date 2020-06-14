<?php
namespace TimonKreis\CookieManager;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class TemplateLoader
{
	/**
	 * @var string[]
	 */
	protected static $cache = [];

	/**
	 * Load a template and applies variables to it.
	 *
	 * @global \WP_Query $wp_query
	 * @param string $template
	 * @param array $variables
	 * @since 1.0.0
	 */
	public static function load(string $template, array $variables = []) : void
	{
		global $wp_query;

		/**
		 * Fires before a template is loaded.
		 *
		 * @since 1.0.0
		 */
		do_action('tk_cookie_manager_load_template', $template, $variables);

		/**
		 * Fires before the variables are applied to the template.
		 *
		 * @since 1.0.0
		 */
		$variables = apply_filters('tk_cookie_manager_template_variables', $variables);

		if ($variables) {
			$wp_query->query_vars = array_merge($wp_query->query_vars, $variables);
		}

		if (!isset(self::$cache[$template])) {
			$themePath = '/tk-cookie-manager';
			$paths = [
				get_template_directory() . $themePath,
				plugin_dir_path(CookieManager::FILE) . 'templates',
			];

			// Add additional path for child themes.
			if (get_stylesheet_directory() != get_template_directory()) {
				array_unshift($paths, get_stylesheet_directory() . $themePath);
			}

			/**
			 * Fires before the template is searched in the paths.
			 *
			 * @since 1.0.0
			 */
			$paths = apply_filters('tk_cookie_manager_template_paths', $paths);
			$paths = array_map('trailingslashit', $paths);

			foreach ($paths as $path) {
				if (@file_exists($path . $template . '.php')) {
					self::$cache[$template] = $path . $template . '.php';

					break;
				}
			}
		}

		if (isset(self::$cache[$template])) {
			load_template(self::$cache[$template], false);
		}
	}

	/**
	 * Get a template and applies variables to it.
	 *
	 * @param string $template
	 * @param array $variables
	 * @return string
	 * @since 1.0.0
	 */
	public static function get(string $template, array $variables = []) : string
	{
		ob_start();

		self::load($template, $variables);

		return trim(ob_get_clean());
	}
}
