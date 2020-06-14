<?php
/**
 * @var string $slug
 * @var string $title
 * @var array $pages
 * @var array $value
 */
?>
<select aria-label="<?php echo $title; ?>"
		class="form-control"
		data-toggle-container="#tk-cookie-manager-form__<?php echo $slug; ?>__individual-url-container"
		data-toggle-values="url"
		id="tk-cookie-manager-form__<?php echo $slug; ?>"
		name="tk_cookie_manager[general][<?php echo $slug; ?>][page]">
	<option value="0"<?php echo !$value['page'] ? ' selected' : ''; ?>>
		- <?php _e('Not set', 'tk_cookie_manager'); ?> -
	</option>
	<option value="wp"<?php echo $value['page'] == 'wp' ? ' selected' : ''; ?>>
		<?php _e('Synchronize with WordPress', 'tk_cookie_manager'); ?>
	</option>
	<option value="url"<?php echo $value['page'] == 'url' ? ' selected' : ''; ?>>
		<?php _e('Individual URL', 'tk_cookie_manager'); ?>
	</option>
	<optgroup label="<?php _e('Pages', 'tk_cookie_manager'); ?>">
		<?php foreach ($pages as $page): ?>
			<option<?php echo $page->ID == $value['page'] ? ' selected' : ''; ?> value="<?php echo $page->ID; ?>">
				<?php echo $page->post_title; ?>
			</option>
		<?php endforeach; ?>
	</optgroup>
</select>
<div class="row"
		id="tk-cookie-manager-form__<?php echo $slug; ?>__individual-url-container"
		<?php echo $value['page'] != 'url' ? ' style="display:none"' : ''; ?>>
	<div class="col-lg-6">
		<div class="input-group mt-1">
			<div class="input-group-prepend">
				<div class="input-group-text">
					<?php _e('Label', 'tk_cookie_manager'); ?>:
				</div>
			</div>
			<input aria-label="<?php _e('Label', 'tk_cookie_manager'); ?>"
					class="form-control"
					id="tk-cookie-manager-form__<?php echo $slug; ?>__label"
					name="tk_cookie_manager[general][<?php echo $slug; ?>][label]"
					placeholder="www.example.com"
					required
					value="<?php echo $value['label']; ?>">
		</div>
	</div>
	<div class="col-lg-6">
		<div class="input-group mt-1">
			<div class="input-group-prepend">
				<div class="input-group-text">
					<?php _e('URL', 'tk_cookie_manager'); ?>:
				</div>
			</div>
			<input aria-label="<?php _e('URL', 'tk_cookie_manager'); ?>"
					class="form-control"
					id="tk-cookie-manager-form__<?php echo $slug; ?>__url"
					name="tk_cookie_manager[general][<?php echo $slug; ?>][url]"
					placeholder="https://www.example.com/"
					required
					type="url"
					value="<?php echo $value['url']; ?>">
		</div>
	</div>
</div>
