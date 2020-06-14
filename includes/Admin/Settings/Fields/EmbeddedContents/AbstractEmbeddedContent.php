<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\EmbeddedContents;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
abstract class AbstractEmbeddedContent extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @param string $slug
	 * @param string $title
	 * @since 1.0.0
	 */
	public function __construct(string $slug, string $title)
	{
		$this->slug = $slug;
		$this->title = $title;
		$this->default = [
			'block' => true,
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
			'admin/settings/fields/embedded-contents/block-default',
			$this->getTemplateVariables([
				'block' => $this->option['block'] ?? $this->default['block'],
			])
		);
	}

	/**
	 * Sanitize field.
	 *
	 * @param array $value
	 * @return array
	 * @since 1.0.0
	 */
	public function sanitizeField($value)
	{
		return [
			'block' => $value['block'] == 'on',
		];
	}
}
