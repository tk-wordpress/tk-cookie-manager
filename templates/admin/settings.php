<?php
/**
 * @var array $tabs
 * @var string $activeTab
 * @var string $config
 * @var string $editorPlugins
 * @var string $editorToolbar1
 * @var string $editorToolbar2
 * @var bool $editorQuicktags
 * @var bool $editorMediaButtons
 */
?>
<script>
	var TkCookieManagerConfig = {
		editor: {
			plugins: '<?php echo $editorPlugins; ?>',
			toolbar1: '<?php echo $editorToolbar1; ?>',
			toolbar2: '<?php echo $editorToolbar2; ?>',
			quicktags: <?php echo $editorQuicktags ? 'true' : 'false'; ?>,
			mediaButtons: <?php echo $editorMediaButtons ? 'true' : 'false'; ?>
		},
		cookieGroups: []
	};
</script>

<div class="wrap">
	<form action="options.php" id="tk-cookie-manager-form" method="post" novalidate>
		<nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
			<span class="navbar-brand">
				<?php _e('Cookie Manager', 'tk_cookie_manager'); ?>
			</span>
			<div>
				<ul class="navbar-nav mr-auto">
					<?php foreach ($tabs as $tab => $label): ?>
						<li class="nav-item<?php echo $tab == $activeTab ? ' active' : ''; ?>">
							<a class="nav-link" href="?page=tk-cookie-manager&tab=<?php echo $tab; ?>">
								<?php _e($label, 'tk_cookie_manager'); ?>
								<?php if ($tab == $activeTab): ?>
									<span class="sr-only">('<?php _e('current', 'tk_cookie_manager'); ?>)</span>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="ml-auto">
				<?php submit_button(null, 'primary', 'submit', false); ?>
			</div>
		</nav>
		<div class="notice notice-error inline py-2 mb-2" id="invalid-form">
			<?php _e('Form cannot be submitted. Please correct invalid fields first.', 'tk_cookie_manager'); ?>
		</div>
		<?php
		settings_fields('tk_cookie_manager');
		do_settings_sections('tk_cookie_manager');
		?>
		<nav class="navbar navbar-expand-lg navbar-light bg-white mt-2">
			<div class="ml-auto">
				<?php submit_button(null, 'primary', 'submit', false, ['id' => '']); ?>
			</div>
		</nav>
		<input name="tab" type="hidden" value="<?php echo $activeTab; ?>">
	</form>
</div>
