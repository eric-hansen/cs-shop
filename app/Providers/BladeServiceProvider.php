<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Blade::directive('currency', fn ($expression) => "<?php echo(number_format($expression, 2)); ?>");
    }
}
