<?php
/**
 * @var string $slug
 * @var string $title
 * @var bool $block
 * @var bool $nocookie
 */
use TimonKreis\CookieManager;

CookieManager\TemplateLoader::load(
	'admin/settings/fields/embedded-contents/block-default',
	[
		'slug' => $slug,
		'title' => $title,
		'block' => $block,
	]
);
?>
<div class="custom-control custom-checkbox pt-2">
	<input<?php echo $nocookie ? ' checked' : ''; ?>
			class="custom-control-input"
			id="tk-cookie-manager-form__<?php echo $slug; ?>__nocookie"
			name="tk_cookie_manager[embedded-contents][<?php echo $slug; ?>][nocookie]"
			type="checkbox">
	<label class="custom-control-label" for="tk-cookie-manager-form__<?php echo $slug; ?>__nocookie">
		<?php
		printf(
			__('Replace %s with %s.', 'tk_cookie_manager'),
			'<em>www.youtube.com</em>',
			'<em>www.youtube-nocookie.com</em>'
		);
		?>
	</label>
</div>
