<?php

namespace App\Orchid\Screens\Demande;

use App\Models\Beneficiare;
use App\Models\Budget;
use App\Models\Demande;
use App\Models\Depense;
use App\Models\Service;
use App\Models\User;
use App\Notifications\DemandFollow;
use App\Notifications\NewDemandAB1;
use App\Notifications\NewDemandAB2;
use App\Notifications\NewDemandAquitted;
use App\Notifications\NewDemandBC;
use App\Notifications\NewDemandRec;
use App\Orchid\Layouts\BControlMetrics;
use App\Orchid\Layouts\BeneficiaireEditLayout;
use App\Orchid\Layouts\DemandeEditAutorisationLayout;
use App\Orchid\Layouts\DemandeEditLayout;
use App\Orchid\Layouts\DemandeEditModaliteLayout;
use App\Orchid\Layouts\Examples\MetricsExample;
use App\Orchid\Layouts\FileUploadLayout;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

use function PHPSTORM_META\type;

class DemandeEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */

    // public $name = 'Informatins de la demande';
    public $name;
    public $description = 'Inserez les informations réquise pour chaque chanmps.';
    public $dem,$demande,$path,$code,$authAcces,$user_name,$pathBen;
    public $depense;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Demande $demande): array
    {
        $this->user_name = Auth::user()->service->nom;
        // $date =date('H-i-s');

        // $date = Carbon::now();

        // dd($demande);
        // $time = sleep(1200);
        // $this->depense = Depense::with(['categorie1','categorie2','categories','budget'])
        //                         ->where('id',$demande->depense_id)->first();
        $this->depense = Depense::with(['categorie1','categorie2','categories','budget'])->
                                whereRaw("substring('created_at',0,4) = substring('$demande->created_at',0,4)")
                                ->where('id',$demande->depense_id)
                                ->first();
        // dd($this->depense->annee());
        // dd(Depense::with(['categorie1','categorie2','categories','budget'])->
        //             whereRaw("substring('created_at',0,4) = substring('$demande->created_at',0,4)")
        //             ->where('id',$demande->depense_id)
        //             ->first());

        $this->dem = $demande;
        $this->demande = $demande;
        $this->name = 'Informations de la demande du service: '.Auth::user()->service->name;

        if (! $demande->exists) {
            $this->name = 'Creer une Nouvelle demande de fonds';
        }else {
            if ($demande->attach) {
                $this->path = $demande->attach->path.$demande->attach->name.'.'.$demande->attach->extension;
            }
            if ($demande->beneficiaire->attach) {
                $this->pathBen = $demande->beneficiaire->attach->path.$demande->beneficiaire->attach->name.'.'.$demande->beneficiaire->attach->extension;
                // dd($this->pathBen);
            }
        }

        if (isset($this->depense->budget->prevision)) {
            $soldeDispo = $this->depense->budget->prevision - $this->depense->budget->realisation;
            $soldeDisProportion = ($soldeDispo / $this->depense->budget->prevision)*100;
            $soldeNouveau =$demande->autorisationCaisse == 'Suffisant' ? $soldeDispo : ($soldeDispo - $demande->montant);
            $nouvelleRealisation = $this->depense->budget->realisation + $demande->montant;
            $depacement = ($soldeNouveau/$this->depense->budget->prevision)*100;

            $depenseMetrics = [
                // ['keyValue' => $this->depense->numero, 'keyDiff' => 0, 'bc' => 1],
                ['keyValue' => number_format($this->depense->budget->prevision, 1,',','.'), 'keyDiff' => 0, 'bc' => 1],
                ['keyValue' => number_format($this->depense->budget->realisation, 1,',','.'), 'keyDiff' => 0, 'bc' => 1],
                ['keyValue' => number_format($soldeDispo, 1,',','.'), 'keyDiff' => number_format($soldeDisProportion,1), 'bc' => 0],
                ['keyValue' => number_format($demande->montant, 1,',','.'), 'keyDiff' => 0, 'bc' => 1],
                ['keyValue' => number_format($soldeNouveau, 1,',','.'), 'keyDiff' => number_format($depacement,1), 'bc' => 0],
            ];
        }

        return [
            'demande' => $demande,
            'metrics' => $depenseMetrics ?? '',
        ];

    }


    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        // dd($this->demande->user->id == Auth::user()->id);
        return [
            Button::make('Envoiyer le message')
                    ->icon('bell')
                    ->confirm(__('En confirmant vous allez recevoir un code de validation de votre autorisation. Voulez-vous continuer ?'))
                    ->method('sendCode')
                    ->type(Color::DEFAULT())
                    ->canSee(Auth::user()->hasAccess('platform.autorisation.ReceiveMessage')),
            Button::make($this->demande->id ? 'Modifier' : 'Soumettre')
                    ->icon('check')
                    ->method('create',[$this->demande->id])
                    ->type(Color::DEFAULT())
                    ->canSee(Auth::user()->hasAccess('platform.autorisation.demander') && !($this->demande->autorisationAb1 || $this->demande->emission || $this->demande->transaction)),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        // dd(asset('storage/'.$this->path));
        // dd(storage_path().'\\app\\public\\'.str_replace('/','\\',$this->path));
        // dd(service::whereHas('secteur', function($q){
        //     $q->where('id', Auth::user()->service->secteur->id);
        // })->get());
        // dd(Auth::user()->service->secteur->id);
        // dd($this->demande->beneficiaire->attach);
        return [
            Layout::block(new BeneficiaireEditLayout($this->demande,$this->pathBen))
                ->title(__('BENEFICIAIRE'))
                ->description(__('Fournissez les informations du bénéficiaire.')),
            Layout::block(DemandeEditLayout::class)
                ->title(__('DEMANDE'))
                ->description(__('Fournissez les informmation de la démande proprement dite.')),
            // Layout::view('pdfViewer'),
                // ->canSee(Auth::user()->hasAccess('platform.autorisation.demander'))
                Layout::view('pdfViewer',['path' => asset('storage/'.$this->path)]),
            Layout::block(Layout::view('pdfViewer',['path' => asset('storage/'.$this->path)]))
                ->title(__(strtoupper('Soubassement')))
                ->description(__('Lectu')),
            Layout::block(new FileUploadLayout($this->demande,$this->path))
                ->title(__(strtoupper('Piece jointe en PDF') ))
                ->description(__('Selectionnez le motif de la demande.')),

            // Layout::rows([
            //     Input::make('coooode')
            //         ->value(Session::get('code'))
            //         ->disabled(),

            //     Input::make('demande.file')
            //             ->type('hidden'),

            //     Upload::make('demande.file')
            //         ->groups('document')
            //         ->maxFiles(1)
            //         ->title('fichier PDF')
            //         ->acceptedFiles('.pdf')
            //         ->horizontal()
            //         ->required()
            //         ->canSee(Auth::user()->hasAccess('platform.autorisation.demander') && !$this->demande->exists),

            //         Group::make([
            //             Link::make(__('Voir le Fichier'))
            //                     ->route('pdf.viewer',['path' => str_replace('/','-',$this->path)])
            //                     ->icon('eye')
            //                     ->type(Color::INFO())
            //                     ->canSee($this->demande->exists),
            //             Link::make(__('Télécharger le Fichier'))
            //                     // ->route('platform.systems.users.edit', 46)
            //                     ->href(route('download.file',['link' =>$this->path]))
            //                     ->icon('cloud-download',)
            //                     ->type(Color::DEFAULT())
            //                     ->canSee($this->demande->exists),
            //         ])->autoWidth(),
            // ])->title(__('La Pièce jointe PDF')),

            // Layout::rows([

            //     TextArea::make('demande.description')
            //         ->required()
            //         ->rows(6)
            //         ->title('Description')
            //         ->popover('Saisisez la description')
            //         ->disabled(!Auth::user()->hasAccess('platform.autorisation.demander')),
            // ]),

            // Layout::rows(
            //     MetricsExample::class
            // )->title('Input mask'),
            Layout::accordion([
                'BUDGET CONTOLE' => BControlMetrics::class,
            ])->canSee(isset($this->depense->budget->prevision) && Auth::user()->hasAccess('platform.autorisation.ReceiveMessage')),
            Layout::block(DemandeEditModaliteLayout::class)
                ->title(__(strtoupper('Modalités de payement')))
                ->description(__('Selectionnez les modalités de payement.'))
                ->commands(
                    [
                        Button::make('Soumettre')
                        ->type(Color::INFO())
                        ->method('create')
                        ->icon('full-screen')
                        ->canSee(Auth::user()->InRole('AB') && Session::get('authAcces')),

                        ModalToggle::make('Valider le code')
                        ->type(Color::INFO())
                        ->modal('validatiCode')
                        ->method('validateSMS')
                        ->icon('full-screen')
                        ->canSee(Auth::user()->InRole('AB') && !Session::get('authAcces'))
                    ]
                )
                ->canSee(isset($this->demande->id)),

            Layout::block(Layout::view('autorisation',[$this->demande]))
                ->title(__(strtoupper('Les Autorisations et finances')))
                ->description(__('Accordez l\'Autorisation selon votre tittre et qualité.'))
                ->commands(
                    [
                        Button::make('Soumettre')
                        ->type(Color::INFO())
                        ->method('create')
                        ->icon('full-screen')
                        ->canSee(Auth::user()->hasAccess('platform.autorisation.ReceiveMessage') && Session::get('authAcces')),

                        ModalToggle::make('Valider le code')
                        ->type(Color::INFO())
                        ->modal('validatiCode')
                        ->method('validateSMS')
                        ->icon('full-screen')
                        ->canSee(Auth::user()->hasAccess('platform.autorisation.ReceiveMessage') && !Session::get('authAcces'))
                    ]
                )
                ->canSee(isset($this->demande->id)),

                Layout::modal('validatiCode', Layout::rows([
                    Input::make('code')
                        ->title('Code de validation')
                        ->placeholder('Tapez le code ici.')
                        ->help("Le code vous a été envoyé par SMS.")
                        ->required(),
                ]))->title('SAISISEZ LE CODE RECU PAR SMS.')
                ->applyButton('Valider')
                ->closeButton('Fermer'),
        ];
    }

    public function create(Demande $demande,Request $request){

        $this->demande = Demande::find($demande->id);

        $request->validate([
            'demande.file' => ['required'],
        ]);



        if ($request->input('demande')['file'][0]) {
            $attach = $request->input('demande')['file'][0];
        }

        // dd($request->input('demande')['file'][0]);

        foreach ($request->input() as $key => $value) {
            if (($key != 'demande' & $key != '0')) {
                $autorisations[$key] = $value;
            }
        }

        foreach ($request->get('demande') as $key => $value) {
            if (($key != 'beneficiaire')) {
                $demandeInput[$key] = $value;
            }
        }

        if ( $demande->exists) {
            // $demande->emission = $request->demande['emission'] ?? '';
            // $demande->transaction = $request->demande['transaction'] ?? '';
            $demande->fill($demandeInput);
            $demande->file = $attach;
            // dd($demande->file);
            // Ajout de la réalisation
            if (isset($autorisations['autorisationCaisse'])) {
                $budget = Budget::where('id_depense',$demande->depense->budget->id_depense)->first();
                if ($demande->autorisationCaisse != 'Suffisant' && $autorisations['autorisationCaisse'] == 'Suffisant') {
                    $budget->realisation += (int)$demande->montant;
                }elseif ($demande->autorisationCaisse == 'Suffisant' && $autorisations['autorisationCaisse'] == 'Insuffisant') {
                    $budget->realisation -= (int)$demande->montant;
                }
                // dd($budget);
                $budget->save();
            }

            $demande->fill($autorisations);
            // dd($demande,$autorisations);

            // dd($budget->realisation - (int)$demande->montant,(int)$demande->montant,$budget);
            $demande->save();


            $beneficiaire = Beneficiare::find($demande->beneficiaire->id);
            $beneficiaire->demande_id = $demande->id;
            $beneficiaire->nom_complet = $request->demande['beneficiaire']['nom_complet'];
            $beneficiaire->service_id = $request->demande['beneficiaire']['service_id'];
            $beneficiaire->carteId = $request->demande['beneficiaire']['carteId'][0];

            $beneficiaire->save();
        }else {
            $demande->user_id = Auth::user()->id;
            $demande->fill($demandeInput);
            $demande->file = $attach;
            $demande->save();

            $beneficiaire = new Beneficiare();

            $beneficiaire->demande_id = $demande->id;
            $beneficiaire->nom_complet = $request->demande['beneficiaire']['nom_complet'];
            $beneficiaire->service_id = $request->demande['beneficiaire']['service_id'];
            $beneficiaire->carteId = $request->demande['beneficiaire']['carteId'][0];

            $beneficiaire->save();
        // dd($demande,$beneficiaire);

        }
        // dd($demande,$beneficiaire);



        $AB = User::whereHas('roles',function($query){
            $query->where('slug','AB');
        })->first();
        $Recteur = User::whereHas('roles',function($query){
            $query->where('slug','Recteur');
        })->first();
        $caissier = User::whereHas('roles',function($query){
            $query->where('slug','caissier');
        })->first();


        // Les notifications

        if (!$this->demande && $demande) {
            // dd([$this->demande,$demande]);
            $AB->notify(new NewDemandAB1($demande));
            // $demande->user->notify(new DemandFollow($demande));
        } else if ($this->demande) {
            // if the demande have the first autorisation of AB, send notification to Receur
            if ($demande->autorisationAb1 == 'Accorder' && !$demande->autorisationRec) {
                $Recteur->notify(new NewDemandRec($demande));
            }

            // envoyer la notification si AB a mis sa première signature et que le recteur pas encore
            if ($demande->autorisationAb1 && !$demande->autorisationRec) {
                $demande->user->notify(new DemandFollow($demande));

                // send the notification when the type of emission or type of transaction is added in the demande
            }elseif ((!$this->demande->emission && $demande->emission) || (!$this->demande->transaction && $demande->transaction)) {
                $demande->user->notify(new DemandFollow($demande));

                // envoyer la notification tant que le recteur a mis sa signature et l'AB n'a pas mis sa deuxieme signature
            }elseif ($demande->autorisationRec && !$demande->autorisationAb2) {
                $AB->notify(new NewDemandAB2($demande));
                $demande->user->notify(new DemandFollow($demande));
            // }elseif (!$this->demande->autorisationRec && $demande->autorisationRec) {
            //     $AB->notify(new NewDemandAB2($demande));
            //     $demande->user->notify(new DemandFollow($demande));
            }elseif (!$this->demande->autorisationAb2 && $demande->autorisationAb2) {
                $caissier->notify(new NewDemandBC($demande));
                $demande->user->notify(new DemandFollow($demande));
            }elseif (!$this->demande->autorisationCaisse && $demande->autorisationCaisse) {
                $AB->notify(new NewDemandAquitted($demande));
                $Recteur->notify(new NewDemandAquitted($demande));
                $demande->user->notify(new DemandFollow($demande));
            }
        }

        // Save demand after sending the notificatins
        if ( isset($this->demande)) {
            Toast::info('Demande modifié avec succes !');
            return redirect()->back();
        }else {
            Toast::info('Demande sauvegardé avec succes !');
            return redirect()->route('platform.demande.edit', $demande->id);
        }

        // return redirect()->back();
        // return redirect()->route('platform.demandes.list');
    }

    public function sendCode(){

        $basic  = new \Vonage\Client\Credentials\Basic("6c7b7749", "dKwUkelaVlHpuI87");
        $client = new \Vonage\Client($basic);
        $faker = Factory::create();

        $this->code = rand(1,9).''.rand(0,9).''.rand(0,9).''.rand(0,9).''.rand(0,9);

        Session::put('code',$this->code);

        // Sending message

        // $response = $client->sms()->send(
        //     new \Vonage\SMS\Message\SMS("243813134572", BUDGET_TR, "Le code de validation est: $this->code. \n Valide pandant 20 munites")
        // );

        // $message = $response->current();

        // if ($message->getStatus() == 0) {
        //     Toast::info('Votre code a été envoyé avec succes !');
        // } else {
        //     Toast::error("L'evoie du message a échoué avec le status. ". $message->getStatus() . "\n");
        // }

        return redirect()->back();
    }

    public function validateSMS(Request $request){

        if (Session::get('code') == $request->input('code')) {

            Session::put('authAcces',true);

            Toast::info('Code valide !');
            Alert::success('<strong>Succes: 😇!!! </strong>Le code saisi est valide, Votre action a été exécuté avec <strong> succes!😇.</strong>.');
            return redirect()->back();

        } else {
            Toast::error('Code non valide, Veillez réessayer');
            Alert::error('<strong>Erreur: ⚠ !!!</strong>Le code saisi est non valide ! Veillez saisir le bon code avant son espiration dans <strong>  20 min</strong>.');
            return redirect()->back();
        }

    }
}
