<?php

namespace App\Orchid\Layouts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class FileUploadLayout extends Rows
{
    public $demande,$path;

    public function __construct($dem,$path)
    {
        $this->demande = $dem;
        $this->path = $path;
    }

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
                Label::make('Code')
                        ->title('Code :')
                        ->value(Session::get('code'))
                        ->canSee(!empty(Session::get('code'))),

                Input::make('demande.file')
                        ->type('hidden'),

                Upload::make('demande.file')
                    ->groups('document')
                    ->maxFiles(1)
                    ->title('fichier PDF')
                    ->acceptedFiles('.pdf')
                    // ->horizontal()
                    ->required()
                    ->canSee(Auth::user()->hasAccess('platform.autorisation.demander') && !($this->demande->autorisationAb1 || $this->demande->emission || $this->demande->transaction)),

                    Group::make([
                        Link::make(__('Voir la pièce jointe'))
                                ->icon('eye')
                                ->type(Color::INFO())
                                ->href(route('download.file',['link' =>$this->path]))
                                ->canSee($this->demande->exists),

                    ])->autoWidth(),
        ];
    }
}
