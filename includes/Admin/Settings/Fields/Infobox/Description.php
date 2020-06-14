<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\Infobox;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Description extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->hasLabel = false;
		$this->slug = 'description';
		$this->title = __('Description', 'tk_cookie_manager');
		$this->default = '';

		$this->setOption('infobox');
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function renderField() : void
	{
		CookieManager\TemplateLoader::load(
			'admin/settings/fields/infobox/description',
			$this->getTemplateVariables([
				'description' => $this->option ?? $this->default,
			])
		);
	}

	/**
	 * Sanitize field.
	 *
	 * @param string|null $value
	 * @return string
	 * @since 1.0.0
	 */
	public function sanitizeField($value)
	{
		return trim((string)$value);
	}
}
