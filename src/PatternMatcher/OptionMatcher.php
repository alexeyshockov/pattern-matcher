<?php

namespace PatternMatcher;

use PhpOption\Option;

class OptionMatcher extends AbstractMatcher
{
    /**
     * @param mixed ...$arguments
     *
     * @return Option
     */
    public function match(...$arguments)
    {
        return $this->doMatch($this->cases, $arguments);
    }

    /**
     * The same as match() method (for simplicity).
     *
     * @param mixed ...$arguments
     *
     * @return Option
     */
    public function __invoke(...$arguments)
    {
        return $this->doMatch($this->cases, $arguments);
    }
}
