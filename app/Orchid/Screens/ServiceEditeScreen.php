<?php

namespace App\Orchid\Screens;

use App\Models\service;
use App\Orchid\Layouts\ServiceEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ServiceEditeScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Nouveau service';
    public $description = 'Un formulaire d\ajout du service';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(service $service): array
    {
        // dd($service);
        return [
            'service' => $service
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::block(ServiceEditLayout::class)
                ->title(__('Information du service'))
                ->description(__('Saaisisez les information requise dans chaque champs.'))
                ->commands(
                    Button::make(__('Enregistrer'))
                        ->type(Color::INFO())
                        ->icon('check')
                        // ->canSee($this->user->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(service $service,Request $request){

        $service->fill($request->get('service'));

        $service->save();

        if ( $service->exists) {
            Toast::info('Service modifié avec succes !');
        }else {
            Toast::info('Service sauvegardé avec succes !');
        }


        return redirect()->route('platform.services.list');
    }
}
