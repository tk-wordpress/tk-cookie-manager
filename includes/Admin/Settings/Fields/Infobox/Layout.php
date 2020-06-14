<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\Infobox;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Layout extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->slug = 'layout';
		$this->title = __('Layout', 'tk_cookie_manager');
		$this->default = 'popup';

		$this->setOption('infobox');
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function renderField() : void
	{
		$layouts = [
			'banner' => __('Banner', 'tk_cookie_manager'),
			'popup' => __('Popup', 'tk_cookie_manager'),
		];

		/**
		 * Fires before the possible layouts are applied to the template.
		 *
		 * @since 1.0.0
		 */
		$layouts = apply_filters('tk_cookie_manager/admin/settings/infobox/layouts', $layouts);

		CookieManager\TemplateLoader::load(
			'admin/settings/fields/infobox/layout',
			$this->getTemplateVariables([
				'layouts' => $layouts,
				'currentLayout' => $this->option ?? $this->default,
			])
		);
	}
}
