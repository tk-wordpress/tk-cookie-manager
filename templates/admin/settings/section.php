<?php
/**
 * @var string $introduction
 * @var array $fields
 */
?>
<div class="card">
	<div class="card-body">
		<p><?php echo $introduction; ?></p>
		<?php TimonKreis\CookieManager\TemplateLoader::load('admin/settings/fields', ['fields' => $fields]); ?>
	</div>
</div>
