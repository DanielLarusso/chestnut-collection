<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

use ArrayAccess;
use Closure;
use RuntimeException;

use function in_array;
use function method_exists;
use function sprintf;
use function str_contains;

class ClosureExpressionVisitor extends AbstractExpressionVisitor
{
    public static function getObjectFieldValue(object $object, string $field): mixed
    {
        $accessors = ['get', 'is'];

        foreach ($accessors as $accessor) {
            $accessor .= $field;

            if (!method_exists($object, $accessor)) {
                continue;
            }

            return $object->$accessor();
        }

        // __call should be triggered for get.
        $accessor = $accessors[0] . $field;

        if (method_exists($object, '__call')) {
            return $object->$accessor();
        }

        if ($object instanceof ArrayAccess) {
            return $object[$field];
        }

        return $object->$field;
    }

    public static function sortByField(string $name, int $orientation = 1, Closure $next = null): Closure
    {
        if (!$next) {
            $next = fn($a, $b) => 0;
        }

        return function ($a, $b) use ($name, $next, $orientation) {
            $aValue = ClosureExpressionVisitor::getObjectFieldValue($a, $name);
            $bValue = ClosureExpressionVisitor::getObjectFieldValue($b, $name);

            if ($aValue === $bValue) {
                return $next($a, $b);
            }

            return (($aValue > $bValue) ? 1 : -1) * $orientation;
        };
    }

    public function walkComparison(ComparisonExpressionInterface $comparison): mixed
    {
        $field = $comparison->getField();
        $value = $this->walkValue($comparison->getValue());

        // TODO use comparer factory and different comparer classes
        switch ($comparison->getOperator()) {
            case ComparisonOperator::EQ:
                return function ($object) use ($field, $value) {
                    return ClosureExpressionVisitor::getObjectFieldValue($object, $field) === $value;
                };

            case ComparisonOperator::NEQ:
                return function ($object) use ($field, $value) {
                    return ClosureExpressionVisitor::getObjectFieldValue($object, $field) !== $value;
                };

            case ComparisonOperator::LT:
                return function ($object) use ($field, $value) {
                    return ClosureExpressionVisitor::getObjectFieldValue($object, $field) < $value;
                };

            case ComparisonOperator::LTE:
                return function ($object) use ($field, $value) {
                    return ClosureExpressionVisitor::getObjectFieldValue($object, $field) <= $value;
                };

            case ComparisonOperator::GT:
                return function ($object) use ($field, $value) {
                    return ClosureExpressionVisitor::getObjectFieldValue($object, $field) > $value;
                };

            case ComparisonOperator::GTE:
                return function ($object) use ($field, $value) {
                    return ClosureExpressionVisitor::getObjectFieldValue($object, $field) >= $value;
                };

            case ComparisonOperator::IN:
                return function ($object) use ($field, $value) {
                    return in_array(ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };

            case ComparisonOperator::NIN:
                return function ($object) use ($field, $value) {
                    return !in_array(ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };

            case ComparisonOperator::CONTAINS:
                return function ($object) use ($field, $value) {
                    return str_contains(ClosureExpressionVisitor::getObjectFieldValue($object, $field), $value);
                };

            default:
                throw new RuntimeException(
                    sprintf('Unknown comparison operator: %s', $comparison->getOperator()->value)
                );
        }
    }

    public function walkValue(ValueExpressionInterface $value): mixed
    {
        return $value->getValue();
    }

    public function walkCompositeExpression(CompositeExpressionInterface $expression): mixed
    {
        $expressionList = array();

        foreach ($expression->getExpressionList() as $child) {
            $expressionList[] = $this->dispatch($child);
        }

        // todo use factory
        switch ($expression->getType()) {
            case CompositeType::AND:
                return $this->andExpressions($expressionList);

            case CompositeType::OR:
                return $this->orExpressions($expressionList);

            default:
                throw new RuntimeException(
                    sprintf('Unknown composite %s', $expression->getType()->value)
                );
        }
    }

    private function andExpressions(array $expressions): Closure
    {
        return function ($object) use ($expressions) {
            foreach ($expressions as $expression) {
                if (!$expression($object)) {
                    return false;
                }
            }

            return true;
        };
    }

    private function orExpressions(array $expressions): Closure
    {
        return function ($object) use ($expressions) {
            foreach ($expressions as $expression) {
                if ($expression($object)) {
                    return true;
                }
            }

            return false;
        };
    }
}