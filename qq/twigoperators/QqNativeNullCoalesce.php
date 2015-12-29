<?php
namespace Craft;

use Twig_Compiler;
use Twig_NodeInterface;
use Twig_Node_Expression_Name;
use Twig_Node_Expression_GetAttr;


/**
 * QQ (A null-coalescing Twig operator): QqNativeNullCoalesce
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2015, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.qq.twigoperators
 * @since     1.0
 */
class QqNativeNullCoalesce extends \Twig_Node_Expression_Binary
{

	/**
	 * QqNativeNullCoalesce constructor.
	 *
	 * @param Twig_NodeInterface $left
	 * @param Twig_NodeInterface $right
	 * @param int $lineno
	 */
	public function __construct(Twig_NodeInterface $left, Twig_NodeInterface $right, $lineno)
	{

		parent::__construct($left, $right, $lineno);

		// Ditch the strict variables check on the left and right nodes, and their sub-nodes

		foreach ([$left, $right] as $node)
		{

			if ($node instanceof Twig_Node_Expression_Name)
			{

				$node->setAttribute('ignore_strict_check', true);

			}
			elseif ($node instanceof Twig_Node_Expression_GetAttr)
			{

				$node->setAttribute('ignore_strict_check', true);

				if ($node->getNode('node') instanceof Twig_Node_Expression_GetAttr) {
					$this->changeIgnoreStrictCheck($node->getNode('node'));
				}

			}

		}

	}

	/**
	 * @param Twig_Compiler $compiler
	 *
	 * @return Twig_Compiler
	 */
	public function operator(Twig_Compiler $compiler)
	{
		return $compiler->raw('??');
	}

}

?>