<?php
namespace Craft;

/**
 * QQ (A null-coalescing Twig operator): QqPlugin
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2015, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.qq
 * @since     1.0
 */
class QqPlugin extends BasePlugin
{

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'QQ (Null-coalescing Twig operator)';
	}

	/**
	 * Return the plugin developer's name
	 *
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Top Shelf Craft';
	}

	/**
	 * Return the plugin developer's URL
	 *
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'http://topshelfcraft.com';
	}

	/**
	 * Return the plugin's Documentation URL
	 *
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return "http://topshelfcraft.com/qq";
	}

	/**
	 * Return the plugin's current version
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return '0.0.1';
	}

	/**
	 * Return the plugin's db schema version
	 *
	 * @return string|null
	 */
	public function getSchemaVersion()
	{
		return '0.0.1.0';
	}

	/**
	 * Return the plugin's db schema version
	 *
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		// TODO
	}

	/**
	 * Return whether the plugin has a CP section
	 *
	 * @return bool
	 */
	public function hasCpSection()
	{
		return false;
	}

	/**
	 * Make sure requirements are met before installation.
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function onBeforeInstall()
	{

		// Prevent the install if we aren't at least on Craft 2.5

		if (version_compare(craft()->getVersion(), '2.5', '<')) {
			// No way to gracefully handle this
			// (because until 2.5, plugins can't prevent themselves from being installed),
			// so throw an Exception.
			throw new Exception('QQ requires Craft 2.5+');
		}

		// Prevent the install if we aren't at least on PHP 5.4

		if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50400) {
			Craft::log('QQ requires PHP 5.4+', LogLevel::Error);
			return false;
			// TODO (1.x): Flash an error to the CP before returning.
		}

	}

	/**
	 *
	 */
	public function onAfterInstall()
	{
		// TODO: Phone home.
	}

	/**
	 *
	 */
	public function init() {
		// TODO: init?
	}

	/**
	 * @return QqTwigExtension
	 * @throws \Exception
	 */
	public function addTwigExtension()
	{
		Craft::import('plugins.qq.twigextensions.QqTwigExtension');
		Craft::import('plugins.qq.twigoperators.QqNullCoalesce');
		Craft::import('plugins.qq.twigoperators.QqNativeNullCoalesce');
		return new QqTwigExtension();
	}

	/**
	 * @param mixed $msg
	 * @param string $level
	 * @param bool $force
	 */
	public static function log($msg, $level = LogLevel::Profile, $force = false)
	{

		if (is_string($msg))
		{
			$msg = "\n" . $msg . "\n\n";
		}
		else
		{
			$msg = "\n" . print_r($msg, true) . "\n\n";
		}

		parent::log($msg, $level, $force);

	}

}