# pattern-matcher

Simple pattern matching technique from functional languages. For PHP.

## Examples

With Option from schmittjoh/php-option:
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
