<?php

use EleFilter\Commands\MakeFilterCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

beforeEach(function (): void {

    Config::set('elefilter.path', 'Test/Filters');
    Config::set('elefilter.namespace', 'App\Test\Filters');
});


/**
 * Configuration Tests
 */
describe('config', function (): void {

    it('can use custom config', function (): void {

        Config::set('filterlab.path', 'Custom/Filters');
        Config::set('filterlab.namespace', 'Custom\Filters');

        expect(config('filterlab.path'))->toBe('Custom/Filters');
        expect(config('filterlab.namespace'))->toBe('Custom\Filters');
    });

    it('can create filter class with custom config', function (): void {

        deleteFileAndParents('Custom/Filters/OrderFilter.php');

        Config::set('elefilter.path', 'Custom/Filters');
        Config::set('elefilter.namespace', 'Custom\Filters');

        $this->artisan('make:filter Order')
            ->assertExitCode(0);

        expect(base_path('Custom/Filters/OrderFilter.php'))->toBeFile();
    });

    it('can create filter class in Sub folder', function (): void {

        deleteFileAndParents('Custom/Filters/Order/StatusFilter.php');

        Config::set('elefilter.path', 'Custom/Filters');
        Config::set('elefilter.namespace', 'Custom\Filters');

        $this->artisan('make:filter Order/Status')
            ->assertExitCode(0);

        expect(base_path('Custom/Filters/Order/StatusFilter.php'))->toBeFile();
    });

    it('can create filter class in chain Sub folder', function (): void {

        deleteFileAndParents('Custom/Filters/Order/Status/ClientFilter.php');

        Config::set('elefilter.path', 'Custom/Filters');
        Config::set('elefilter.namespace', 'Custom\Filters');

        $this->artisan('make:filter Order/Status/Client')
            ->assertExitCode(0);

        expect(base_path('Custom/Filters/Order/Status/ClientFilter.php'))->toBeFile();
    });
});


/**
 * Command Tests
 */
describe('command', function (): void {

    it('can create filter class in Sub folder', function (): void {

        deleteFileAndParents('Test/Filters/Order/StatusFilter.php');

        $this->artisan('make:filter Order/Status')
            ->assertExitCode(0);

        expect(base_path('Test/Filters/Order/StatusFilter.php'))->toBeFile();
    });


    it('can create filter class in chain Sub folder', function (): void {

        deleteFileAndParents('Test/Filters/Order/Status/ClientFilter.php');

        $this->artisan('make:filter Order/Status/Client')
            ->assertExitCode(0);

        expect(base_path('Test/Filters/Order/Status/ClientFilter.php'))->toBeFile();
    });


    it('can create filter class ', function (): void {

        deleteFileAndParents('Test/Filters/OrderFilter.php');

        $this->artisan('make:filter Order')
            ->assertExitCode(0);

        expect(base_path('Test/Filters/OrderFilter.php'))->toBeFile();
    });


    it('shows error if class already exists', function (): void {

        deleteFileAndParents('Test/Filters/AlreadyExistsFilter.php');

        $this->artisan('make:filter AlreadyExists')
            ->assertExitCode(0);

        $this->artisan('make:filter AlreadyExists')
            ->expectsOutputToContain('Filter class already exists!')
            ->assertExitCode(1);

        deleteFileAndParents('Test/Filters/AlreadyExistsFilter.php');
    });


    it('can create filter class if name contains .php', function (): void {

        deleteFileAndParents('Test/Filters/OrderFilter.php');

        $this->artisan('make:filter Order.php')
            ->assertExitCode(0);

        expect(base_path('Test/Filters/OrderFilter.php'))->toBeFile();
    });
});


/**
 * Options Tests
 */
