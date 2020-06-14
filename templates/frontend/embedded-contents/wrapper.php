<?php
/**
 * @var string $idSuffix
 * @var string $json
 * @var string $platformKey
 * @var string $platform
 * @var string $privacyPolicyUrl
 */
?>
<script id="tk-cookie-manager-embed-content<?php echo $idSuffix; ?>" type="application/json"><?php echo $json; ?></script>
<div class="tk-cookie-manager-embed-spoiler"
		data-id="tk-cookie-manager-embed-content<?php echo $idSuffix; ?>"
		data-platform="<?php echo $platformKey; ?>"
		role="button">
	<div class="tk-cookie-manager-embed-spoiler__inner">
		<?php printf(__('Click here to accept content from %s.', 'tk_cookie_manager'), $platform); ?>
	</div>
	<?php if ($privacyPolicyUrl): ?>
		<div class="tk-cookie-manager-embed-spoiler__footer">
			<?php printf(__('Please note our <a href="%s">Privacy Policy</a>.', 'tk_cookie_manager'), $privacyPolicyUrl); ?>
		</div>
	<?php endif; ?>
</div>
