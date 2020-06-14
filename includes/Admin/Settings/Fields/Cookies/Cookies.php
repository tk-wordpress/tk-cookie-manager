<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields\Cookies;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Cookies extends CookieManager\Admin\Settings\Fields\AbstractField
{
	/**
	 * Set slug, title (and default value).
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->hasLabel = false;
		$this->slug = 'cookies';
		$this->title = __('Cookies', 'tk_cookie_manager');
		$this->default = [];

		$this->setOption('cookies');
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function renderField() : void
	{
		$cookieGroups = $this->option['cookieGroups'] ?? $this->default;
		$cookieGroups = json_encode($cookieGroups, JSON_UNESCAPED_UNICODE);

		CookieManager\TemplateLoader::load(
			'admin/settings/fields/cookies/cookies',
			$this->getTemplateVariables([
				'cookieGroups' => $cookieGroups,
				'increment' => $this->option['increment'] ?? 0,
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
		if ($value === null) {
			$value = [];
		}

		$value['increment'] = (int)($value['increment'] ?? 0);

		if (isset($value['cookieGroups']) && is_array($value['cookieGroups'])) {
			$value['cookieGroups'] = array_values($value['cookieGroups']);

			foreach ($value['cookieGroups'] as &$cookieGroup) {
				if (!isset($cookieGroup['cookies'])) {
					$cookieGroup['cookies'] = [];
				}

				$cookieGroup['active'] = isset($cookieGroup['active']);
				$cookieGroup['required'] = isset($cookieGroup['required']);
				$cookieGroup['name'] = trim($cookieGroup['name']);
				$cookieGroup['description'] = trim($cookieGroup['description']);
				$cookieGroup['cookies'] = array_values($cookieGroup['cookies']);

				foreach ($cookieGroup['cookies'] as &$cookie) {
					$cookie['active'] = isset($cookie['active']);
					$cookie['name'] = trim($cookie['name']);
					$cookie['provider'] = trim($cookie['provider']);
					$cookie['providerUrl'] = trim($cookie['providerUrl']);
					$cookie['lifetime'] = trim($cookie['lifetime']);
					$cookie['cookieNames'] = implode(', ', array_map('trim', explode(',', $cookie['cookieNames'])));
					$cookie['description'] = trim($cookie['description']);
					$cookie['html'] = trim($cookie['html']);
				}
			}
		}

		return $value;
	}
}
