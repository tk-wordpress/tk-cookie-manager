<?php
/**
 * @var string $slug
 * @var string $title
 * @var string $css
 */
?>
<textarea aria-label="<?php echo $title; ?>"
		data-editor="css"
		id="tk-cookie-manager-form__general__css"
		name="tk_cookie_manager[general][<?php echo $slug; ?>]"><?php echo $css; ?></textarea>
<small class="form-text text-muted">
	<?php _e('The CSS is added to the head on every page in the frontend.', 'tk_cookie_manager'); ?>
</small>
