<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\EmbeddedContents;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class YouTube extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->slug = 'youtube';
		$this->title = 'YouTube';
		$this->default = [
			'block' => true,
			'nocookie' => true,
		];

		$this->setOption('embedded-contents');
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function renderField() : void
	{
		CookieManager\TemplateLoader::load(
			'admin/settings/fields/embedded-contents/youtube',
			$this->getTemplateVariables([
				'block' => $this->option['block'] ?? $this->default['block'],
				'nocookie' => $this->option['nocookie'] ?? $this->default['nocookie'],
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
			'block' => $value['block'] == 'on',
			'nocookie' => $value['nocookie'] == 'on',
		];
	}
}
