<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\Infobox;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Active extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->slug = 'active';
		$this->title = __('Is active', 'tk_cookie_manager');
		$this->default = true;

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
			'admin/settings/fields/infobox/active',
			$this->getTemplateVariables([
				'active' => $this->option ?? $this->default,
			])
		);
	}

	/**
	 * Sanitize field.
	 *
	 * @param string|null $value
	 * @return bool
	 * @since 1.0.0
	 */
	public function sanitizeField($value)
	{
		return $value == 'on';
	}
}
