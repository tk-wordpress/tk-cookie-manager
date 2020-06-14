<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\General;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Css extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->hasLabel = false;
		$this->slug = 'css';
		$this->title = __('Custom CSS', 'tk_cookie_manager');
		$this->default = '';

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
			'admin/settings/fields/general/css',
			$this->getTemplateVariables([
				'css' => $this->option ?? $this->default,
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
