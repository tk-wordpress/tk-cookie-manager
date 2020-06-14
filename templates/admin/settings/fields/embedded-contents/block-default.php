<?php
/**
 * @var string $slug
 * @var string $title
 * @var bool $block
 */
?>
<div class="custom-control custom-checkbox pt-2">
	<input<?php echo $block ? ' checked' : ''; ?>
			class="custom-control-input"
			id="tk-cookie-manager-form__<?php echo $slug; ?>"
			name="tk_cookie_manager[embedded-contents][<?php echo $slug; ?>][block]"
			type="checkbox">
	<label class="custom-control-label" for="tk-cookie-manager-form__<?php echo $slug; ?>">
		<?php printf(__('Block contents from %s by default.', 'tk_cookie_manager'), $title); ?>
	</label>
</div>
