<?php
namespace Craft;

use Twig_Extension;
use Twig_ExpressionParser;


/**
 * QQ (The null-coalescing Twig operator): QqTwigExtension
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2015, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.qq.twigextensions
 * @since     1.0
 */
class QqTwigExtension extends Twig_Extension
{

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'QQ';
	}

	/**
	 * @return array
	 */
	public function getOperators() {
		return [
			[],
			[
				'qq' => array('precedence' => 15.5, 'class' => QqNullCoalesce::class, 'associativity' => Twig_ExpressionParser::OPERATOR_RIGHT),
				'??' => array('precedence' => 15.5, 'class' => (PHP_MAJOR_VERSION > 6 ? QqNativeNullCoalesce::class : QqNullCoalesce::class), 'associativity' => \Twig_ExpressionParser::OPERATOR_RIGHT),
			]
		];
	}

}