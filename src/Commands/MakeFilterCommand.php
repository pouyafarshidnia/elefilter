<?php

namespace EleFilter\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;

class MakeFilterCommand extends Command
{
    protected $signature = 'make:filter {name} {--column=}';

    protected $description = 'Create a new filter class';

    private string $namespace;
    private string $path;
    private string $suffix;
    private string $column_option;


    public function handle(): mixed
    {

        $this->setConfig();

        $class_path = $this->getClassPath();

        if (file_exists($class_path)) {
            $this->components->error('Filter class already exists!');
            return static::FAILURE;
        }


        $name = $this->getClassName();
        $name_array = explode('/', $name);
        $stub_class = end($name_array) . $this->suffix;
        array_pop($name_array);

        $stub_namespace = in_array(implode('\\', $name_array), ['', '0'], true) ? $this->namespace : $this->namespace . '\\' . implode('\\', $name_array);;

        $class_directory = $this->path . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $name_array);

        File::ensureDirectoryExists(base_path($class_directory));

        $stub = $this->getStub();

        $stub = str_replace(['{{ class }}', '{{ namespace }}', '{{ column }}'], [$stub_class, $stub_namespace, $this->column_option], $stub);

        File::put($class_path, $stub);

        $this->components->info("Filter class created: {$class_directory}/{$stub_class}.php'");

        return static::SUCCESS;
    }

    protected function getStub(): string
    {
        $root_path = str_replace(DIRECTORY_SEPARATOR . 'Commands', '', __DIR__) . DIRECTORY_SEPARATOR;
        $stub_path = $root_path . 'stubs' . DIRECTORY_SEPARATOR . 'filter.stub';

        return File::get($stub_path);
    }


    private function setConfig(): void
    {
        $this->namespace = is_string(config('elefilter.namespace')) ? config('elefilter.namespace') : '';
        $this->path = is_string(config('elefilter.path')) ? config('elefilter.path') : '';
        $this->suffix = is_string(config('elefilter.suffix')) ? config('elefilter.suffix') : '';
        $this->column_option = is_string($this->option('column')) ? $this->option('column') : '';
    }


    private function getClassName(): string
    {
        $name =  is_string($this->argument('name')) ? $this->argument('name') : '';

        if (str_ends_with($name, '.php')) {
            return substr($name, 0, -4);
        }

        return $name;
    }


    private function  getClassPath(): string
    {
        $name = $this->getClassName();
        return base_path() . DIRECTORY_SEPARATOR . $this->path . DIRECTORY_SEPARATOR . $name . $this->suffix . '.php';
    }
}
