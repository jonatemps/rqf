<?php

namespace App\Orchid\Layouts;

use App\Models\Service;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'services';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id','Id'),
            TD::make('code_service','Code'),
            TD::make('sigle','Nom'),
            TD::make('name','Signe'),
            TD::make('seceur_id','Secteur')
            ->render(function (service $service) {
                // dd($service);
                return $service->secteur->nom ?? '';
            }),
            // TD::make('created_at')->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (service $service) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Editer'))
                                ->route('platform.service.edit', $service->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Une fois le service supprimé, toutes ses ressources et ses données seront supprimées définitivement. Avant de supprimer votre service, interrogez-vous sur la validié de votre action.'))
                                ->method('remove', [
                                    'id' => $service->id,
                                ])
                        ]);
                }),
        ];
    }


/**
 * @return string
 */
protected function textNotFound(): string
{
    return __('Il n\'y a pas d\'enregistrement dans cette table.');
}

}
