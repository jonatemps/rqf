<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Models\service;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Nom complet'))
                ->placeholder(__('Nom complet')),
            Select::make('user.service_id')
                    ->fromModel(service::class, 'sigle', 'id')
                    ->title(__('Service'))
                    ->required()
                    ->empty('No select'),
            Input::make('user.telephone')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Téléphone'))
                ->placeholder(__('Téléphone')),
            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
