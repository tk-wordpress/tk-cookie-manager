<?php
/**
 * @var string $iconUrl
 * @var string $donationUrl
 */
?>
<a href="<?php echo $donationUrl; ?>" target="_blank">
	<img alt="" src="<?php echo $iconUrl; ?>" style="margin-bottom: -2px">
	<?php _e('Buy me a beer', 'tk_cookie_manager'); ?>
</a><?php _e(', if you like this plugin.', 'tk_cookie_manager'); ?>
