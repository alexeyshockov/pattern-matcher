<?php

namespace spec\PatternMatcher;

use PhpOption\None;
use PhpOption\Some;
use PhpSpec\ObjectBehavior;

/**
 * @mixin \PatternMatcher\OptionMatcher
 */
class OptionMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PatternMatcher\OptionMatcher');
    }

    function it_produces_an_option_when_something_matches()
    {
        $this->addCase(1, 'one')->shouldReturn($this);

        $this(1)->shouldBeAnOptionOf('one');
    }

    function it_produces_an_empty_option_when_nothing_matches()
    {
        $this('some_value_to_match')->shouldBeAnEmptyOption();
    }

    public function getMatchers()
    {
        return [
            'beAnEmptyOption' => function ($subject) {
                return $subject === None::create();
            },
            'beAnOptionOf' => function ($subject, $value) {
                return is_object($subject) && ($subject instanceof Some) && ($subject->get() === $value);
            }
        ];
    }
}
