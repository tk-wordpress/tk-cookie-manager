<?php
/**
 * @var array $footerLinks
 */
if ($footerLinks): ?>
	<div class="tk-cookie-manager-infobox__footer-links">
		<ul>
			<?php foreach ($footerLinks as $footerLink): ?>
				<li>
					<a href="<?php echo $footerLink['url']; ?>"><?php echo $footerLink['label']; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif;
