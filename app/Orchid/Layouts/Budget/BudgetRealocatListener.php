<?php

namespace App\Orchid\Layouts\Budget;

use App\Models\Budget;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class BudgetRealocatListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'ligne',
        'soutrahend'
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncRealocate';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::block(
                Layout::rows([
                    Relation::make('ligne')
                        ->title('Ligne Allouant')
                        ->required()
                        ->placeholder("Choix de la ligne.")
                        ->help("Vous êtes obliger de choisir la ligne où  puisez l'argent.")
                        ->fromModel(Budget::class,'id_depense','id_depense')
                        ->displayAppend('full'),
                    Group::make([
                        Input::make('prevision')
                            ->title('Prévision')
                            ->help("Privision de la ligne allouant.")
                            ->value(Budget::where('id_depense',$this->query->get('ligne'))->first()->prevision ?? '')
                            ->help('Nouveau montant'),
                        Input::make('realistion')
                            ->title('Réalisation')
                            ->value(Budget::where('id_depense',$this->query->get('ligne'))->first()->realisation ?? '')
                            // ->readonly()
                            ->help("Réalisation de la ligne allouant."),
                        ]),
                    Group::make([
                        Input::make('soutrahend')
                            ->title('Soustrahend')
                            ->type('number')
                            ->placeholder("Saisisez le Soustrahend")
                            ->help('Saisisez le terme qui soustrait.'),
                        Input::make('reste')
                            ->title('Reste')
                            ->value(
                                // Calcule du reste après avoir tapé le soustrahend
                                $this->query->get('ligne')
                                ?
                                Budget::where('id_depense',$this->query->get('ligne'))->first()->prevision -
                                Budget::where('id_depense',$this->query->get('ligne'))->first()->realisation -
                                $this->query->get('soutrahend')
                                :
                                ''
                            )
                            // ->readonly()
                            ->help("Le budget après soustraction"),
                        ]),
                ]))
                ->commands(
                    Button::make(__('Réallouer'))
                        ->type(Color::SUCCESS())
                        ->icon('check')
                        ->confirm(__("cette Opération va soustraire du fond dans une ligne budgétaire pour l'affecter dans une autre ligne. voullez-vous continuer?"))
                        // ->canSee($this->user->exists)
                        ->method('reallocate')
                )
            ->title('Réalocation Budgétaire')
            ->description("Réalouez le surplus d'une ligne budgétaire à une autre."),


        ];
    }


}
