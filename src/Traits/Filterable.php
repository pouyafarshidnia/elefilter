<?php

namespace EleFilter\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param array<mixed> $params
     * @param Builder<TModel> $builder
     */
    public function scopeFilter(Builder $builder, array $params): void
    {

        $namespace_from_config = is_string(config('elefilter.namespace')) ? config('elefilter.namespace') : '';

        $namespace = (null !== $this->filter_namespace && '' !== $this->filter_namespace) ? $this->filter_namespace : $namespace_from_config;


        foreach ($params as $class => $method_name) {

            $class_name = $this->getClassName($class, $namespace);


            if ($this->classExist($class_name) && $this->methodNameHasProperFormat($method_name)) {

                $filter_class = new $class_name($builder);

                $this->executeFilterMethod($class_name, $filter_class, $method_name);
            }
        }
    }


    private function getClassName(string $class, string $namespace): string
    {
        $suffix = is_string(config('elefilter.suffix')) ? config('elefilter.suffix') : 'Filter';

        if ($class === 'q' || $class === 's') {
            $class = 'search';
        }

        $class = ucfirst($class) . $suffix;


        $class_name =  $namespace . '\\' .   $class;
        if (class_exists($class_name)) {
            return $class_name;
        }

        $class_name = $namespace . '\\' . $this->getModel() . '\\' .  $class;
        if (class_exists($class_name)) {
            return $class_name;
        }

        $class_name = $namespace . '\\' . $this->getModel() . 's' . '\\' .  $class;
        if (class_exists($class_name)) {
            return $class_name;
        }

        $class_name = $namespace . '\\' . substr($this->getModel(), 0, -1) . 'ies' . '\\' .  $class;
        if (class_exists($class_name)) {
            return $class_name;
        }

        return '';
    }


    private function classExist(string $class): bool
    {
        return  '' !== $class;
    }

    private function methodNameHasProperFormat(mixed $method_name): bool
    {
        return (null !== $method_name) && (is_string($method_name) || is_int($method_name) || is_array($method_name));
    }


    private function executeFilterMethod(string $class, object $filter_class, mixed $method): void
    {
        $default_method = is_string(config('elefilter.method')) ? config('elefilter.method') : 'apply';

        if (is_string($method)) {
            $method = lcfirst($method);
            if (method_exists($class, $method)) {
                $filter_class->$method();
            }
        }

        if ($method != $default_method && method_exists($class, $default_method)) {
            $filter_class->$default_method($method);
        }
    }


    private function getModel(): string
    {
        $path = explode('\\', self::class);
        return array_pop($path);
    }
}
