<?php

namespace EleFilter\Macros;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class Macro
{
    private string $namespace;
    private string $full_path;
    private string $suffix;
    private string $default_method;


    public static function register(): void
    {
        $macro = new self;
        $macro->handle();
    }


    private function handle(): void
    {
        $this->setConfigs();

        File::ensureDirectoryExists($this->full_path);

        foreach (File::allFiles($this->full_path) as $file) {

            $methods = $this->getClassMethodsFromFile($file);

            $class_key = $this->getClassKeyFromFile($file->getFilename());

            $this->registerMacro($methods, $class_key);
        }
    }

    /**
     * @param string[] $methods
     */
    private function registerMacro(array $methods, string  $class_key): void
    {
        $default_method = $this->default_method;

        foreach ($methods as $method) {

            $method_name = ($method == $this->default_method) ? lcfirst($class_key) : $method;

            if ($method == 'filter') {
                return;
            }

            Builder::macro($method_name, function ($value = null) use ($class_key, $method, $method_name, $default_method) {

                if ($method == $default_method) {
                    return $this->getModel()::filter([$method_name => $value]); // @phpstan-ignore-line
                }

                return $this->getModel()::filter([$class_key => $method_name]); // @phpstan-ignore-line
            });
        }
    }


    /**
     * @return string[]
     */
    private function getClassMethodsFromFile(SplFileInfo $file): array
    {
        $methods = [];
        $base_class = $this->namespace . '/' . $file->getRelativePath() . '/' . $file->getFilename();
        if (in_array($file->getRelativePath(), ['', '0'], true)) {
            $base_class = $this->namespace . '/'  . $file->getFilename();
        }

        $class = str_replace(['.php', '/'], ['', '\\'], $base_class);

        if (class_exists($class)) {
            $methods = get_class_methods($class);
        }

        return [] === $methods ? [] : array_diff($methods, ['__construct']);
    }


    private function getClassKeyFromFile(string $file_name): string
    {
        return  str_replace(['.php', $this->suffix], ['', ''], $file_name);
    }


    private function setConfigs(): void
    {
        $this->namespace = is_string(config('elefilter.namespace')) ? config('elefilter.namespace') : '';
        $this->full_path = is_string(config('elefilter.full_path')) ? config('elefilter.full_path') : '';
        $this->suffix = is_string(config('elefilter.suffix')) ? config('elefilter.suffix') : '';
        $this->default_method = is_string(config('elefilter.method')) ? config('elefilter.method') : '';
    }
}
