<?php

namespace PatternMatcher;

use PhpOption\None;
use PhpOption\Some;

use function Functional\partial_left;

abstract class AbstractMatcher
{
    /**
     * @var array
     */
    protected $cases;

    /**
     * @var callable
     */
    protected $matcher;

    /**
     * @param callable $matcher Default matcher. By default === is used.
     */
    public function __construct(callable $matcher = null)
    {
        $this->matcher = $matcher ?: function ($element1, $element2) { return $element1 === $element2; };

        $this->cases = [];
    }

    /**
     * Order is important.
     *
     * @param callable|mixed $pattern
     * @param callable|mixed $action
     *
     * @return static
     */
    public function addCase($pattern, $action)
    {
        $this->cases[] = [
            is_callable($pattern) ? $pattern : partial_left($this->matcher, $pattern),
            is_callable($action) ? $action : const_function($action),
        ];

        return $this;
    }

    /**
     * @param mixed ...$arguments
     *
     * @return \PhpOption\Option
     */
    public function __invoke(...$arguments)
    {
        return $this->match($this->cases, $arguments);
    }

    /**
     * @param array $cases
     * @param array $arguments
     *
     * @return \PhpOption\Option
     */
    protected function match(array $cases, array $arguments)
    {
        foreach ($cases as $case) {
            list($matcher, $action) = $case;

            if (call_user_func_array($matcher, $arguments)) {
                return new Some(call_user_func_array($action, $arguments));
            }
        }

        return None::create();
    }
}
