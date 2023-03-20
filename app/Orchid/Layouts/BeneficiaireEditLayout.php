<?php

namespace App\Orchid\Layouts;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class BeneficiaireEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    public $beneficiaire,$path;

    public function __construct($benef,$path)
    {
        $this->demande = $benef;
        $this->path = $path;
    }

    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {

        return [
            Input::make('demande.beneficiaire.id')
                    ->type('hidden'),
            Input::make('demande.beneficiaire.demande_id')
                ->type('hidden'),
            Group::make([
                Input::make('demande.beneficiaire.nom_complet')
                ->required()
                ->title('Nom Complet')
                ->placeholder('Nom du bénéficiaire.')
                ->help('Saisisez le nom du bénéficiaire.')
                // ->disabled(!Auth::user()->hasAccess('platform.autorisation.demande.beneficiairer'))
                ,
            Relation::make('demande.beneficiaire.service_id')
                    ->fromModel(Service::class,'name', 'id')
                    ->title(__('Service'))
                    ->help('Choisissez le service du bénéficiare.')
                    ->required()
                    ->empty('No select'),
            ]),
            Upload::make('demande.beneficiaire.carteId')
                    ->groups('CarteId')
                    ->maxFiles(1)
                    ->title("Carte d'identité")
                    ->acceptedFiles('.pdf')
                    ->required(),
            Group::make([
                Link::make(__("Voir la carte d'Identité"))
                        ->icon('eye')
                        ->type(Color::INFO())
                        ->href(route('download.file',['link' =>$this->path]))
                        ->canSee($this->demande->exists),
            ])->autoWidth(),
        ];
    }
}
