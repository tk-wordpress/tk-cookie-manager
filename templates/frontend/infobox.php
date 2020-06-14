<?php
/**
 * @var string $layout
 * @var string $skin
 * @var string $headline
 * @var string $description
 * @var array $cookieGroups
 * @var array $footerLinks
 * @var string $version
 * @var string $cookiegroupsHtml
 */
use TimonKreis\CookieManager\TemplateLoader;
?>
<div class="tk-cookie-manager-infobox--layout-<?php echo $layout; ?> tk-cookie-manager-infobox--skin-<?php echo $skin; ?>"
		data-version="<?php echo $version; ?>"
		id="tk-cookie-manager-infobox">
	<div class="tk-cookie-manager-infobox__backdrop"></div>
	<div class="tk-cookie-manager-infobox__wrapper tk-cookie-manager-infobox__wrapper--state-simple">
		<form class="tk-cookie-manager-infobox__box" method="post">
			<div class="tk-cookie-manager-infobox__box-inner">
				<?php
				TemplateLoader::load('frontend/infobox/headline', ['headline' => $headline]);
				TemplateLoader::load('frontend/infobox/description', ['description' => $description]);
				TemplateLoader::load('frontend/infobox/cookie-groups', ['cookieGroups' => $cookieGroups]);
				TemplateLoader::load('frontend/infobox/buttons');
				TemplateLoader::load('frontend/infobox/footer-links', ['footerLinks' => $footerLinks]);
				?>
			</div>
		</form>
	</div>
</div>
<script id="tk-cookie-manager-cookiegroup-html" type="application/json"><?php echo $cookiegroupsHtml; ?></script>
