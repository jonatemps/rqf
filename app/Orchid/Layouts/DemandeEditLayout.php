<?php

namespace App\Orchid\Layouts;

use App\Models\Depense;
use App\Models\service;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class DemandeEditLayout extends Rows
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
            Input::make('demande.id')
                    ->type('hidden'),
            Input::make('demande.montant')
                ->required()
                ->title('Montant')
                ->placeholder('Le montant solicité ')
                ->help('Saissisez le montant en dollar américain')
                // ->disabled(!Auth::user()->hasAccess('platform.autorisation.demander'))
                ,
            Group::make([

                Relation::make('demande.depense_id')
                    ->title('Type de depense')
                    ->required()
                    ->placeholder('Choix du type de dépense.')
                    ->help('Vous êtes obliger de choisir le type de depense')
                    ->fromModel(Depense::class,'libelle','id')
                    ->displayAppend('full'),

                Select::make('demande.type_document')
                    ->required()
                    ->options([
                        '' => '',
                        'devis'  => 'Devis',
                        'pro format'  => 'Pro format',
                        'autres'  => 'Autres',

                    ])
                    ->title('Type de document')
                    ->help('Selectionnez le motif de la demande.')
                    ->empty('No select')
                    // ->disabled(!Auth::user()->hasAccess('platform.autorisation.demander'))
                    ,
                ]),

            TextArea::make('demande.description')
                    ->rows(6)
                    ->title('Description')
                    ->popover('Saisisez la description')
                    // ->disabled(!Auth::user()->hasAccess('platform.autorisation.demander'))
                    ,
        ];
    }
}