describe('options', function (): void {

    it('has column option', function (): void {

        $command = app(MakeFilterCommand::class);

        $definition = $command->getDefinition();

        $column = $definition->getOptions()['column'];

        expect($definition->hasOption('column'))->toBeTrue()
            ->and($column->getName())->toBe('column');
    });


    it('can create filter class with column option', function (): void {

        deleteFileAndParents('Test/Filters/Order/StatusFilter.php');

        $this->artisan('make:filter Order/Status --column=paid_at')
            ->assertExitCode(0);


        expect(base_path('Test/Filters/Order/StatusFilter.php'))->toBeFile();

        $column = getColumn(base_path('Test/Filters/Order/StatusFilter.php'));

        expect($column)->toBe('protected string $column = "paid_at";');
    });


    it('can create filter class without column option', function (): void {

        deleteFileAndParents('Test/Filters/Order/StatusFilter.php');

        $this->artisan('make:filter Order/Status')
            ->assertExitCode(0);


        expect(base_path('Test/Filters/Order/StatusFilter.php'))->toBeFile();

        $column = getColumn(base_path('Test/Filters/Order/StatusFilter.php'));

        expect($column)->toBe('protected string $column = "";');
    });
});

/**
 * Stub Tests
 */
describe('stub', function (): void {

    it('can create filter class based on stub', function (): void {

        deleteFileAndParents('Test/Filters/OrderFilter.php');

        $this->artisan('make:filter Order')
            ->assertExitCode(0);

        [$namespace, $class, $column] = explodeFilterClass(base_path('Test/Filters/OrderFilter.php'));

        expect($namespace)->toBe('namespace App\Test\Filters;')
            ->and($class)->toBe('class OrderFilter extends ModelFilter')
            ->and($column)->toBe('protected string $column = "";');
    });

    it('can create filter class based on stub in Sub folder', function (): void {

        deleteFileAndParents('Test/Filters/Order/StatusFilter.php');

        $this->artisan('make:filter Order/Status')
            ->assertExitCode(0);

        [$namespace, $class, $column] = explodeFilterClass(base_path('Test/Filters/Order/StatusFilter.php'));

        expect($namespace)->toBe('namespace App\Test\Filters\Order;')
            ->and($class)->toBe('class StatusFilter extends ModelFilter')
            ->and($column)->toBe('protected string $column = "";');
    });

    it('can create filter class based on stub in chain Sub folder', function (): void {

        deleteFileAndParents('Test/Filters/Order/Status/ClientFilter.php');

        $this->artisan('make:filter Order/Status/Client')
            ->assertExitCode(0);

        [$namespace, $class, $column] = explodeFilterClass(base_path('Test/Filters/Order/Status/ClientFilter.php'));

        expect($namespace)->toBe('namespace App\Test\Filters\Order\Status;')
            ->and($class)->toBe('class ClientFilter extends ModelFilter')
            ->and($column)->toBe('protected string $column = "";');
    });

    it('can create filter class with different prefix', function (): void {

        deleteFileAndParents('Test/Filters/Order.php');

        Config::set('elefilter.suffix', '');

        $this->artisan('make:filter Order')
            ->assertExitCode(0);

        [$namespace, $class, $column] = explodeFilterClass(base_path('Test/Filters/Order.php'));

        expect($namespace)->toBe('namespace App\Test\Filters;')
            ->and($class)->toBe('class Order extends ModelFilter')
            ->and($column)->toBe('protected string $column = "";');
    });
});







/**
 * Helpers
 */
function explodeFilterClass($path): array
{
    $content = File::get($path);
    $content_array = explode(PHP_EOL, $content);
    $namespace = $content_array[2];
    $class = $content_array[6];
    $column = $content_array[8];

    return [trim($namespace), trim($class), trim($column)];
}

function deleteFileAndParents(string $relative_path): void
{

    $file_path = base_path($relative_path);

    if (File::exists($file_path)) {
        File::delete($file_path);
    }


    $directory = dirname($file_path);


    $base_path = base_path();

    while (Str::startsWith($directory, $base_path) && $directory !== $base_path) {
        if (
            File::isDirectory($directory)
            && count(File::files($directory)) === 0
            && count(File::directories($directory)) === 0
        ) {

            File::deleteDirectory($directory);
            $directory = dirname($directory);
        } else {
            break;
        }
    }
}

function getColumn($path): string
{
    $content = File::get($path);
    $content_array = explode(PHP_EOL, $content);

    return trim($content_array[8]);
}
