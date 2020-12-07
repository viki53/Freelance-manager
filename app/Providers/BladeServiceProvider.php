<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money_format', function ($expression) {
            if (str_contains($expression, ',')) {
                list($value, $currency) = explode(',', $expression, 2);
            }
            else {
                $value = $expression;
            }

            $value = trim(str_replace('\'', '', $value));
            if (empty($currency)) {
                $currency = "'EUR'";
            }

            return "<?php \$formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY); echo \$formatter->formatCurrency(floatval({$value}), $currency) ?>";
        });

        Blade::directive('number_format', function ($expression) {
            $value = $expression;

            $value = trim(str_replace('\'', '', $value));

            return "<?php \$formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::DECIMAL); echo \$formatter->format(floatval({$value})) ?>";
        });

        Blade::directive('percentage_format', function ($expression) {
            $value = $expression;

            $value = trim(str_replace('\'', '', $value));

            return "<?php \$formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::PERCENT); echo \$formatter->format(floatval({$value})) ?>";
        });
    }
}
