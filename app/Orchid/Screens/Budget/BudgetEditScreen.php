<?php

namespace App\Orchid\Screens\Budget;

use App\Models\Annee;
use App\Models\Budget;
use App\Models\Depense;
use App\Orchid\Layouts\Budget\BudgetRealocatListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BudgetEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Editer Budget';
    public $description = 'Editer la ligne Budgétaire';
    public $budget;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Budget $budget): array
    {
        // dd(Budget::where('id_depense',1)->first()->prevision);
        $this->budget = $budget;
        return [
            'budget' => $budget,
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
            // Button::make(__('Réallocate'))
            // ->icon('check')
            // ->type(Color::SUCCESS())
            // ->confirm(__("cette Opération va soustraire du fond dans une ligne budgétaire pour l'affecter dans une autre ligne. voullez-vous continuer?"))
            // ->method('reallocate'),
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
            Layout::rows([
                Group::make([
                    Relation::make('budget.id_annee')
                        ->title('Année')
                        ->required()
                        ->disabled()
                        ->placeholder("Choix de l'année.")
                        ->help("Vous êtes obliger de choisir l'année")
                        ->fromModel(Annee::class,'libelle','id')
                        ->empty('No select'),

                    Relation::make('budget.id_depense')
                        ->title('Type de depense')
                        ->required()
                        ->disabled()
                        ->placeholder('Choix du type de dépense.')
                        ->help('Vous êtes obliger de choisir le type de depense')
                        ->fromModel(Depense::class,'libelle','id')
                        ->displayAppend('full')
                        ->empty('No select'),
                    ]),
                    Group::make([
                        Input::make('budget.prevision')
                            ->title('Prévision')
                            ->placeholder("Saisisez le montant prévu pour ce type de depense")
                            ->readonly()
                            ->help('Nouveau montant'),
                        Input::make('budget.realistion')
                            ->title('Réallisation')
                            ->readonly()
                            ->help("Niveau de réalistion du type de depense"),
                        ]),
            ]),
            BudgetRealocatListener::class

        ];
    }

    public function asyncRealocate(int $ligne = null,int $soutrahend = null)
    {

        return [
            'ligne' => $ligne,
            'soutrahend' => $soutrahend,

        ];
    }


    public function reallocate(Request $request){

        // recuperer l'ID et l' de la ligne budgétaire concernée
        $fullURL = URL::full();
        // preg_match('/\/([\+\-]?\d+\.?\d*)\//', $fullURL, $matches);
        preg_match_all('/\/([\+\-]?\d+\.?\d*)\//', $fullURL, $matches);

        $ligne_id = $matches[1][0];
        $id_annee = $matches[1][1];

        // dd($id_annee,$ligne_id);

        // La ligne oû on doit sustraire
        $ligne_sub = Budget::where('id_depense',$request->input('ligne'))->where('id_annee',$id_annee)->first();

        // la ligne à réallouer
        $ligne_plus = Budget::where('id',$ligne_id)->where('id_annee',$id_annee)->first();

        $max = $ligne_sub->prevision;
        // dd($max);
        $validated = $request->validate([
            'soutrahend' => 'required|max:'.$max,
            'reste' => 'min:0',
        ]);

        if ($request->input('reste') > 0) {
            $ligne_sub->prevision = $ligne_sub->prevision - $request->input('soutrahend');

            $ligne_plus->prevision = $ligne_plus->prevision + $request->input('soutrahend');

            $ligne_sub->save();
            $ligne_plus->save();

            Toast::info('La ligne a été réallouée avec succès');
        }else {
            Toast::error('Vous tentez de retirer une somme supérieur à la prévision. Veillez introduire une valeur inferieur à la prévision.');
        }




        return redirect()->back();
    }
}
