<?php
namespace Craft;

use Twig_Compiler;
use Twig_NodeInterface;
use Twig_Node_Expression_Binary;
use Twig_Node_Expression_Name;
use Twig_Node_Expression_GetAttr;


/**
 * QqNullCoalescingOperator
 *
 * @author    Top Shelf Craft <michael@michaelrog.com>
 * @copyright Copyright (c) 2015, Michael Rog
 * @license   http://topshelfcraft.com/license
 * @see       http://topshelfcraft.com
 * @package   craft.plugins.qq.twigoperators
 * @since     1.0
 */
class QqNullCoalescingOperator extends Twig_Node_Expression_Binary
{


	/**
	 * QqNullCoalescingOperator constructor
	 *
	 * The null coalescing operator returns the first operand from left to right that exists and is not NULL.
	 * It returns NULL if neither operand value is defined and not NULL.
	 *
	 * Because either operand may be undefined, we must disable the strict variables check on the
	 * left and right nodes (and possibly their sub-nodes) in order to properly evaluate the expression.
	 *
	 * @param Twig_NodeInterface $left
	 * @param Twig_NodeInterface $right
	 * @param int $lineno
	 */
	public function __construct(Twig_NodeInterface $left, Twig_NodeInterface $right, $lineno)
	{

		parent::__construct($left, $right, $lineno);

		foreach (array($left, $right) as $node)
		{
			$this->_setIgnoreStrictCheck($node);
		}

	}

	/**
	 * If we're running PHP 7, this method simply needs to call the parent compile(), as the operator() method will
	 * return the native '??' symbol, and the compiled template will use PHP's native null-coalescing functionality.
	 * Otherwise, since the ?? operator is not available natively until PHP 7, this method provides a shim for the ?? logic.
	 *
	 * (With thanks to... http://stackoverflow.com/questions/27260832/how-to-define-a-null-coalescing-operator-for-twig)
	 *
	 * @param Twig_Compiler $compiler
	 */
	public function compile(Twig_Compiler $compiler)
	{

		if (version_compare(PHP_VERSION, '7.0.0', '>='))
		{

			parent::compile($compiler);

		}
		else
		{

			// Get variable placeholder names
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


	/**
	 * @param Twig_NodeInterface $node
	 */
	private function _setIgnoreStrictCheck(Twig_NodeInterface $node)
	{

		if ($node instanceof Twig_Node_Expression_Name)
		{
			$node->setAttribute('ignore_strict_check', true);
		}
		elseif ($node instanceof Twig_Node_Expression_GetAttr)
		{

			$node->setAttribute('ignore_strict_check', true);

			if ($node->getNode('node') instanceof Twig_Node_Expression_GetAttr)
			{
				$this->_setIgnoreStrictCheck($node->getNode('node'));
			}

		}

	}


}