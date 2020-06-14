<?php
/**
 * @var array $cookieGroups
 */
if (!$cookieGroups) {
	return;
}
?>
<ul class="tk-cookie-manager-infobox__cookie-groups">
	<?php foreach ($cookieGroups as $cookieGroup): ?>
		<li>
			<label class="tk-cookie-manager-infobox__checkbox">
				<input<?php echo $cookieGroup['required'] ? ' checked disabled required' : ''; ?>
						name="cookieGroups[]"
						type="checkbox"
						value="<?php echo $cookieGroup['id']; ?>">
				<span class="tk-cookie-manager-infobox__checkmark"></span>
				<?php echo $cookieGroup['name']; ?>

				<?php if ($cookieGroup['cookies']): ?>
					<span class="tk-cookie-manager-infobox__cookie-counter">
						(<?php echo count($cookieGroup['cookies']); ?>)
					</span>
				<?php endif; ?>
			</label>
			<div class="tk-cookie-manager-infobox__cookie-group-details">
				<div class="tk-cookie-manager-infobox__cookie-group-description">
					<?php echo $cookieGroup['description']; ?>
				</div>
				<?php if ($cookieGroup['cookies']): ?>
					<div class="tk-cookie-manager-infobox__cookies">
						<table>
							<thead>
							<tr>
								<th><?php _e('Name', 'tk_cookie_consent'); ?>:</th>
								<th><?php _e('Provider', 'tk_cookie_consent'); ?>:</th>
								<th><?php _e('Description', 'tk_cookie_consent'); ?>:</th>
								<th><?php _e('Lifetime', 'tk_cookie_consent'); ?>:</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($cookieGroup['cookies'] as $cookie): ?>
								<tr>
									<td><?php echo $cookie['name']; ?></td>
									<td>
										<?php if ($cookie['provider']): ?>
											<?php if ($cookie['providerUrl'] ?? ''): ?>
												<a href="<?php echo $cookie['providerUrl']; ?>" target="_blank">
													<?php echo $cookie['provider']; ?>
												</a>
											<?php else: ?>
												<?php echo $cookie['provider']; ?>
											<?php endif; ?>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
									<td><?php echo $cookie['description'] ? $cookie['description'] : '-'; ?></td>
									<td><?php echo $cookie['lifetime'] ? $cookie['lifetime'] : '-'; ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
