<?php

namespace PatternMatcher;

/**
 * @internal
 *
 * @param mixed $value
 *
 * @return callable
 */
function const_function($value)
{
    return function () use ($value) { return $value; };
}

/**
 * @param callable $matcher
 *
 * @return OptionMatcher
 */
function option_matcher(callable $matcher = null)
{
    return new OptionMatcher($matcher);
}

/**
 * @param callable $matcher
 *
 * @return Matcher
 */
function matcher(callable $matcher = null)
{
    return new Matcher($matcher);
}
