<?php

namespace App\Orchid\Resources;

use App\Models\Annee;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class AnneeRessource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Annee::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('libelle')
                    ->mask('9999')
                    ->title('libelle')
                    ->placeholder("Saisisez le libellé de l'année")
                    ->help('Nouvelle année'),

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
            TD::make('id','Id'),
            TD::make('libelle','Libellé'),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
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
