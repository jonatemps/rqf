<?php

namespace App\Orchid\Screens;

use App\Models\Service;
use App\Orchid\Layouts\ServiceListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ServiceScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Les services';
    public $description = 'La liste de tout les services de l\'université';
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        // dd(service::paginate());
        return [
            'services' => service::paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('ajouter'))
                ->icon('plus')
                ->route('platform.service.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            ServiceListLayout::class
        ];
    }
}
