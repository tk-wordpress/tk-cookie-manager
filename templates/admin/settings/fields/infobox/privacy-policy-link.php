<?php
/**
 * @var string $slug
 * @var string $title
 * @var bool $privacyPolicyLink
 */
?>
<div class="custom-control custom-checkbox pt-2">
	<input<?php echo $privacyPolicyLink ? ' checked' : ''; ?>
			class="custom-control-input"
			id="tk-cookie-manager-form__<?php echo $slug; ?>"
			name="tk_cookie_manager[infobox][<?php echo $slug; ?>]"
			type="checkbox">
	<label class="custom-control-label" for="tk-cookie-manager-form__<?php echo $slug; ?>">
		<?php _e('Add a link to the privacy policy page at the bottom of the infobox.', 'tk_cookie_manager'); ?>
	</label>
</div>
