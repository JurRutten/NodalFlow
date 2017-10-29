<?php

/*
 * This file is part of NodalFlow.
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/NodalFlow
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\NodalFlow\Nodes;

use fab2s\NodalFlow\Flows\FlowInterface;
use fab2s\NodalFlow\NodalFlowException;

/**
 * abstract Class NodeAbstract
 */
abstract class NodeAbstract implements NodeInterface
{
    /**
     * The carrying Flow
     *
     * @var FlowInterface
     */
    public $carrier;

    /**
     * Indicate if this Node is traversable
     *
     * @var bool
     */
    protected $isATraversable;

    /**
     * Indicate if this Node is returning a value
     *
     * @var bool
     */
    protected $isAReturningVal;

    /**
     * Indicate if this Node is a Flow (Branch)
     *
     * @var bool
     */
    protected $isAFlow;

    /**
     * Instantiate a Node
     */
    public function __construct()
    {
        $this->enforceIsATraversable();
    }

    /**
     * Indicate if this Node is Traversable
     *
     * @return bool
     */
    public function isTraversable()
    {
        return (bool) $this->isATraversable;
    }

    /**
     * Indicate if this Node is a Flow (Branch)
     *
     * @return bool true if this node instanceof FlowInterface
     */
    public function isFlow()
    {
        return (bool) $this->isAFlow;
    }

    /**
     * Indicate if this Node is returning a value
     *
     * @return bool true if this node is expected to return
     *              something to pass on next node as param.
     *              If nothing is returned, the previously
     *              returned value will be use as param
     *              for next nodes.
     */
    public function isReturningVal()
    {
        return (bool) $this->isAReturningVal;
    }

    /**
     * Set carrying Flow
     *
     * @param FlowInterface $flow
     *
     * @return $this
     */
    public function setCarrier(FlowInterface $flow)
    {
        $this->carrier = $flow;

        return $this;
    }

    /**
     * Get carrying Flow
     *
     * @return FlowInterface
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * Get this Node's hash, must be deterministic and unique
     *
     * Caching the result would save a bit of resources
     * but would require to implement `__clone()` to
     * make sure we reset the hash should a node be cloned.
     * Doing this would add the burden to actual Node
     * implementation to trigger `parent::_clone()`
     * which is not ideal and impossible to guaranty.
     * Now since this method is not used in the actual
     * flow execution loop, but only when an interruption
     * is raised, it's not a performance issue.
     *
     * @return string
     */
    public function getNodeHash()
    {
        return \sha1(\spl_object_hash($this));
    }

    /**
     * Make sure this Node is consistent
     *
     * @throws NodalFlowException
     *
     * @return $this
     */
    protected function enforceIsATraversable()
    {
        if ($this->isFlow()) {
            if ($this->isATraversable) {
                throw new NodalFlowException('Cannot Traverse a Branch');
            }

            return $this;
        }

        if ($this->isATraversable) {
            if (!($this instanceof TraversableNodeInterface)) {
                throw new NodalFlowException('Cannot Traverse a Node that does not implement TraversableNodeInterface');
            }

            return $this;
        }

        if (!($this instanceof ExecNodeInterface)) {
            throw new NodalFlowException('Cannot Exec a Node that does not implement ExecNodeInterface');
        }

        return $this;
    }
}
