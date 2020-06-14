<?php
/**
 * @var array $platforms
 * @var array $availablePlatforms
 */
if ($platforms): ?>
	<table class="tk-cookie-manager-embedded-contents-table">
		<thead>
		<tr>
			<th colspan="2"><?php _e('Platform', 'tk_cookie_manager'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($availablePlatforms as $platformKey => $platform): ?>
			<tr>
				<td>
					<label for="tk-cookie-manager-embedded-contents-table__<?php echo $platformKey; ?>">
						<?php echo $platform; ?>
					</label>
				</td>
				<td>
					<input id="tk-cookie-manager-embedded-contents-table__<?php echo $platformKey; ?>"
							name="platforms[]"
							type="checkbox"
							value="<?php echo $platformKey; ?>">
					<label for="tk-cookie-manager-embedded-contents-table__<?php echo $platformKey; ?>"></label>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
