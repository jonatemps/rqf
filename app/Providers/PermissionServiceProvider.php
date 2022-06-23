<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
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
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::group('modules')
            ->addPermission('platform.autorisation.AB', 'Accoder l\'autorisation de l\'administrateur de budget.')
            ->addPermission('platform.autorisation.Rec', 'Accoder l\'autorisation du recteur.')
            ->addPermission('platform.autorisation.demander', 'Unissier une demande.')
            ->addPermission('platform.autorisation.payer', 'Declarer une demande comme étant payée.');


        $dashboard->registerPermissions($permissions);
    }
}
