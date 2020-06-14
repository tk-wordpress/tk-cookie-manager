<?php
namespace TimonKreis\CookieManager\Frontend;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Infobox
{
	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Add required actions.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->settings = get_option('tk_cookie_manager', []);

		if ($this->settings['infobox']['active'] ?? false) {
			add_action('wp_footer', [$this, 'wpFooter']);
		}
	}

	/**
	 * Add infobox to body.
	 *
	 * @since 1.0.0
	 */
	public function wpFooter() : void
	{
		$settings = $this->settings['infobox'];
		$footerLinks = [];
		$cookieGroups = [];
		$version = [];
		$cookiegroupsHtml = [];

		// Filter inactive cookie groups and cookies and build the version.
		foreach ($this->settings['cookies']['cookies']['cookieGroups'] ?? [] as $cookieGroup) {
			if ($cookieGroup['active']) {
				$cookies = [];

				foreach ($cookieGroup['cookies'] as $cookie) {
					if ($cookie['active']) {
						$cookies[] = $cookie;
					}
				}

				$cookieGroup['cookies'] = $cookies;

				$version[] = $cookieGroup['id'];
				$cookieGroups[] = $cookieGroup;
			}
		}

		sort($version, SORT_NUMERIC);

		/**
		 * Fires before applying layout to the infobox.
		 *
		 * @since 1.0.0
		 */
		$layout = apply_filters('tk_cookie_manager/infobox/layout', $settings['layout'] ?? 'popup', $this->settings);

		/**
		 * Fires before applying skin to the infobox.
		 *
		 * @since 1.0.0
		 */
		$skin = apply_filters('tk_cookie_manager/infobox/skin', $settings['skin'] ?? 'light', $this->settings);

		/**
		 * Fires before applying headline to the infobox.
		 *
		 * @since 1.0.0
		 */
		$headline = apply_filters('tk_cookie_manager/infobox/headline', $settings['headline'] ?? '', $this->settings);

		/**
		 * Fires before applying description to the infobox.
		 *
		 * @since 1.0.0
		 */
		$description = apply_filters(
			'tk_cookie_manager/infobox/description',
			$settings['description'] ?? '',
			$this->settings
		);

		/**
		 * Fires before applying cookie groups to the infobox.
		 *
		 * @since 1.0.0
		 */
		$cookieGroups = apply_filters(
			'tk_cookie_manager/infobox/cookieGroups',
			$cookieGroups,
			$this->settings
		);

		/**
		 * Fires before applying value of privacy policy link to the infobox.
		 *
		 * @since 1.0.0
		 */
		$privacyPolicyLink = apply_filters(
			'tk_cookie_manager/infobox/privacy_policy_link',
			$settings['privacyPolicyLink'] ?? true,
			$this->settings
		);

		/**
		 * Fires before applying value of imprint link to the infobox.
		 *
		 * @since 1.0.0
		 */
		$imprintLink = apply_filters(
			'tk_cookie_manager/infobox/imprint_link',
			$settings['imprintLink'] ?? true,
			$this->settings
		);

		if ($privacyPolicyLink && $this->settings['general']['privacyPolicyPage']['page'] ?? false) {
			if ($this->settings['general']['privacyPolicyPage']['page'] == 'wp') {
				$pageId = (int)get_option('wp_page_for_privacy_policy');

				if ($pageId && get_post_status($pageId) == 'publish') {
					$footerLinks[] = [
						'label' => get_the_title($pageId),
						'url' => get_privacy_policy_url(),
					];
				}
			} elseif($this->settings['general']['privacyPolicyPage']['page'] == 'url') {
				$footerLinks[] = [
					'label' => $this->settings['general']['privacyPolicyPage']['label'],
					'url' => $this->settings['general']['privacyPolicyPage']['url'],
				];
			} elseif (get_post_status($this->settings['general']['privacyPolicyPage']['page']) == 'publish') {
				$footerLinks[] = [
					'label' => get_the_title($this->settings['general']['privacyPolicyPage']['page']),
					'url' => get_page_link($this->settings['general']['privacyPolicyPage']['page']),
				];
			}
		}

		if ($imprintLink && $this->settings['general']['imprintPage']['page'] ?? false) {
			if ($this->settings['general']['imprintPage']['page'] == 'url') {
				$footerLinks[] = [
					'label' => $this->settings['general']['imprintPage']['label'],
					'url' => $this->settings['general']['imprintPage']['url'],
				];
			} elseif (get_post_status($this->settings['general']['imprintPage']['page']) == 'publish') {
				$footerLinks[] = [
					'label' => get_the_title($this->settings['general']['imprintPage']['page']),
					'url' => get_page_link($this->settings['general']['imprintPage']['page']),
				];
			}
		}

		/**
		 * Fires before applying footer links to the infobox.
		 *
		 * @since 1.0.0
		 */
		$footerLinks = apply_filters('tk_cookie_manager/infobox/footer_links', $footerLinks, $this->settings);

		/**
		 * Fires before applying version to the infobox.
		 *
		 * @since 1.0.0
		 */
		$version = apply_filters('tk_cookie_manager/infobox/version', implode('_', $version), $this->settings);

		// Build cookie group HTML array.
		foreach ($cookieGroups as $cookieGroup) {
			foreach ($cookieGroup['cookies'] as $cookie) {
				if ($cookie['html']) {
					if (!isset($cookiegroupsHtml[(string)$cookieGroup['id']])) {
						$cookiegroupsHtml[(string)$cookieGroup['id']] = '';
					}

					$cookiegroupsHtml[(string)$cookieGroup['id']] .= $cookie['html'];
				}
			}
		}

		/**
		 * Fires before applying cookie group HTML to the infobox.
		 *
		 * @since 1.0.0
		 */
		$cookiegroupsHtml = apply_filters('tk_cookie_manager/infobox/cookieHtml', $cookiegroupsHtml, $this->settings);

		CookieManager\TemplateLoader::load(
			'frontend/infobox',
			[
				'layout' => $layout,
				'skin' => $skin,
				'headline' => $headline,
				'description' => $description,
				'cookieGroups' => $cookieGroups,
				'footerLinks' => $footerLinks,
				'version' => $version,
				'cookiegroupsHtml' => json_encode($cookiegroupsHtml, JSON_UNESCAPED_UNICODE),
			]
		);
	}
}
