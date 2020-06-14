<?php
namespace TimonKreis\CookieManager\Frontend;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class EmbeddedContents
{
	/**
	 * Add required actions.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_filter('render_block_data', [$this, 'renderBlockData']);
	}

	/**
	 * Change rendered block data.
	 *
	 * @param array $block
	 * @return array
	 * @since 1.0.0
	 */
	public function renderBlockData(array $block) : array
	{
		// Skip if the block does not embed something.
		if (strpos($block['blockName'], 'core-embed/') !== 0) {
			return $block;
		}

		$platforms = CookieManager\Platforms::getPlatforms();
		$platformKey = explode('/', $block['blockName'])[1];

		// Skip if the block is not supported.
		if (!isset($platforms[$platformKey])) {
			return $block;
		}

		$options = get_option('tk_cookie_manager', [])['embedded-contents'][$platformKey] ?? [];

		// Change URL for YouTube videos.
		if ($block['blockName'] == 'core-embed/youtube' && ($options['nocookie'] ?? true)) {
			$block['attrs']['url'] = str_replace(
				'www.youtube.com',
				'www.youtube-nocookie.com',
				$block['attrs']['url']
			);

			$block['innerContent'][0] = str_replace(
				'www.youtube.com',
				'www.youtube-nocookie.com',
				$block['innerContent']['0']
			);
		}

		// Check if the content should be blocked.
		if (!($options['block'] ?? true)) {
			return $block;
		}

		/**
		 * Wrap content into spoiler container.
		 *
		 * @global \WP_Post $post
		 * @param string $content
		 * @param string $platformKey
		 * @return string
		 */
		$wrapContent = function(string $content, string $platformKey) use ($platforms) : string {
			global $post;

			static $id = 1;

			return CookieManager\TemplateLoader::get(
				'frontend/embedded-contents/wrapper',
				[
					'idSuffix' => '-' . $post->ID . '-' . $id++,
					'platformKey' => $platformKey,
					'platform' => $platforms[$platformKey],
					'json' => json_encode($content, JSON_UNESCAPED_UNICODE),
					'privacyPolicyUrl' => $this->getPrivacyPolicyUrl(),
				]
			);
		};

		$block['innerContent'][0] = $wrapContent($block['innerContent'][0], $platformKey);

		return $block;
	}

	/**
	 * Get the privacy policy URL.
	 *
	 * @return string
	 */
	protected function getPrivacyPolicyUrl() : string
	{
		static $privacyPolicyUrl = null;

		if ($privacyPolicyUrl === null) {
			$privacyPolicyUrl = '';
			$settings = get_option('tk_cookie_manager', []);

			/**
			 * Fires before applying value of privacy policy link to the embedded container.
			 *
			 * @since 1.0.0
			 */
			$privacyPolicyLink = apply_filters(
				'tk_cookie_manager/embedded_contents/privacy_policy_link',
				$settings['general']['privacyPolicyLink'] ?? true,
				$settings
			);

			if ($privacyPolicyLink && $settings['general']['privacyPolicyPage']['page'] ?? false) {
				$privacyPolicyUrl = $settings['general']['privacyPolicyPage']['page'] == 'url'
					? $settings['general']['privacyPolicyPage']['url']
					: get_page_link($settings['general']['privacyPolicyPage']['page']);
			}
		}

		return $privacyPolicyUrl;
	}
}
