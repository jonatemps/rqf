<?php

namespace App\Orchid\Screens\Charts;

use Orchid\Screen\Screen;

class DemandeServiceScree extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Graphiques des demandes';
    public $description = "L'essentiel des graphiques concernat les demandes.";

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
