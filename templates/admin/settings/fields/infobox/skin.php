<?php
/**
 * @var string $slug
 * @var string $title
 * @var array $skins
 * @var string $currentSkin
 */
?>
<select aria-label="<?php echo $title; ?>"
		class="form-control"
		id="tk-cookie-manager-form__<?php echo $slug; ?>"
		name="tk_cookie_manager[infobox][<?php echo $slug; ?>]">
	<?php foreach ($skins as $value => $label): ?>
		<option<?php echo $value == $currentSkin ? ' selected' : ''; ?> value="<?php echo $value; ?>">
			<?php echo $label; ?>
		</option>
	<?php endforeach; ?>
</select>
