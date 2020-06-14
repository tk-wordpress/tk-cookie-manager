<?php
/**
 * @var array $fields
 */
TimonKreis\CookieManager\TemplateLoader::load(
	'admin/settings/section',
	[
		'introduction' => __('Configuration of cookies, bundled in groups.', 'tk_cookie_manager'),
		'fields' => $fields,
	]
);
