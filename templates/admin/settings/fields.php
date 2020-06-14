<?php
/**
 * @var array $fields
 * @var TimonKreis\CookieManager\Admin\Settings\Fields\AbstractField $field
 */
foreach ($fields as $field): ?>
	<div class="form-group row">
		<?php if ($field->getTitle()): ?>
			<?php if ($field->hasLabel()): ?>
				<label class="col-sm-2 col-form-label" for="tk-cookie-manager-form__<?php echo $field->getSlug(); ?>">
					<?php echo $field->getTitle(); ?>:
				</label>
			<?php else: ?>
				<div class="col-sm-2 pt-2">
					<?php echo $field->getTitle(); ?>:
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="col-sm-10">
			<?php $field->renderField(); ?>
		</div>
	</div>
<?php endforeach;
