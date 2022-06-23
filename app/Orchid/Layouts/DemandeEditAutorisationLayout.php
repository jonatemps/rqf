<?php

namespace App\Orchid\Layouts;

use App\Orchid\Screens\Demande\DemandeEditScreen;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Rows;

class DemandeEditAutorisationLayout extends Rows
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
            CheckBox::make('demande.AutorisationAb1')
                ->sendTrueOrFalse()
                ->title('Les autorisatios de l\'administrateur du Budget.')
                ->placeholder('Prémière Autorisation')
                ->disabled(!Auth::user()->hasAccess('platform.autorisation.AB')),

            CheckBox::make('demande.AutorisationAb2')
                ->sendTrueOrFalse()
                ->placeholder('Deuxième Autorisation')
                ->disabled('demande.AutorisationRec'== 0),

            CheckBox::make('demande.AutorisationRec')
                ->sendTrueOrFalse()
                ->title('L\'autorisatios du recteur.')
                ->placeholder('Autorisation')
                ->disabled(!Auth::user()->hasAccess('platform.autorisation.Rec')),

        ];
    }
}
