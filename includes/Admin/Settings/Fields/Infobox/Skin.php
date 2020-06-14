<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\Infobox;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Skin extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->slug = 'skin';
		$this->title = __('Skin', 'tk_cookie_manager');
		$this->default = 'light';

		$this->setOption('infobox');
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function renderField() : void
	{
		$skins = [
			'light' => __('Light', 'tk_cookie_manager'),
			'dark' => __('Dark', 'tk_cookie_manager'),
		];

		/**
		 * Fires before the possible skins are applied to the template.
		 *
		 * @since 1.0.0
		 */
		$skins = apply_filters('tk_cookie_manager/admin/settings/infobox/skins', $skins);

		CookieManager\TemplateLoader::load(
			'admin/settings/fields/infobox/skin',
			$this->getTemplateVariables([
				'skins' => $skins,
				'currentSkin' => $this->option ?? $this->default,
			])
		);
	}
}
