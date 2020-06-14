<?php
/**
 * @var string $slug
 * @var string $title
 * @var bool $active
 */
?>
<div class="custom-control custom-checkbox pt-2">
	<input<?php echo $active ? ' checked' : ''; ?>
			class="custom-control-input"
			id="tk-cookie-manager-form__<?php echo $slug; ?>"
			name="tk_cookie_manager[infobox][<?php echo $slug; ?>]"
			type="checkbox">
	<label class="custom-control-label" for="tk-cookie-manager-form__<?php echo $slug; ?>">
		<?php _e('If not active, the cookie infobox is not displayed.', 'tk_cookie_manager'); ?>
	</label>
</div>
