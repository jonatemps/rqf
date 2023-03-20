<?php

namespace App\Orchid\Screens\Demande;

use App\Models\Demande;
use App\Models\User;
use App\Orchid\Layouts\DemandeMisEnEcartAB1Layout;
use App\Orchid\Layouts\DemandeMisEnEcartLayout;
use App\Orchid\Layouts\sousRecteurdeLayout;
use App\Orchid\Layouts\DemandesMisEnattenteRecLayout;
use App\Orchid\Layouts\DemandesListAtente2ABLayout;
use App\Orchid\Layouts\DemandesListAtenteRecteurLayout;
use App\Orchid\Layouts\DemandesListAttenteLayout;
use App\Orchid\Layouts\DemandesListLayout;
use App\Orchid\Layouts\DemandesListNonServiLayout;
use App\Orchid\Layouts\DemandesListNonTraiteLayout;
use App\Orchid\Layouts\DemandesListServiLayout;
use App\Orchid\Layouts\DemandesListTousLayout;
use App\Orchid\Layouts\DemandesMisEnAttentAB1Layout;
use App\Orchid\Layouts\DemandesMisEnAttentAB2Layout;
use App\Orchid\Layouts\DemandesRejeterLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DemandeListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Les demandes de fonds';
    public $description = 'une liste des demande des fonds.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        // $dem = demande::find(47);

        $demandesEttente = Demande::orderBy('created_at','DESC')->get();

        // dd($demandesEttente->where('autorisationAb2','En_attente')->get());

        if (!Auth::user()->hasAccess('platform.autorisation.ReceiveMessage')) {
            $demandes = Demande::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
            $demandesEttente = Demande::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
        } else {
            $demandes = Demande::orderBy('created_at','DESC')->get();
            $demandesEttente = Demande::orderBy('created_at','DESC')->get();
        }
        // dd($demandes);

        // dd( $demandesEttente->where('autorisationAb2','En_attente')->get());

        return [
            'tous' => $demandes,

            // 'en_attenteAB1' => $demandesEttente->where('autorisationAb1','En_attente'),
            // 'en_attenteRec' => $demandesEttente->where('autorisationRec','En_attente'),
            // 'en_attenteAB2' => $demandesEttente->where('autorisationAb2','En_attente'),

            'en_ecartAB1' => $demandesEttente->where('autorisationAb1','!=','Accorder')->where('autorisationAb1','!=',''),
            'en_ecartRec' => $demandesEttente->where('autorisationRec','!=','Accorder')->where('autorisationRec','!=',''),
            'en_ecartAB2' => $demandesEttente->where('autorisationAb2','!=','Accorder')->where('autorisationAb2','!=',''),
            'en_ecartCaisse' => $demandesEttente->where('autorisationCaisse','Insuffisant'),


            'Caisse_insuffisant' => $demandesEttente->where('autorisationCaisse','Insuffisant'),
            'rejeter' => $demandes->where('autorisationAb1','rejeter')->where('autorisationRec','rejeter')->where('autorisationAb2','rejeter'),
            'sousAB1' => $demandes->where('autorisationAb1','')->where('autorisationRec','')->where('autorisationAb2','')->where('autorisationCaisse',''),
            'sousRecteur' => $demandes->where('autorisationAb1','==','Accorder')->where('autorisationRec',''),
            'sousAB2' => $demandes->where('autorisationAb1','==','Accorder')->where('autorisationRec','==','Accorder')->where('autorisationAb2',''),
            'sousBC' => $demandes->where('autorisationAb1','==','Accorder')->where('autorisationRec','==','Accorder')->where('autorisationAb2','==','Accorder')->where('autorisationCaisse',''),
            'servi' => $demandes->where('autorisationAb1','==','Accorder')->where('autorisationRec','==','Accorder')->where('autorisationAb2','==','Accorder')->where('autorisationCaisse','==','Suffisant'),
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
            Link::make(__('Nouvelle demande'))
            ->icon('plus')
            ->route('platform.demande.create')
            ->canSee(Auth::user()->hasAccess('platform.autorisation.demander')),
        ];
    }
    public function remove(Demande $demande){
        $demande->delete();
        Toast::info(__('La demande a été supprimée avec succès'));

        return redirect()->back();
    }
    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        // dd(Auth::user()->hasAccess('platform.autorisation.AB'));
        if (Auth::user()->hasAccess('platform.autorisation.AB')) {
            return [
                Layout::tabs([
                    'Tous' => DemandesListTousLayout::class,
                    'Sous AB N°1' => DemandesListNonTraiteLayout::class,
                    'Sous Recteur' => DemandesListAtenteRecteurLayout::class,
                    'Sous AB N°2' => DemandesListAtente2ABLayout::class,
                    'Sous BC' => DemandesListNonServiLayout::class,
                    'Servi' => DemandesListServiLayout::class,
                    'Mis en Ecart' => Layout::accordion([
                        // 'Par L\'AB Niveau 1' => DemandesMisEnAttentAB1Layout::class,
                        // 'Par le Recteur' => DemandesMisEnattenteRecLayout::class,
                        // 'Par L\'AB Niveau 2' => DemandesMisEnAttentAB2Layout::class,

                        // 'Par L\'AB Niveau 1' => DemandeMisEnEcartAB1Layout::class,
                        'Par L\'AB Niveau 1' => new DemandeMisEnEcartLayout('en_ecartAB1'),
                        'Par le Recteur' => new DemandeMisEnEcartLayout('en_ecartRec'),
                        'Par L\'AB Niveau 2' => new DemandeMisEnEcartLayout('en_ecartAB2'),
                        'Trésorerie Insuffisant' => new DemandeMisEnEcartLayout('en_ecartCaisse'),
                    ]),
                ]),
            ];
        } if (Auth::user()->hasAccess('platform.autorisation.Rec')) {
            return [
                Layout::tabs([
                    'Attente du recteur' => DemandesListAtenteRecteurLayout::class,
                    'En attente N°2 du AB' => DemandesListAtente2ABLayout::class,
                    'Sous BC' => DemandesListNonServiLayout::class,
                    'Servi' => DemandesListServiLayout::class,
                    'Mis en Ecart' => Layout::accordion([
                        // 'Par L\'AB Niveau 1' => DemandesMisEnAttentAB1Layout::class,
                        // 'Par le Recteur' => DemandesMisEnattenteRecLayout::class,
                        // 'Par L\'AB Niveau 2' => DemandesMisEnAttentAB2Layout::class,

                        // 'Par L\'AB Niveau 1' => DemandeMisEnEcartAB1Layout::class,
                        'Par L\'AB Niveau 1' => new DemandeMisEnEcartLayout('en_ecartAB1'),
                        'Par le Recteur' => new DemandeMisEnEcartLayout('en_ecartRec'),
                        'Par L\'AB Niveau 2' => new DemandeMisEnEcartLayout('en_ecartAB2'),
                        'Trésorerie Insuffisant' => new DemandeMisEnEcartLayout('en_ecartCaisse'),
                    ]),
                ]),
            ];
        } if (Auth::user()->hasAccess('platform.autorisation.payer')) {
            return [
                Layout::tabs([
                    'Tous' => DemandesListTousLayout::class,
                    'Sous AB N°1' => DemandesListNonTraiteLayout::class,
                    'Sous BC' => DemandesListNonServiLayout::class,
                    'Servi' => DemandesListServiLayout::class,
                    'Mis en Ecart' => Layout::accordion([
                        // 'Par L\'AB Niveau 1' => DemandesMisEnAttentAB1Layout::class,
                        // 'Par le Recteur' => DemandesMisEnattenteRecLayout::class,
                        // 'Par L\'AB Niveau 2' => DemandesMisEnAttentAB2Layout::class,

                        // 'Par L\'AB Niveau 1' => DemandeMisEnEcartAB1Layout::class,
                        'Par L\'AB Niveau 1' => new DemandeMisEnEcartLayout('en_ecartAB1'),
                        'Par le Recteur' => new DemandeMisEnEcartLayout('en_ecartRec'),
                        'Par L\'AB Niveau 2' => new DemandeMisEnEcartLayout('en_ecartAB2'),
                        'Trésorerie Insuffisant' => new DemandeMisEnEcartLayout('en_ecartCaisse'),
                    ]),
                ]),
            ];
        } if (Auth::user()->hasAccess('platform.autorisation.demander')) {
            return [
                Layout::tabs([
                    'Tous' => DemandesListTousLayout::class,
                    'Sous AB N°1' => DemandesListNonTraiteLayout::class,
                    'Attente du recteur' => DemandesListAtenteRecteurLayout::class,
                    'En attente N°2 du AB' => DemandesListAtente2ABLayout::class,
                    'Sous BC' => DemandesListNonServiLayout::class,
                    'Servi' => DemandesListServiLayout::class,
                    'Mis en Ecart' => Layout::accordion([
                        // 'Par L\'AB Niveau 1' => DemandesMisEnAttentAB1Layout::class,
                        // 'Par le Recteur' => DemandesMisEnattenteRecLayout::class,
                        // 'Par L\'AB Niveau 2' => DemandesMisEnAttentAB2Layout::class,

                        // 'Par L\'AB Niveau 1' => DemandeMisEnEcartAB1Layout::class,
                        'Par L\'AB Niveau 1' => new DemandeMisEnEcartLayout('en_ecartAB1'),
                        'Par le Recteur' => new DemandeMisEnEcartLayout('en_ecartRec'),
                        'Par L\'AB Niveau 2' => new DemandeMisEnEcartLayout('en_ecartAB2'),
                        'Trésorerie Insuffisant' => new DemandeMisEnEcartLayout('en_ecartCaisse'),
                    ]),
                ]),
            ];
        }else {
            return [
                Layout::tabs([
                    'Tous' => DemandesListTousLayout::class,
                    'Sous AB N°1' => DemandesListNonTraiteLayout::class,
                    'Attente du recteur' => DemandesListAtenteRecteurLayout::class,
                    'En attente N°2 du AB' => DemandesListAtente2ABLayout::class,
                    'Sous BC' => DemandesListNonServiLayout::class,
                    'Servi' => DemandesListServiLayout::class,
                    'Mis en Attente' => Layout::accordion([
                        'Par L\'AB Niveau 1' => DemandesMisEnAttentAB1Layout::class,
                        'Par le Recteur' => DemandesMisEnattenteRecLayout::class,
                        'Par L\'AB Niveau 2' => DemandesMisEnAttentAB2Layout::class,
                    ]),
                ]),
            ];
        }

    }
}
