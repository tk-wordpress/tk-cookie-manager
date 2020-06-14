# Cookie Manager
Inform visitors about used cookies and block scripts until consent is given.
In addition, block automatically embedded external contents until visitor accepts the platform.

## Features
* Block scripts of cookies if their cookie group is not accepted.
* Block embedding external contents if the platform is not accepted.
* Two different layouts for the cookie infobox (popup and banner).
* Two different skins for the cookie infobox (light and dark).
* Disable the cookie infobox for selected pages.
* Shortcode for a link to open the cookie infobox after closing.
* Shortcode for platforms list to configure allowed and disallowed platforms.
* Easy translations due to included *.pot file.
* Override templates with your own from your theme.

## Shortcodes
### Link to open cookie infobox
Examples:
```
[tk-cookie-manager-infobox-opener]
[tk-cookie-manager-infobox-opener label="Link label"]
[tk-cookie-manager-infobox-opener]Link Label[/tk-cookie-manager-infobox-opener]
```

Attributes:

| Attribute: | Description: |
| --- | --- |
| `label` _(optional)_ | Label for the link. (Can also be set via shortcode content.) |

### Platforms list to allow/disallow platform embeds
Examples:
```
[tk-cookie-manager-embedded-contents-table]
[tk-cookie-manager-embedded-contents-table platforms="twitter,youtube"]
```

Attributes:

| Attribute: | Description: |
| --- | --- |
| `platforms` _(optional)_ | Comma-separated list of platforms to filter. If this attribute is given, only these platforms will be listed. |

List of available platforms:
* `amazon-kindle`
* `animoto`
* `cloudup`
* `crowdsignal`
* `dailymotion`
* `facebook`
* `flickr`
* `hulu`
* `imgur`
* `instagram`
* `issuu`
* `kickstarter`
* `meetup-com`
* `mixcloud`
* `reddit`
* `reverbnation`
* `screencast`
* `scribd`
* `slideshare`
* `smugmug`
* `soundcloud`
* `speaker-deck`
* `spotify`
* `ted`
* `tiktok`
* `tumblr`
* `twitter`
* `videopress`
* `vimeo`
* `wordpress-tv`
* `youtube`

## Override templates
To override templates, you can either...
* hook into filter `tk_cookie_manager_template_paths` and add your desired path, or...
* copy the templates you want to override into your themes folder under `your-theme/tk-cookie-manager/` and modify them to your needs. The folder hierarchy to the templates must match the original hierarchy.

## Hooks
### Actions

| Name: | Description: |
| --- | --- |
| `tk_cookie_manager_load_template` | Fires before a template is loaded. |

### Filters

| Name: | Description: |
| --- | --- |
| `tk_cookie_manager/admin/settings/infobox/layouts` | Fires before the possible layouts are applied to the template. |
| `tk_cookie_manager/admin/editor_plugins` | Fires before applying editor plugins to settings page. |
| `tk_cookie_manager/admin/editor_toolbar1` | Fires before applying toolbar 1 elements to settings page. |
| `tk_cookie_manager/admin/editor_toolbar2` | Fires before applying toolbar 2 elements to settings page. |
| `tk_cookie_manager/admin/editor_quicktags` | Fires before applying quicktags flag to settings page. |
| `tk_cookie_manager/admin/editor_mediabuttons` | Fires before applying media buttons flag to settings page. |
| `tk_cookie_manager/admin/settings/tabs` | Fires before applying available tabs to options page. |
| `tk_cookie_manager/admin/settings/current_tab` | Fires before applying current tab to options page. |
| `tk_cookie_manager/admin/settings/fields` | Fires when the fields for the current tab are required. Returns an array of class names in order of appearance. The classes must extend `TimonKreis\CookieManager\Admin\Settings\Fields\AbstractField`. |
| `tk_cookie_manager/admin/settings/infobox/skins` | Fires before the possible skins are applied to the template. |
| `tk_cookie_manager/general/css` | Fires before applying custom CSS to frontend. |
| `tk_cookie_manager/embedded_contents/privacy_policy_link` | Fires before applying value of privacy policy link to the embedded container. |
| `tk_cookie_manager/infobox/layout` | Fires before applying layout to the infobox. |
| `tk_cookie_manager/infobox/skin` | Fires before applying skin to the infobox. |
| `tk_cookie_manager/infobox/headline` | Fires before applying headline to the infobox. |
| `tk_cookie_manager/infobox/description` | Fires before applying description to the infobox. |
| `tk_cookie_manager/infobox/cookie_groups` | Fires before applying cookie groups to the infobox. |
| `tk_cookie_manager/infobox/privacy_policy_link` | Fires before applying value of privacy policy link to the infobox. |
| `tk_cookie_manager/infobox/imprint_link` | Fires before applying value of imprint link to the infobox. |
| `tk_cookie_manager/infobox/footer_links` | Fires before applying footer links to the infobox. |
| `tk_cookie_manager/infobox/version` | Fires before applying version to the infobox. |
| `tk_cookie_manager/infobox/cookie_html` | Fires before applying cookie group HTML to the infobox. |
| `tk_cookie_manager/platforms` | Fires before returning available platforms. |
| `tk_cookie_manager/shortcode/infobox_opener/label` | Fires before applying infobox opener label to the link. |
| `tk_cookie_manager/shortcode/embedded_contents_table/platforms` | Fires before applying platforms to embedded contents table. |
| `tk_cookie_manager_template_variables` | Fires before the variables are applied to the template. |
| `tk_cookie_manager_template_paths` | Fires before the template is searched in the paths. |
