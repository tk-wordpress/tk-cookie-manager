<?php
/**
 * @var string $slug
 * @var string $title
 * @var string $cookieGroups
 * @var int $increment
 */
?>
<div class="notice notice-info inline">
	<p><?php _e('No cookie groups defined so far.', 'tk_cookie_manager'); ?></p>
</div>
<ul class="tk-cookie-manager__list-groups" data-target="cookie-group-container"></ul>

<input name="tk_cookie_manager[cookies][cookies][increment]" type="hidden" value="<?php echo $increment; ?>">

<div class="button-holder">
	<button class="button" data-action="add-cookie-group" type="button">
		<?php _e('Add new cookie group', 'tk_cookie_manager'); ?>
	</button>
</div>

<div data-template-container>
	<div id="tk-cookie-manager-templates__cookies__cookie-group">
		<?php TimonKreis\CookieManager\TemplateLoader::load('admin/settings/fields/cookies/templates/cookie-group'); ?>
	</div>
	<div id="tk-cookie-manager-templates__cookies__cookie">
		<?php TimonKreis\CookieManager\TemplateLoader::load('admin/settings/fields/cookies/templates/cookie'); ?>
	</div>
</div>

<script>
	TkCookieManagerConfig.cookieGroups = <?php echo $cookieGroups; ?>;
</script>
