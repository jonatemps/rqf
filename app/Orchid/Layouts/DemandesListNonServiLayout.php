<?php

namespace App\Orchid\Layouts;

use App\Models\Demande;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DemandesListNonServiLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'sousBC';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('updated_at','Mis à jour')
                ->sort()
                ->render(function ($demande) {
                    return $demande->formatDate();
                }),
            TD::make('montant','Montant')
                ->sort()
            ->render(function ($demande) {
                // dd($demande);
                return number_format($demande->montant,2,',','.').' $';

            }),
            TD::make('beneficiaire','Beneficiaire')
                ->sort()
            ->render(function ($demande) {
                // dd($demande);
                return $demande->beneficiaire->nom_complet;
            }),
            TD::make('Service')
                ->sort()
                ->render(function ($demande) {
                    // dd($demande);
                    return $demande->user->service->name ?? '';
                }),
            TD::make('depense_id','Type de depense')
                ->render(function ($demande) {
                    // dd($demande);
                    return substr($demande->depense->libelle,0,60);
                })
                ->sort(),
            TD::make('type_document','Type de document')
                ->render(function ($demande) {
                    // dd($demande);
                    return $demande->type_document;
                })
                ->sort(),            TD::make('Autorisations')
                    ->sort()
                    ->render(function($demande){
                        return $demande->Autorisation();
                    }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Demande $demande) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Editer'))
                                ->route('platform.demande.edit', $demande->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Une fois la demande supprimé, toutes ses ressources et ses données seront supprimées définitivement. Avant de supprimer votre demande, interrogez-vous sur la validié de votre action.'))
                                ->method('remove', [
                                    'id' => $demande->id,
                                ])
                                ->canSee(!($demande->autorisationAb1 || $demande->emission || $demande->transaction || $demande->user_id != Auth::user()->id)),
                        ]);
                }),
        ];
    }
}
