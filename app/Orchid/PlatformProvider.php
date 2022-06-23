<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Demande;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            // Menu::make('Example screen')
            //     ->icon('monitor')
            //     ->route('platform.example')
            //     ->title('Navigation')
            //     ->badge(function () {
            //         return 6;
            //     }),

            // Menu::make('Dropdown menu')
            //     ->icon('code')
            //     ->list([
            //         Menu::make('Sub element item 1')->icon('bag'),
            //         Menu::make('Sub element item 2')->icon('heart'),
            //     ]),

            // Menu::make('Basic Elements')
            //     ->title('Form controls')
            //     ->icon('note')
            //     ->route('platform.example.fields'),

            // Menu::make('Advanced Elements')
            //     ->icon('briefcase')
            //     ->route('platform.example.advanced'),

            // Menu::make('Text Editors')
            //     ->icon('list')
            //     ->route('platform.example.editors'),

            // Menu::make('Overview layouts')
            //     ->title('Layouts')
            //     ->icon('layers')
            //     ->route('platform.example.layouts'),

            // Menu::make('Outils des Statistiques')
            //     ->icon('bar-chart')
            //     ->route('platform.example.charts'),

            // Menu::make('Cards')
            //     ->icon('grid')
            //     ->route('platform.example.cards')
            //     ->divider(),

            // Menu::make('Documentation')
            //     ->title('Docs')
            //     ->icon('docs')
            //     ->url('https://orchid.software/en/docs'),

            // Menu::make('Changelog')
            //     ->icon('shuffle')
            //     ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
            //     ->target('_blank')
            //     ->badge(function () {
            //         return Dashboard::version();
            //     }, Color::DARK()),

            Menu::make("Présentation de l'application")
            ->title('Note')
            ->icon('map')
            ->route('platform.presentation')
            ->divider(),

            Menu::make('Statistiques des demandes')
                ->title('Outils Statistiques')
                ->icon('graph')
                ->route('platform.demandes.charts'),

            Menu::make('Statistiques des services')
                ->icon('bar-chart')
                ->route('platform.services.charts')
                ->divider(),


            Menu::make(__('Les Demandes'))
                ->icon('note')
                ->route('platform.demandes.list')
                ->badge(function () {
                    return !Auth::user()->hasAccess('platform.autorisation.ReceiveMessage') ? Demande::where('user_id',Auth::user()->id)->count() : '';
                })
                ->title(__('Ressources')),

            Menu::make(__('Les Services'))
                ->icon('list')
                ->route('platform.services.list')
                ->permission('platform.systems.users'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),





        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('Interface'))
                ->addPermission('platform.interface.recteur', __('Recteur'))
                ->addPermission('platform.interface.SGAC', __('SGAC'))
                ->addPermission('platform.interface.SGAR', __('SGAR'))
                ->addPermission('platform.interface.SGAD', __('SGAD'))
                ->addPermission('platform.interface.AB', __('AB'))
                ->addPermission('platform.interface.Fac', __('Fac'))
                ->addPermission('platform.interface.ED', __('Entité Dec'))
                ->addPermission('platform.interface.recteur', __('Recteur'))
                ->addPermission('platform.interface.admin', __('Admin')),
            ItemPermission::group(__('Autorisation'))
                ->addPermission('platform.autorisation.AB', __('Autorisation AB'))
                ->addPermission('platform.autorisation.Rec', __('Autorisation Recteur'))
                ->addPermission('platform.autorisation.payer', __('Payement'))
                ->addPermission('platform.autorisation.demander', __('faire une demander'))
                ->addPermission('platform.autorisation.ReceiveMessage', __('Recevoir SMS'))
                // ->addPermission('platform.autorisation.cren-k', __('CREN-K'))
                // ->addPermission('platform.autorisation.cuk', __('CUK'))
                // ->addPermission('platform.autorisation.chm', __('CHM'))
                // ->addPermission('platform.autorisation.gsm', __('GSM'))
                // ->addPermission('platform.autorisation.cnpp', __('CNPP'))
                // ->addPermission('platform.autorisation.esp', __('ESP'))
                // ->addPermission('platform.autorisation.itm', __('ITP')),


        ];
    }
}
