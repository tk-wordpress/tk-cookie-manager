<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\General;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class PrivacyPolicyPage extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->slug = 'privacyPolicyPage';
		$this->title = __('Privacy policy page', 'tk_cookie_manager');
		$this->default = [
			'page' => 0,
			'label' => '',
			'url' => '',
		];

		$this->setOption('general');
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function renderField() : void
	{
		CookieManager\TemplateLoader::load(
			'admin/settings/fields/general/privacy-policy-page',
			$this->getTemplateVariables([
				'pages' => get_pages(),
				'value' => [
					'page' => $this->option['page'] ?? $this->default['page'],
					'label' => $this->option['label'] ?? $this->default['label'],
					'url' => $this->option['url'] ?? $this->default['url'],
				],
			])
		);
	}

	/**
	 * Sanitize field.
	 *
	 * @param array|null $value
	 * @return array
	 * @since 1.0.0
	 */
	public function sanitizeField($value)
	{
		return [
			'page' => $value['page'] ?? $this->default['page'],
			'label' => trim($value['label'] ?? $this->default['label']),
			'url' => trim($value['url'] ?? $this->default['url']),
		];
	}
}
