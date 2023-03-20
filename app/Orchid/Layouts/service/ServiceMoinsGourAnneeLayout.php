<?php

namespace App\Orchid\Layouts\Service;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceMoinsGourAnneeLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = '';
    protected $k=0;
    function __construct($data) {
        $this->target=$data;
    }
    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {return [

        TD::make('id', 'ID')
        ->width('150')
        ->render(function ($demande) {
            $this->k++;
            $i= rand(1,510);
                // Please use view('path')
                return "<img src='https://picsum.photos/450/200?random={$i}'
                      alt='sample'
                      class='mw-100 d-block img-fluid'>
                    <span class='small text-muted mt-1 mb-0'># {$this->k}</span>";
        }),

        TD::make('service', 'Service')
            ->width('450')
            ->render(function ($demande) {
                return $demande->Service;
            }),

        TD::make('montant', 'Somme')
            ->render(function ($demande) {
                return number_format($demande->somme, 2,',','.').' $';
            }),

        TD::make('nombre', 'Total demandes'),
        ];
    }
}
