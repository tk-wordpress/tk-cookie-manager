<?php
namespace TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Shortcodes
{
	/**
	 * Register shortcodes.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_shortcode('tk-cookie-manager-infobox-opener', [$this, 'infoboxOpener']);
		add_shortcode('tk-cookie-manager-embedded-contents-table', [$this, 'embeddedContentsTable']);
	}

	/**
	 * Render link to open infobox.
	 *
	 * @param array $attributes
	 * @param string $content
	 * @param string $shortcode
	 * @return string
	 * @since 1.0.0
	 */
	public function infoboxOpener($attributes, string $content, string $shortcode) : string
	{
		$attributes = shortcode_atts(
			[
				'label' => __('Adjust cookie settings', 'tk_cookie_manager'),
			],
			$attributes,
			$shortcode
		);

		$label = $content != '' ? $content : $attributes['label'];

		/**
		 * Fires before applying infobox opener label to the link.
		 *
		 * @since 1.0.0
		 */
		$label = apply_filters('tk_cookie_manager/shortcode/infobox_opener/label', $label);

		return TemplateLoader::get(
			'frontend/shortcodes/infobox-opener',
			[
				'label' => $label,
			]
		);
	}

	/**
	 * Render list of allowed platforms to disallow them.
	 *
	 * @param array $attributes
	 * @param string $content
	 * @param string $shortcode
	 * @return string
	 * @since 1.0.0
	 */
	public function embeddedContentsTable($attributes, string $content, string $shortcode) : string
	{
		$attributes = shortcode_atts(
			[
				'platforms' => implode(',', array_keys(Platforms::getPlatforms())),
			],
			$attributes,
			$shortcode
		);

		/**
		 * Fires before applying platforms to embedded contents table.
		 *
		 * @since 1.0.0
		 */
		$platforms = apply_filters(
			'tk_cookie_manager/shortcode/embedded_contents_table/platforms',
			array_map('trim', explode(',', $attributes['platforms']))
		);

		$availablePlatforms = array_filter(
			Platforms::getPlatforms(),
			function(string $platform) use ($platforms) : bool {
				return in_array($platform, $platforms);
			},
			ARRAY_FILTER_USE_KEY
		);

		return TemplateLoader::get(
			'frontend/shortcodes/embedded-contents-table',
			[
				'platforms' => $platforms,
				'availablePlatforms' => $availablePlatforms,
			]
		);
	}
}
