<?php

namespace App\Orchid\Layouts;

use App\Models\Secteur;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class ServiceEditLayout extends Rows
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
            Input::make('service.name')
            ->type('text')
            ->max(255)
            ->required()
            ->title(__('Nom'))
            ->placeholder(__('Nom')),

            Input::make('service.sigle')
                ->type('text')
                ->required()
                ->title(__('Sigle'))
                ->placeholder(__('Sigle')),

            Input::make('service.code_service')
                ->type('text')
                ->required()
                ->title(__('Code service'))
                ->placeholder(__('Code du service')),

            Select::make('service.seceur_id')
                ->fromModel(Secteur::class, 'nom', 'id')
                ->title(__('Secteur'))
                ->required(),

            ];
        }
}
