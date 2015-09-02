<?php

namespace PatternMatcher;

use UnexpectedValueException;

class Matcher extends AbstractMatcher
{
    /**
     * @var array
     */
    private $defaultCase;

    /**
     * @param callable $matcher Default matcher. By default === is used.
     */
    public function __construct(callable $matcher = null)
    {
        parent::__construct($matcher);

        $this->defaultCase = [
            function () { return true; },
            function () { throw new UnexpectedValueException("Passed value does not match any pattern."); }
        ];
    }

    /**
     * @param callable|mixed $action
     *
     * @return static
     */
    public function setDefault($action)
    {
        $this->defaultCase[1] = is_callable($action) ? $action : const_function($action);

        return $this;
    }

    /**
     * @param mixed ...$arguments
     *
     * @throws UnexpectedValueException If match was not found (default behaviour).
     *
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        return $this->match(array_merge($this->cases, [$this->defaultCase]), $arguments)->get();
    }
}