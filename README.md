# pattern-matcher

Simple pattern matching technique from functional languages. For PHP.

## Examples

With Option from [schmittjoh/php-option](https://github.com/schmittjoh/php-option):
``` php
use function PatternMatcher\option_matcher;

$matcher = option_matcher(function ($className, ReflectionClass $class) {
    return ($class->getName() == $className) || $class->isSubclassOf($className);
})
    ->addCase(InputInterface::class, $input)
    ->addCase(OutputInterface::class, $output)
    ->addCase(Output::class, new Output($output))
    ->addCase(HelperInterface::class, function (ReflectionClass $class) {
        foreach ($this->getHelperSet() as $helper) {
            if ($class->isInstance($helper)) {
                return $helper;
            }
        }

        throw new InvalidArgumentException("Helper with type " . $class->getName() . " is not registered.");
    })
;

$argument = $argumentDefinition->getClass()
    ->flatMap($matcher)
    ->getOrThrow(new InvalidArgumentException(
        'Parameter $' . $argumentDefinition->getName() . ': type is missed or not supported.'
    ));
```

Or with [ColadaX](https://github.com/alexeyshockov/colada-x):
``` php

use PatternMatcher\matcher;
use PatternMatcher\all;
use Colada\x;

matcher()
    ->addCase(all(x()->isActive(), x()->hasFriends()), )

```

Or pure:
``` php
$matcher = (new PatternMatcher(function ($className, ReflectionClass $class) {
    return ($class->getName() == $className) || $class->isSubclassOf($className);
}))
    ->addCase(InputInterface::class, $input)
    ->addCase(OutputInterface::class, $output)
    ->addCase(Output::class, new Output($output))
    ->addCase(HelperInterface::class, function (ReflectionClass $class) {
        foreach ($this->getHelperSet() as $helper) {
            if ($class->isInstance($helper)) {
                return $helper;
            }
        }

        throw new InvalidArgumentException("Helper with type " . $class->getName() . " is not registered.");
    })
;

$argument = $argumentDefinition->getClass()
    ->flatMap($matcher)
    ->getOrThrow(new InvalidArgumentException(
        'Parameter $' . $argumentDefinition->getName() . ': type is missed or not supported.'
    ));
```
