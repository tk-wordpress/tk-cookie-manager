<?php
/**
 *
 */
$idPrefix = 'tk-cookie-manager-form__cookies__cookie-group-#groupId#__cookie-#cookieId#__';
$namePrefix = 'tk_cookie_manager[cookies][cookies][cookieGroups][#groupId#][cookies][#cookieId#]';
?>
<li class="ui-state--default" data-cookie-id="#cookieId#" id="<?php echo substr($idPrefix, 0, -2); ?>">
	<div class="item-header">
		<span class="dashicons dashicons-menu sort-handle"></span>
		<span class="title" data-target="title">#name#</span>
		<div class="actions-holder">
			<a class="dashicons dashicons-trash"
					data-action="delete"
					href="javascript:"
					title="<?php _e('Delete', 'tk_cookie_manager'); ?>"></a>
		</div>
	</div>
	<div class="item-body" data-editors="description html">
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
						<?php _e('If not active, the HTML is not included.', 'tk_cookie_manager'); ?>
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
						data-trigger="cookie-title"
						id="<?php echo $idPrefix; ?>name"
						name="<?php echo $namePrefix; ?>[name]"
						required
						value="#name#">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>provider">
				<?php _e('Provider', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10">
				<input class="form-control"
						id="<?php echo $idPrefix; ?>provider"
						name="<?php echo $namePrefix; ?>[provider]"
						value="#provider#">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>provider-url">
				<?php _e('Provider URL', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10">
				<input class="form-control"
						id="<?php echo $idPrefix; ?>provider-url"
						name="<?php echo $namePrefix; ?>[providerUrl]"
						type="url"
						value="#providerUrl#">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>lifetime">
				<?php _e('Lifetime', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10">
				<input class="form-control"
						id="<?php echo $idPrefix; ?>lifetime"
						name="<?php echo $namePrefix; ?>[lifetime]"
						value="#lifetime#">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm col-form-label" for="<?php echo $idPrefix; ?>cookie-names">
				<?php _e('Cookie names', 'tk_cookie_manager'); ?>:
			</label>
			<div class="col-sm-10">
				<input class="form-control"
						id="<?php echo $idPrefix; ?>cookie-names"
						name="<?php echo $namePrefix; ?>[cookieNames]"
						value="#cookieNames#">
				<small class="form-text text-muted">
					<?php _e('Comma-separated list of cookie names.', 'tk_cookie_manager'); ?>
				</small>
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
			<div class="col-sm pt-3">
				<?php _e('HTML', 'tk_cookie_manager'); ?>:
			</div>
			<div class="col-sm-10">
                <textarea aria-label="<?php _e('HTML', 'tk_cookie_manager'); ?>"
						data-editor="text/html"
						id="<?php echo $idPrefix; ?>html"
						name="<?php echo $namePrefix; ?>[html]">#html#</textarea>
				<small class="form-text text-muted">
					<?php _e('Appended to the page when consent is given.', 'tk_cookie_manager'); ?>
				</small>
			</div>
		</div>
	</div>
</li>
