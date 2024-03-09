<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            base_path('node_modules/bootstrap-icons/font/bootstrap-icons.css') => public_path('datatables/bootstrap-icons/font/bootstrap-icons.css'),
            base_path('node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css') => public_path('datatables/datatables.net-bs5/css/dataTables.bootstrap5.min.css'),
            base_path('node_modules/datatables.net-select-bs5/css/select.bootstrap5.css') => public_path('datatables/datatables.net-select-bs5/css/select.bootstrap5.css'),
            base_path('node_modules/datatables.net/js/dataTables.min.js') => public_path('datatables/datatables.net/js/jquery.dataTables.js'),
            base_path('node_modules/datatables.net/types/types.d.ts') => public_path('datatables/datatables.net/types/types.d.ts'),
            base_path('node_modules/datatables.net-buttons/js/dataTables.buttons.js') => public_path('datatables/datatables.net-buttons/js/dataTables.buttons.js'),
            base_path('node_modules/datatables.net-buttons-bs5/js/buttons.bootstrap5.js') => public_path('datatables/datatables.net-buttons-bs5/js/buttons.bootstrap5.js'),
            base_path('node_modules/datatables.net-buttons/js/buttons.html5.js') => public_path('datatables/datatables.net-buttons/js/buttons.html5.js'),
            base_path('node_modules/datatables.net-buttons/js/buttons.print.js') => public_path('datatables/datatables.net-buttons/js/buttons.print.js'),
        ], 'datatable');

        $this->publishes([
            base_path('vendor/tinymce/tinymce') => public_path('plugins/js/tinymce'),
        ], 'tinymce');
    }
}
