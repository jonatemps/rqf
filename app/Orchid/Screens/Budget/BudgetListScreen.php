<?php

namespace App\Orchid\Screens\Budget;

use Orchid\Screen\Screen;

class BudgetListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Budget';
    public $description = 'La liste des lignes Budgétaires';

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
