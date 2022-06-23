<?php

namespace App\Orchid\Layouts\service;

use App\Models\VueTopDemande5ans;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Screen\Repository;

class DemandeMoisServiceLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'top_services_gourm_annee';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('id', 'ID')
            ->width('150')
            ->render(function ($demande) {
                // Please use view('path')
                return "<img src='https://picsum.photos/450/200?random={$demande->somme}'
                      alt='sample'
                      class='mw-100 d-block img-fluid'>
                    <span class='small text-muted mt-1 mb-0'># {$demande->id}</span>";
            }),

        TD::make('service', 'Service')
            ->width('450')
            ->render(function ($demande) {
                return $demande->service;
            }),

        TD::make('montant', 'Somme')
            ->render(function ($demande) {
                return number_format($demande->somme, 2,',','.').' $';
            }),

        TD::make('nombre', 'Total demandes'),
        ];
    }
}
