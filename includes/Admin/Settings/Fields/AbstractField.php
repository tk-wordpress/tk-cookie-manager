<?php
namespace TimonKreis\CookieManager\Admin\Settings\Fields;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
abstract class AbstractField
{
	/**
	 * @var bool
	 */
	protected $hasLabel = true;

	/**
	 * @var string
	 */
	protected $slug;

	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * @var mixed
	 */
	protected $option = null;

	/**
	 * @var mixed
	 */
	protected $default = null;

	/**
	 * Get the hasLabel flag.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function hasLabel() : bool
	{
		return $this->hasLabel;
	}

	/**
	 * Get the slug.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getSlug() : string
	{
		return $this->slug;
	}

	/**
	 * Get the title.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getTitle() : string
	{
		return $this->title;
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	abstract public function renderField() : void;

	/**
	 * Sanitize field.
	 * (May be overwritten in child classes.)
	 *
	 * @param mixed $value
	 * @return mixed
	 * @since 1.0.0
	 */
	public function sanitizeField($value)
	{
		return $value;
	}

	/**
	 * Get template variables.
	 *
	 * @param array $variables
	 * @return array
	 * @since 1.0.0
	 */
	protected function getTemplateVariables(array $variables = []) : array
	{
		$defaultVariables = [
			'slug' => $this->getSlug(),
			'title' => $this->getTitle(),
		];

		return array_merge($defaultVariables, $variables);
	}

	/**
	 * Set the option.
	 *
	 * @param string $tab
	 * @param mixed $default
	 * @since 1.0.0
	 */
	protected function setOption(string $tab, $default = null) : void
	{
		$this->option = get_option('tk_cookie_manager')[$tab][$this->slug] ?? $default;
	}
}
