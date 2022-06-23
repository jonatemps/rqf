<?php

namespace App\Orchid\Layouts;

use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Layouts\Rows;

class DemandeEditModaliteLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Group::make([
                Select::make('demande.emission')
                ->options([
                    'totalite'  => 'Totalité',
                    'tranche'  => 'Tranches',
                    'autres'  => 'Autres',

                ])
                ->title('Type d\'Emission')
                ->help('Selectionnez le type d\'émission financière')
                ->empty('No select')
                ->disabled(!Auth::user()->hasAccess('platform.autorisation.AB')),

            ]),

            Group::make([
                Select::make('demande.transaction')
                ->options([
                    'caisse'  => 'Par caisse',
                    'banque'  => 'Par banque',
                    'cellule'  => 'Cellule',
                ])
                ->empty('No select')
                ->title('Type de Transaction')
                ->help('Selectionnez le type de transaction')
                ->disabled(!Auth::user()->hasAccess('platform.autorisation.AB')),

            ]),

        ];
    }
}
