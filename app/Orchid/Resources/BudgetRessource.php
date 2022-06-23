<?php

namespace App\Orchid\Resources;

use App\Models\Annee;
use App\Models\Budget;
use App\Models\Depense;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\TD;

class BudgetRessource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Budget::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Relation::make('id_annee')
                    ->title('Année')
                    ->required()
                    ->placeholder("Choix de l'année.")
                    ->help("Vous êtes obliger de choisir l'année")
                    ->fromModel(Annee::class,'libelle','id')
                    ->empty('No select'),

                Relation::make('id_depense')
                    ->title('Type de depense')
                    ->required()
                    ->placeholder('Choix du type de dépense.')
                    ->help('Vous êtes obliger de choisir le type de depense')
                    ->fromModel(Depense::class,'libelle','id')
                    ->displayAppend('full')
                    ->empty('No select'),
                ]),
                Group::make([
                    Input::make('prevision')
                        ->title('Prévision')
                        ->placeholder("Saisisez le montant prévu pour ce type de depense")
                        ->help('Nouveau montant'),
                    Input::make('realistion')
                        ->title('Realisation')
                        ->disabled()
                        ->help("Niveau de réalistion du type de depense"),
                    ]),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('id_annee','Année')
                ->render(function ($model) {
                    return $model->annee->libelle;
                }),
            TD::make('id_depense','Type dépense')
                ->render(function ($model) {
                    return $model->depense->libelle;
                }),
            TD::make('prevision','Prévision')
                ->render(function ($model) {
                    return number_format($model->prevision,2,',','.')  .' $';
                }),
            TD::make('realisation','Realisation')
                ->render(function ($model) {
                    return $model->realisation ? $model->realisation .'$' : '0';
                }),
            TD::make('created_at', 'Date de création')
                ->render(function ($model) {
                    return  $model->created_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    public function with(): array
    {
        return ['depense','annee'];
    }

    public static function createButtonLabel(): string
    {
        return __('Nouvelle :resource', ['resource' => static::singularLabel()]);
    }

    public static function createToastMessage(): string
    {
        return __('Nouvelle :resource a été créee!', ['resource' => static::singularLabel()]);
    }

    public static function permission(): ?string
    {
        return 'platform.interface.admin';
    }
}
