<?php
namespace Craft;

use Twig_Extension;
use Twig_ExpressionParser;


/**
 * QqTwigExtension
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
			// Unary operators
			[],
			// Binary operators
			[
				'qq' => array('precedence' => 15.5, 'class' => QqNullCoalescingOperator::class, 'associativity' => Twig_ExpressionParser::OPERATOR_RIGHT),
				'??' => array('precedence' => 15.5, 'class' => QqNullCoalescingOperator::class, 'associativity' => Twig_ExpressionParser::OPERATOR_RIGHT),
			]
		];
	}

}