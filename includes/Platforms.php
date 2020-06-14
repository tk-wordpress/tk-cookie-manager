<?php
namespace TimonKreis\CookieManager;

/**
 * @package tk-cookie-manager
 * @since 1.0.0
 */
class Platforms
{
	/**
	 * Get available platforms.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function getPlatforms() : array
	{
		$platforms = [
			'amazon-kindle' => 'Amazon Kindle',
			'animoto' => 'Animoto',
			'cloudup' => 'Cloudup',
			'crowdsignal' => 'Crowdsignal',
			'dailymotion' => 'Dailymotion',
			'facebook' => 'Facebook',
			'flickr' => 'Flickr',
			'hulu' => 'Hulu',
			'imgur' => 'Imgur',
			'instagram' => 'Instagram',
			'issuu' => 'Issuu',
			'kickstarter' => 'Kickstarter',
			'meetup-com' => 'Meetup.com',
			'mixcloud' => 'Mixcloud',
			'reddit' => 'Reddit',
			'reverbnation' => 'ReverbNation',
			'screencast' => 'Screencast',
			'scribd' => 'Scribd',
			'slideshare' => 'Slideshare',
			'smugmug' => 'SmugMug',
			'soundcloud' => 'SoundCloud',
			'speaker-deck' => 'Speaker Deck',
			'spotify' => 'Spotify',
			'ted' => 'TED',
			'tiktok' => 'TikTok',
			'tumblr' => 'Tumblr',
			'twitter' => 'Twitter',
			'videopress' => 'VideoPress',
			'vimeo' => 'Vimeo',
			'wordpress-tv' => 'WordPress.tv',
			'youtube' => 'YouTube',
		];

		/**
		 * Fires before returning available platforms.
		 *
		 * @since 1.0.0
		 */
		$platforms = apply_filters('tk_cookie_manager/platforms', $platforms);

		return $platforms;
	}
}
