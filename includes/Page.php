<?php
namespace TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Page
{
	/**
	 * Register actions and filters.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		if (is_admin()) {
			add_action('add_meta_boxes', [$this, 'addMetaBoxes']);
			add_action('save_post_page', [$this, 'savePostPage']);
		} else {
			add_filter('body_class', [$this, 'bodyClass']);
		}
	}

	/**
	 * Add meta boxes for page sidebar.
	 *
	 * @since 1.0.0
	 */
	public function addMetaBoxes() : void
	{
		add_meta_box(
			'tk_cookie_manager_disable_cookie_infobox',
			__('Cookie Manager', 'tk_cookie_manager'),
			function() : void {
				global $post;

				TemplateLoader::load(
					'admin/page/metabox',
					[
						'disableCookieInfobox' => (bool)get_post_meta($post->ID, 'tk_disable_cookie_infobox', true),
					]
				);
			},
			'page',
			'side'
		);
	}

	/**
	 * Save state of checkbox on page save.
	 *
	 * @param int $postId
	 * @since 1.0.0
	 */
	public function savePostPage(int $postId) : void
	{
		if (isset($_POST['tk_disable_cookie_infobox'])) {
			update_post_meta($postId, 'tk_disable_cookie_infobox', true);
		} else {
			delete_post_meta($postId, 'tk_disable_cookie_infobox');
		}
	}

	/**
	 * Modify body classes, if cookie infobox should be disabled.
	 *
	 * @global \WP_Post $post
	 * @param string[] $classes
	 * @return string[]
	 * @since 1.0.0
	 */
	public function bodyClass(array $classes) : array
	{
		global $post;

		if (is_page() && get_post_meta($post->ID, 'tk_disable_cookie_infobox', true)) {
			$classes[] = 'tk-disable-cookie-infobox';
		}

		return $classes;
	}
}
