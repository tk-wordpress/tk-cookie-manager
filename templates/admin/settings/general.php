<?php
/**
 * @var array $fields
 */
TimonKreis\CookieManager\TemplateLoader::load(
	'admin/settings/section',
	[
		'introduction' => __('General settings.', 'tk_cookie_manager'),
		'fields' => $fields,
	]
);
