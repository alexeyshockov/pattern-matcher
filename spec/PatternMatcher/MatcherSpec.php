<?php

namespace spec\PatternMatcher;

use PhpSpec\Exception\Example\FailureException;
use UnexpectedValueException;
use PhpSpec\ObjectBehavior;

/**
 * @mixin \PatternMatcher\Matcher
 */
class MatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PatternMatcher\Matcher');
    }

    function it_supports_default_value()
    {
        $this->setDefault('default_value')->shouldReturn($this);

        $this('some_value_to_match')->shouldReturn('default_value');
    }

    function it_supports_default_action()
    {
        $this->setDefault(function($value) { return strrev($value); })->shouldReturn($this);

        $this('some_value_to_match')->shouldReturn('hctam_ot_eulav_emos');
    }

    function it_has_default_exception()
    {
        $this->shouldThrow(UnexpectedValueException::class)->during('__invoke', ['some_value_to_match']);
    }

    function it_matches_only_once()
    {
        $this->addCase(1, 'first_one')->shouldReturn($this);
        $this->addCase(1, $this->getActionThatShouldNotBeCalled())->shouldReturn($this);

        $this(1)->shouldReturn('first_one');
    }

    function it_should_support_constants_patterns()
    {

    }

    function it_should_support_callable_patterns()
    {

    }

    function it_should_support_constants_actions()
    {

    }

    function it_should_support_callable_actions()
    {

    }

    private function getActionThatShouldNotBeCalled()
    {
        return function () {
            throw new FailureException("Second method should not have been called.");
        };
    }
}
