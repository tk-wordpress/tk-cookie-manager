<?php
defined('WP_UNINSTALL_PLUGIN') || die;

delete_option('tk_cookie_manager');

if (is_multisite()) {
	delete_site_option('tk_cookie_manager');
}
