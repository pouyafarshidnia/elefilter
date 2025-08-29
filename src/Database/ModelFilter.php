<?php

namespace EleFilter\Database;

use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use EleFilter\Exceptions\InvalidParameterException;

abstract class ModelFilter
{
    protected string $column = '';

    public function __construct(protected Builder $builder) {}

    protected function like(int|string $params, ?string $other_column = null): void
    {
        $this->builder->where($this->getColumn($other_column), 'like', "%$params%");
    }

    protected function notLike(int|string $params, ?string $other_column = null): void
    {
        $this->builder->whereNotLike($this->getColumn($other_column), "%$params%");
    }

    protected function startWith(int|string $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), 'like', "$params%");
    }

    protected function endWith(int|string $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), 'like', "%$params");
    }

    protected function equal(mixed $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), $params);
    }

    protected function notEqual(mixed $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), '!=', $params);
    }

    protected function greaterThan(string|int $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), '>', $params);
    }

    protected function greaterOrEqualThan(string|int $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), '>=', $params);
    }

    protected function lowerThan(string|int $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), '<', $params);
    }

    protected function lowerOrEqualThan(string|int $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), '<=', $params);
    }

    protected function greaterOrLowerThan(string|int $params, ?string $other_column = null): void
    {

        $this->builder->where($this->getColumn($other_column), '<>', $params);
    }

    protected function null(?string $other_column = null): void
    {

        $this->builder->whereNull($this->getColumn($other_column));
    }

    protected function notNull(?string $other_column = null): void
    {

        $this->builder->whereNotNull($this->getColumn($other_column));
    }

    /**
     * @param array<mixed> $params
     */
    protected function in(array $params, ?string $other_column = null): void
    {
        $this->builder->whereIn($this->getColumn($other_column), $params);
    }

    /**
     * @param array<mixed> $params
     */
    protected function notIn(array $params, ?string $other_column = null): void
    {
        $this->builder->whereNotIn($this->getColumn($other_column), $params);
    }

    protected function date(DateTimeInterface|string|null $params, ?string $other_column = null): void
    {
        $this->builder->whereDate($this->getColumn($other_column), $params);
    }

    protected function month(string|int $params, ?string $other_column = null): void
    {

        $this->builder->whereMonth($this->getColumn($other_column), $params);
    }

    protected function day(string|int $params, ?string $other_column = null): void
    {

        $this->builder->whereDay($this->getColumn($other_column), $params);
    }

    protected function year(string|int $params, ?string $other_column = null): void
    {

        $this->builder->whereYear($this->getColumn($other_column), $params);
    }

    protected function time(DateTimeInterface|string|null $params, ?string $other_column = null): void
    {

        $this->builder->whereTime($this->getColumn($other_column), '=', $params);
    }

    protected function nowOrPast(?string $other_column = null): void
    {

        $this->builder->whereNowOrPast($this->getColumn($other_column));
    }

    protected function nowOrFuture(?string $other_column = null): void
    {

        $this->builder->whereNowOrFuture($this->getColumn($other_column));
    }

    protected function today(?string $other_column = null): void
    {

        $this->builder->whereToday($this->getColumn($other_column));
    }

    protected function beforeToday(?string $other_column = null): void
    {
        $this->builder->whereBeforeToday($this->getColumn($other_column));
    }

    protected function afterToday(?string $other_column = null): void
    {
        $this->builder->whereAfterToday($this->getColumn($other_column));
    }

    protected function todayOrAfter(?string $other_column = null): void
    {
        $this->builder->whereTodayOrAfter($this->getColumn($other_column));
    }

    protected function todayOrBefore(?string $other_column = null): void
    {
        $this->builder->whereTodayOrBefore($this->getColumn($other_column));
    }


    /**
     * @param array<mixed> $params
     */
    protected function between(array $params, ?string $other_column = null): void
    {
        if (count($params) !== 2) {
            throw InvalidParameterException::filterArrayParametersAreIncompatible();
        }


        $this->builder->whereBetween($this->getColumn($other_column), $params);
    }


    /**
     * @param array<mixed> $params
     */
    protected function notBetween(array $params, ?string $other_column = null): void
    {
        if (count($params) !== 2) {
            throw InvalidParameterException::filterArrayParametersAreIncompatible();
        }


        $this->builder->whereNotBetween($this->getColumn($other_column), $params);
    }

    # Not supported in all DBMS
    protected function fullText(string $params, ?string $other_column = null): void
    {
        $this->builder->whereFullText($this->getColumn($other_column), $params);
    }

    protected function desc(?string $other_column = null): void
    {
        $this->builder->orderByDesc($this->getColumn($other_column));
    }

    protected function asc(?string $other_column = null): void
    {
        $this->builder->orderBy($this->getColumn($other_column));
    }

    /**
     * Helpers
     */
    private function getColumn(?string $column): string
    {
        return $column ?? $this->column;
    }
}
