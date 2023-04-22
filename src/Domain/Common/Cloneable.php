<?php
declare(strict_types=1);


namespace Domain\Common;

use ReflectionClass;

abstract readonly class Cloneable
{
    /**
     * @throws \ReflectionException
     */
    public function with(...$values): static
    {
        $refClass = new ReflectionClass(static::class);
        $clone = $refClass->newInstanceWithoutConstructor();

        foreach (get_object_vars($this) as $objectField => $objectValue) {
            $objectValue = array_key_exists($objectField, $values) ? $values[$objectField] : $objectValue;

            $declarationScope = $refClass->getProperty($objectField)->getDeclaringClass()->getName();
            if ($declarationScope === self::class) {
                $clone->$objectField = $objectValue;
            } else {
                (fn () => $this->$objectField = $objectValue)
                    ->bindTo($clone, $declarationScope)();
            }
        }

        return $clone;
    }

    /**
     * @throws \ReflectionException
     */
    public function withField(string $field, mixed $value): static
    {
        $refClass = new ReflectionClass(static::class);
        $clone = $refClass->newInstanceWithoutConstructor();

        $objectVars = get_object_vars($this);

        if (false === array_key_exists($field, $objectVars)) {
            throw new \InvalidArgumentException(sprintf('Field "%s" does not exist in class "%s"', $field, static::class));
        }

        foreach ($objectVars as $objectField => $objectValue) {
            $objectValue = $objectField === $field ? $value : $objectValue;

            $declarationScope = $refClass->getProperty($objectField)->getDeclaringClass()->getName();
            if ($declarationScope === self::class) {
                $clone->$objectField = $objectValue;
            } else {
                (fn () => $this->$objectField = $objectValue)
                    ->bindTo($clone, $declarationScope)();
            }
        }

        return $clone;
    }

}