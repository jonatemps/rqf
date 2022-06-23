<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class ProfilePasswordLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Password::make('old_password')
                ->placeholder(__('Entrez le mot de passe actuel'))
                ->title(__('mot de passe actuel'))
                ->help("Il s'agit de votre mot de passe défini pour le moment."),

            Password::make('password')
                ->placeholder(__('Saisissez le mot de passe à définir'))
                ->title(__('Nouveau mot de passe')),

            Password::make('Confirmation mot de passe')
                ->placeholder(__('Saisissez le mot de passe à définir'))
                ->title(__('Confirmer le nouveau mot de passe'))
                ->help('Un bon mot de passe comporte au moins 15 caractères ou au moins 8 caractères, dont un chiffre et une lettre minuscule.'),
        ];
    }
}
