<?php
/**
 * @var array $fields
 */
TimonKreis\CookieManager\TemplateLoader::load(
	'admin/settings/section',
	[
		'introduction' => __(
			'The cookie infobox is shown when a visitor enters the site and does not have any existing cookie settings yet.',
			'tk_cookie_manager'
		),
		'fields' => $fields,
	]
);
