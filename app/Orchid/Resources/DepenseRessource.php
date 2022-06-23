<?php

namespace App\Orchid\Resources;

use App\Models\Depense;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\TD;

class DepenseRessource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Depense::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Relation::make('id_cat_1')
                    ->title('Catégorie 1')
                    ->required()
                    ->placeholder('Première catégorie')
                    ->help('Vous êtes obliger de choisir la prémière catégorie')
                    ->fromModel(Depense::class,'libelle','id')
                    ->displayAppend('full'),

                Relation::make('id_cat_2')
                    ->title('Catégorie 2')
                    ->placeholder('Deuxième catégorie')
                    ->help('Choix optionnel de la deuxième categorie')
                    ->fromModel(Depense::class,'libelle','id')
                    ->displayAppend('full'),
                ]),

                Input::make('numero')
                    ->title('Numéro')
                    ->placeholder("Saisisez le numéro du type de depense")
                    ->help('Nouveau numéro'),
                Group::make([
                    Input::make('libelle')
                        ->title('Libellé')
                        ->placeholder("Saisisez le libellé du type de depense")
                        ->help('Nouveau liebellé'),
                    Input::make('sigle')
                        ->title('Signe')
                        ->placeholder("Saisisez le sigle du type de depense")
                        ->help('Nouveau sigle'),
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
            TD::make('id_cat_1','Catégorie 1'),
            TD::make('id_cat_2','Catégorie 2'),
            TD::make('numero','Numero'),
            TD::make('libelle','Libellé'),
            TD::make('created_at', 'Date de création')
                ->render(function ($model) {

                    return $model->created_at->toDateTimeString();
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
        return [


        ];
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
