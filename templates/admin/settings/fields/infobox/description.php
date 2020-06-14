<?php
/**
 * @var string $slug
 * @var string $title
 * @var string $description
 */
?>
<textarea aria-label="<?php echo $title; ?>"
		data-editor="wysiwyg"
		id="tk-cookie-manager-form__infobox__description"
		name="tk_cookie_manager[infobox][<?php echo $slug; ?>]"><?php echo $description; ?></textarea>
