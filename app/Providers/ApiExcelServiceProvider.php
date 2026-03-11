<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class ApiExcelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Auto-regenerate Excel after route:cache or when running in local env
        if ($this->app->runningInConsole()) {
            Event::listen('Illuminate\Console\Events\CommandFinished', function ($event) {
                if (in_array($event->command, ['route:cache', 'route:clear'])) {
                    $this->regenerateIfChanged();
                }
            });
        }

        // In local environment, check on every boot if routes file changed
        if ($this->app->environment('local') && $this->routeFileChanged()) {
            $this->app->booted(function () {
                $this->regenerateExcel();
            });
        }
    }

    private function routeFileChanged(): bool
    {
        $routeFile = base_path('routes/api.php');
        $hashFile = storage_path('app/api_routes.hash');

        if (!file_exists($routeFile)) {
            return false;
        }

        $currentHash = md5_file($routeFile);

        if (!file_exists($hashFile)) {
            return true;
        }

        return trim(file_get_contents($hashFile)) !== $currentHash;
    }

    private function regenerateIfChanged(): void
    {
        if ($this->routeFileChanged()) {
            $this->regenerateExcel();
        }
    }

    private function regenerateExcel(): void
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('api:generate-excel');

            // Save hash
            $routeFile = base_path('routes/api.php');
            $hashFile = storage_path('app/api_routes.hash');
            file_put_contents($hashFile, md5_file($routeFile));
        } catch (\Throwable $e) {
            logger()->warning('Failed to auto-generate API Excel: ' . $e->getMessage());
        }
    }
}
