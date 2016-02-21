<?php
namespace Craft;

/**
 * QqPlugin
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
		return 'QQ: Null Coalescing Operator';
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
	 * Return the plugin description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return 'Null coalescing Twig operator for CraftCMS';
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
		return false;
		// TODO: Add documentation URL.
	}

	/**
	 * Return the plugin's current version
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return '0.5.0';
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
		return "https://github.com/TopShelfCraft/QQ/raw/master/releases.json";
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

		// Prevent the install if we aren't at least on Craft 2.4

		if (version_compare(craft()->getVersion(), '2.4', '<')) {
			// No way to gracefully handle this
			// (because until 2.5, plugins can't prevent themselves from being installed),
			// so throw an Exception.
			throw new Exception('QQ requires Craft 2.4+');
		}

		// Prevent the install if we aren't at least on PHP 5.4
		if (!defined('PHP_VERSION') || version_compare(PHP_VERSION, '5.4', '<')) {
			Craft::log('QQ requires PHP 5.4+', LogLevel::Error);
			return false;
		}

	}

	/**
	 * @return QqTwigExtension
	 * @throws \Exception
	 */
	public function addTwigExtension()
	{
		Craft::import('plugins.qq.twigextensions.QqTwigExtension');
		Craft::import('plugins.qq.twigoperators.QqNullCoalescingOperator');
		return new QqTwigExtension();
	}

	/**
	 * @param mixed $msg
	 * @param string $level
	 * @param bool $force
	 *
	 * @return null
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
