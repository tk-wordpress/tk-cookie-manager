<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\EmbeddedContents;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Spotify extends AbstractEmbeddedContent
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		parent::__construct('spotify', 'Spotify');
	}
}
