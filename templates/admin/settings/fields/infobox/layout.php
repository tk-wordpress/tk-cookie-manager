<?php
/**
 * @var string $slug
 * @var string $title
 * @var array $layouts
 * @var string $currentLayout
 */
?>
<select aria-label="<?php echo $title; ?>"
		class="form-control"
		id="tk-cookie-manager-form__<?php echo $slug; ?>"
		name="tk_cookie_manager[infobox][<?php echo $slug; ?>]">
	<?php foreach ($layouts as $value => $label): ?>
		<option<?php echo $value == $currentLayout ? ' selected' : ''; ?> value="<?php echo $value; ?>">
			<?php echo $label; ?>
		</option>
	<?php endforeach; ?>
</select>
