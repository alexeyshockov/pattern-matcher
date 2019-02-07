<?php

namespace PatternMatcher;
use InvalidArgumentException;

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

/**
 * Logical NOT.
 *
 * @param callable $function
 *
 * @return \Closure
 */
function not($function) {
    return function(...$arguments) use ($function) {
        return !call_user_func_array($function, $arguments);
    };
}

/**
 * Combine all passed functions with logical OR.
 *
 * @param callable ...$functions
 *
 * @return \Closure
 */
function any(...$functions) {
    if (count($functions) < 1) {
        throw new InvalidArgumentException('At least one function is needed.');
    }

    return function(...$arguments) use ($functions) {
        $result = false;
        foreach ($functions as $function) {
            $result = $result || call_user_func_array($function, $arguments);
        }

        return $result;
    };
}

/**
 * Combine all passed functions with logical AND.
 *
 * @param callable ...$functions
 *
 * @return \Closure
 */
function all(...$functions) {
    if (count($functions) < 1) {
        throw new InvalidArgumentException('At least one function is needed.');
    }

    return function(...$arguments) use ($functions) {
        $result = true;
        foreach ($functions as $function) {
            $result = $result && call_user_func_array($function, $arguments);
        }

        return $result;
    };
}
