<?php
/**
 * @var bool $disableCookieInfobox
 */
?>
<label for="tk-disable-cookie-infobox">
	<input<?php echo $disableCookieInfobox ? ' checked' : ''; ?>
			id="tk-disable-cookie-infobox"
			name="tk_disable_cookie_infobox"
			type="checkbox"
			value="1">
	<?php _e('Disable cookie infobox for this page', 'tk_cookie_manager'); ?>
</label>
