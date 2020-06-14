<?php
namespace TimonKreis\CookieManager\Admin;

use TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Settings
{
	/**
	 * Add required actions.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_action('admin_enqueue_scripts', [$this, 'adminEnqueueScripts']);
		add_action('admin_menu', [$this, 'adminMenu']);
		add_action('admin_init', [$this, 'adminInit']);
	}

	/**
	 * Add necessary stylesheets and javascripts.
	 *
	 * @param string $hook
	 * @since 1.0.0
	 */
	public function adminEnqueueScripts(string $hook) : void
	{
		// Add Stylesheet and JavaScript to the settings page only.
		if ($hook == 'settings_page_tk-cookie-manager') {
			wp_enqueue_style('tk_cookie_manager_css',
				plugin_dir_url(CookieManager::FILE) . 'public/css/admin.css',
				[],
				CookieManager::VERSION
			);

			wp_enqueue_script('tk_cookie_manager_js',
				plugin_dir_url(CookieManager::FILE) . 'public/js/admin.min.js',
				['jquery', 'jquery-ui-core', 'jquery-ui-sortable'],
				CookieManager::VERSION,
				true
			);

			// Load assets for WYSIWYG editor.
			wp_enqueue_editor();

			// Load assets for code editor.
			wp_enqueue_code_editor(['type' => 'text/html']);
		}
	}

	/**
	 * Add options page.
	 *
	 * @since 1.0.0
	 */
	public function adminMenu() : void
	{
		add_options_page(
			__('Cookie Manager', 'tk_cookie_manager'),
			__('Cookie Manager', 'tk_cookie_manager'),
			'manage_options',
			'tk-cookie-manager',
			function() : void {
				/**
				 * Fires before applying editor plugins to settings page.
				 *
				 * @see https://www.tiny.cloud/docs/configure/integration-and-setup/#plugins
				 * @since 1.0.0
				 */
				$editorPlugins = apply_filters(
					'tk_cookie_manager/admin/editor_plugins',
					[
						'compat3x',
						'link',
						'lists',
						'tabfocus',
						'wordpress',
						'wpautoresize',
						'wplink',
						'wptextpattern',
						'wpview',
					]
				);

				/**
				 * Fires before applying toolbar 1 elements to settings page.
				 *
				 * @see https://www.tiny.cloud/docs/advanced/editor-control-identifiers/#toolbarcontrols
				 * @since 1.0.0
				 */
				$editorToolbar1 = apply_filters(
					'tk_cookie_manager/admin/editor_toolbar1',
					[
						'formatselect',
						'bold',
						'italic',
						'underline',
						'|',
						'bullist',
						'numlist',
						'|',
						'alignleft',
						'aligncenter',
						'alignright',
						'alignjustify',
						'|',
						'link',
						'unlink',
					]
				);

				/**
				 * Fires before applying toolbar 2 elements to settings page.
				 *
				 * @see https://www.tiny.cloud/docs/advanced/editor-control-identifiers/#toolbarcontrols
				 * @since 1.0.0
				 */
				$editorToolbar2 = apply_filters('tk_cookie_manager/admin/editor_toolbar2', []);

				/**
				 * Fires before applying quicktags flag to settings page.
				 *
				 * @since 1.0.0
				 */
				$editorQuicktags = apply_filters('tk_cookie_manager/admin/editor_quicktags', false);

				/**
				 * Fires before applying media buttons flag to settings page.
				 *
				 * @since 1.0.0
				 */
				$editorMediaButtons = apply_filters('tk_cookie_manager/admin/editor_mediabuttons', false);

				CookieManager\TemplateLoader::load(
					'admin/settings',
					[
						'tabs' => $this->getTabs(),
						'activeTab' => $this->getCurrentTab(),
						'editorPlugins' => implode(' ', $editorPlugins),
						'editorToolbar1' => implode(' ', $editorToolbar1),
						'editorToolbar2' => implode(' ', $editorToolbar2),
						'editorQuicktags' => $editorQuicktags,
						'editorMediaButtons' => $editorMediaButtons,
					]
				);
			}
		);
	}

	/**
	 * Register settings section and fields.
	 *
	 * @since 1.0.0
	 */
	public function adminInit() : void
	{
		register_setting(
			'tk_cookie_manager',
			'tk_cookie_manager',
			[
				'type' => 'array',
				'sanitize_callback' => function(array $value) : array {
					$originalValue = (array)get_option('tk_cookie_manager', []);
					$tab = (string)($_POST['tab'] ?? '');

					if (!$tab || !isset($this->getTabs()[$tab])) {
						add_settings_error('tk_cookie_manager', '', __('Invalid data submitted!', 'tk_cookie_manager'));

						return $originalValue;
					}

					$value = array_merge($originalValue, $value);

					// Filter invalid array keys to cleanup outdated settings.
					$value = array_filter(
						$value,
						function(string $key) : bool {
							return isset($this->getTabs()[$key]);
						},
						ARRAY_FILTER_USE_KEY
					);

					foreach ($this->getFields($tab) as $field) {
						$value[$tab][$field->getSlug()]
							= $field->sanitizeField($value[$tab][$field->getSlug()] ?? null);
					}

					return $value;
				},
			]
		);

		add_settings_section(
			'tk_cookie_manager',
			'',
			function() : void {
				$fields = [];

				foreach ($this->getFields($this->getCurrentTab()) as $field) {
					$fields[] = $field;
				}

				CookieManager\TemplateLoader::load('admin/settings/' . $this->getCurrentTab(), [
					'fields' => $fields,
				]);
			},
			'tk_cookie_manager'
		);
	}

	/**
	 * Get the available tabs.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	protected function getTabs() : array
	{
		static $tabs = null;

		if ($tabs === null) {
			$tabs = [
				'general' => __('General', 'tk_cookie_manager'),
				'infobox' => __('Cookie Infobox', 'tk_cookie_manager'),
				'cookies' => __('Cookie Groups & Cookies', 'tk_cookie_manager'),
				'embedded-contents' => __('Embedded Contents', 'tk_cookie_manager'),
			];

			/**
			 * Fires before applying available tabs to options page.
			 *
			 * @since 1.0.0
			 */
			$tabs = apply_filters('tk_cookie_manager/admin/settings/tabs', $tabs);
		}

		return $tabs;
	}

	/**
	 * Get the current tab.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	protected function getCurrentTab() : string
	{
		static $tab = null;

		if ($tab === null) {
			$tab = isset($_GET['tab'], $this->getTabs()[$_GET['tab']]) ? $_GET['tab'] : array_keys($this->getTabs())[0];

			/**
			 * Fires before applying current tab to options page.
			 *
			 * @since 1.0.0
			 */
			$tab = apply_filters('tk_cookie_manager/admin/settings/current_tab', $tab);
		}

		return $tab;
	}

	/**
	 * Get the fields instances for the tab.
	 *
	 * @param string $tab
	 * @return Settings\Fields\AbstractField[]
	 * @since 1.0.0
	 */
	protected function getFields(string $tab) : array
	{
		$fieldInstances = [];
		$defaultFields = [
			'general' => [
				Settings\Fields\General\PrivacyPolicyPage::class,
				Settings\Fields\General\ImprintPage::class,
				Settings\Fields\General\Css::class,
			],
			'infobox' => [
				Settings\Fields\Infobox\Layout::class,
				Settings\Fields\Infobox\Skin::class,
				Settings\Fields\Infobox\Active::class,
				Settings\Fields\Infobox\PrivacyPolicyLink::class,
				Settings\Fields\Infobox\ImprintLink::class,
				Settings\Fields\Infobox\Headline::class,
				Settings\Fields\Infobox\Description::class,
			],
			'cookies' => [
				Settings\Fields\Cookies\Cookies::class,
			],
			'embedded-contents' => [
				Settings\Fields\EmbeddedContents\AmazonKindle::class,
				Settings\Fields\EmbeddedContents\Animoto::class,
				Settings\Fields\EmbeddedContents\Cloudup::class,
				Settings\Fields\EmbeddedContents\Crowdsignal::class,
				Settings\Fields\EmbeddedContents\Dailymotion::class,
				Settings\Fields\EmbeddedContents\Facebook::class,
				Settings\Fields\EmbeddedContents\Flickr::class,
				Settings\Fields\EmbeddedContents\Hulu::class,
				Settings\Fields\EmbeddedContents\Imgur::class,
				Settings\Fields\EmbeddedContents\Instagram::class,
				Settings\Fields\EmbeddedContents\Issuu::class,
				Settings\Fields\EmbeddedContents\Kickstarter::class,
				Settings\Fields\EmbeddedContents\Meetupcom::class,
				Settings\Fields\EmbeddedContents\Mixcloud::class,
				Settings\Fields\EmbeddedContents\Reddit::class,
				Settings\Fields\EmbeddedContents\ReverbNation::class,
				Settings\Fields\EmbeddedContents\Screencast::class,
				Settings\Fields\EmbeddedContents\Scribd::class,
				Settings\Fields\EmbeddedContents\Slideshare::class,
				Settings\Fields\EmbeddedContents\SmugMug::class,
				Settings\Fields\EmbeddedContents\SoundCloud::class,
				Settings\Fields\EmbeddedContents\SpeakerDeck::class,
				Settings\Fields\EmbeddedContents\Spotify::class,
				Settings\Fields\EmbeddedContents\TED::class,
				Settings\Fields\EmbeddedContents\TikTok::class,
				Settings\Fields\EmbeddedContents\Tumblr::class,
				Settings\Fields\EmbeddedContents\Twitter::class,
				Settings\Fields\EmbeddedContents\VideoPress::class,
				Settings\Fields\EmbeddedContents\Vimeo::class,
				Settings\Fields\EmbeddedContents\WordpressTV::class,
				Settings\Fields\EmbeddedContents\YouTube::class,
			],
		];

		/**
		 * Fires when the fields for the current tab are required.
		 * Returns an array of class names in order of appearance.
		 * The classes must extend TimonKreis\CookieManager\Admin\Settings\Fields\AbstractField.
		 *
		 * @since 1.0.0
		 */
		$fields = apply_filters('tk_cookie_manager/admin/settings/fields', $defaultFields[$tab] ?? [], $tab);

		foreach ($fields as $fieldClass) {
			if (class_exists($fieldClass)) {
				$fieldInstance = new $fieldClass();

				if ($fieldInstance instanceof Settings\Fields\AbstractField) {
					$fieldInstances[] = $fieldInstance;
				}
			}
		}

		return $fieldInstances;
	}
}
