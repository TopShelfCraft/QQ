<?php
namespace Craft;

use Twig_Compiler;
use Twig_NodeInterface;
use Twig_Node_Expression_Name;
use Twig_Node_Expression_GetAttr;


/**
 * QQ (A null-coalescing Twig operator): QqNullCoalesce
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2015, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.qq.twigoperators
 * @since     1.0
 */
class QqNullCoalesce extends \Twig_Node_Expression_Binary
{

	/**
	 * QqNullCoalesce constructor.
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
	 * (With thanks to... http://stackoverflow.com/questions/27260832/how-to-define-a-null-coalescing-operator-for-twig)
	 *
	 * @param Twig_Compiler $compiler
	 */
	public function compile(Twig_Compiler $compiler)
	{

		// Get random variable placeholder names

		$varL = $compiler->getVarName();
		$varR = $compiler->getVarName();


		// Compile to: (($varL = left) !== NULL ? $varL : (($varR = right) !== NULL ? $varR : null))

		$compiler

			->raw(sprintf('(($%s = ', $varL))
			->subcompile($this->getNode('left'))
			->raw(sprintf(') !== NULL ? $%s : ', $varL))

			->raw(sprintf('(($%s = ', $varR))
			->subcompile($this->getNode('right'))
			->raw(sprintf(') !== NULL ? $%s : null', $varR))
			->raw(sprintf(')'))

			->raw(sprintf(')'))

		;

	}

	/**
	 * @param Twig_Compiler $compiler
	 *
	 * @return Twig_Compiler
	 */
	public function operator(Twig_Compiler $compiler)
	{
		return $compiler->raw('');
	}

}

?>