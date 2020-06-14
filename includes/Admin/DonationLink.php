<?php
namespace TimonKreis\CookieManager\Admin;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class DonationLink
{
	/**
	 * Add required actions.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_action('plugin_row_meta', [$this, 'pluginRowMeta'], 10, 2);
	}

	/**
	 * Add donation link to plugins list.
	 *
	 * @param array $pluginMeta
	 * @param string $pluginFile
	 * @return array
	 * @since 1.0.0
	 */
	public function pluginRowMeta(array $pluginMeta, string $pluginFile) : array
	{
		if (plugin_basename(CookieManager::FILE) == $pluginFile) {
			$pluginMeta[] = CookieManager\TemplateLoader::get(
				'admin/donation-link',
				[
					'iconUrl' => plugin_dir_url(CookieManager::FILE) . 'public/images/beer.svg',
					'donationUrl' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F6H7DLAZHMUAY&source=url',
				]
			);
		}

		return $pluginMeta;
	}
}
