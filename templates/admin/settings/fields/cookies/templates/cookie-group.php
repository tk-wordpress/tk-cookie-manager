<?php
/**
 *
 */
$idPrefix = 'tk-cookie-manager-form__cookies__cookie-group-#groupId#__';
$namePrefix = 'tk_cookie_manager[cookies][cookies][cookieGroups][#groupId#]';
?>
<li class="ui-state--default"
		data-cookie-group-id="#groupId#"
		data-cookie-increment="1"
		id="<?php echo substr($idPrefix, 0, -2); ?>">
	<input name="<?php echo $namePrefix; ?>[id]" type="hidden" value="#groupId#">
	<div class="item-header">
		<span class="dashicons dashicons-menu sort-handle"></span>
		<span class="title" data-target="title">#name#</span>
		<span class="badge badge-pill badge-secondary ml-2" data-cookies>0</span>
		<div class="actions-holder">
			<a class="dashicons dashicons-trash"
					data-action="delete"
					href="javascript:"
					title="<?php _e('Delete', 'tk_cookie_manager'); ?>"></a>
		</div>
	</div>
	<div class="item-body" data-editors="description">
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>active">
				<?php _e('Is active', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10 pt-2">
				<div class="custom-control custom-checkbox">
					<input #active#
							class="custom-control-input"
							id="<?php echo $idPrefix; ?>active"
							name="<?php echo $namePrefix; ?>[active]"
							type="checkbox">
					<label class="custom-control-label" for="<?php echo $idPrefix; ?>active">
						<?php _e('If not active, the cookie group is not displayed.', 'tk_cookie_manager'); ?>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>required">
				<?php _e('Is required', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10 pt-2">
				<div class="custom-control custom-checkbox">
					<input #required#
							class="custom-control-input"
							id="<?php echo $idPrefix; ?>required"
							name="<?php echo $namePrefix; ?>[required]"
							type="checkbox">
					<label class="custom-control-label" for="<?php echo $idPrefix; ?>required">
						<?php _e('If true, the cookie group cannot be disabled by the visitor.', 'tk_cookie_manager'); ?>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>name">
				<?php _e('Name', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10">
				<input class="form-control"
						data-trigger="cookie-group-title"
						id="<?php echo $idPrefix; ?>name"
						name="<?php echo $namePrefix; ?>[name]"
						required
						value="#name#">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm pt-3">
				<?php _e('Description', 'tk_cookie_manager'); ?>:
			</div>
			<div class="col-sm-10">
                <textarea aria-label="<?php _e('Description', 'tk_cookie_manager'); ?>"
						data-editor="wysiwyg"
						id="<?php echo $idPrefix; ?>description"
						name="<?php echo $namePrefix; ?>[description]">#description#</textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm pt-3"><?php _e('Cookies', 'tk_cookie_manager'); ?>:</div>
			<div class="col-sm-10">
				<div class="notice notice-info inline">
					<p><?php _e('No cookies defined so far.', 'tk_cookie_manager'); ?></p>
				</div>
				<ul class="tk-cookie-manager__list-groups" data-target="cookie-container"></ul>
				<div class="button-holder">
					<button class="button" data-action="add-cookie" type="button">
						<?php _e('Add new cookie', 'tk_cookie_manager'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</li>
