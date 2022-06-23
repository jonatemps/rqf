<?php

namespace App\Orchid\Screens\service\chart;

use App\Models\Demande;
use App\Models\ServiceGourAnnee;
use App\Models\VueTopDemande5ans;
use App\Orchid\Layouts\demande\DemandeMoisChart;
use App\Orchid\Layouts\demande\DemandeMoisServiceChart;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ChartPercentageExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use App\Orchid\Layouts\Examples\MetricsExample;
use App\Orchid\Layouts\MetricsDemandeSomme;
use App\Orchid\Layouts\service\DemandeMoisServiceLayout;
use App\Orchid\Layouts\service\ServiceGourAnneeLayout;
use App\Orchid\Layouts\service\ServiceMoinsGourAnneeLayout;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Str;


class BaseChartScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
     /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Tableau de bord';
    public $description = 'La combinaison des statistiques';
    public $targetGourm1;
    public $targetGourm2;
    public $targetGourm3;

    public $targetNonGourm1;
    public $targetNonGourm2;
    public $targetNonGourm3;
    /**
     * Query data.
     *
     * @return array
     */
    public function getCurrentYear(){
        return Carbon::now()->format('Y');
    }
    public function query(): array
    {

        // dd(Carbon::now()->subYear(2)->format('Y'));
        // dd(VueTopDemande5ans::select(DB::raw("SUM(montant) as somme,service"))
        //                     ->whereBetween('created_at', [Carbon ::now()->startOfYear(), Carbon ::now()->endOfYear()])
        //                     ->countForGroup('service')->toChart());
        // dd(VueTopDemande5ans::select(DB::raw("SUM(montant)"))->groupBy('service')->get());
        // dd(VueTopDemande5ans::select(DB::raw("SUM(montant)"))->whereBetween('created_at', [Carbon ::now()->startOfWeek(), Carbon ::now()->endOfWeek()])->get());
        $total_depenses_jours =VueTopDemande5ans::select(DB::raw("SUM(montant) as somme"))->whereDate('created_at', Carbon ::today())->first();
        $total_depenses_semaine = VueTopDemande5ans::select(DB::raw("SUM(montant) as somme"))->whereBetween('created_at', [Carbon ::now()->startOfWeek(), Carbon ::now()->endOfWeek()])->first();
        $total_depenses_mois =VueTopDemande5ans::select(DB::raw("SUM(montant) as somme"))->whereMonth('created_at', date('m'))
                                    ->whereYear('created_at', date('Y'))
                                    ->first();
        $total_depenses_annee =VueTopDemande5ans::select(DB::raw("SUM(montant) as somme"))->whereBetween('created_at', [Carbon ::now()->startOfYear(), Carbon ::now()->endOfYear()])->first();
        // dd(VueTopDemande5ans::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
        // ->whereYear('created_at', date('Y'))
        // ->groupBy('monthname')
        // ->get());
        $serviceGour1 = VueTopDemande5ans::select(DB::raw("(COUNT(*)) as nombre,sum(montant) somme,service"))
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('service')
                        ->orderBy('somme','desc')
                        ->get();
         $serviceGour2 = VueTopDemande5ans::select(DB::raw("(COUNT(*)) as nombre,sum(montant) somme,service"))
                        ->whereYear('created_at', date('Y')-1)
                        ->groupBy('service')
                        ->orderBy('somme','desc')
                        ->get();
        $serviceGour3 = VueTopDemande5ans::select(DB::raw("(COUNT(*)) as nombre,sum(montant) somme,service"))
                        ->whereYear('created_at', date('Y')-2)
                        ->groupBy('service')
                        ->orderBy('somme','desc')
                        ->get();
            //non gourmands
        $serviceNonGour1 = VueTopDemande5ans::select(DB::raw("(COUNT(*)) as nombre,sum(montant) somme,service"))
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('service')
                        ->orderBy('somme','asc')
                        ->get();
         $serviceNonGour2 = VueTopDemande5ans::select(DB::raw("(COUNT(*)) as nombre,sum(montant) somme,service"))
                        ->whereYear('created_at', date('Y')-1)
                        ->groupBy('service')
                        ->orderBy('somme','asc')
                        ->get();
        $serviceNonGour3 = VueTopDemande5ans::select(DB::raw("(COUNT(*)) as nombre,sum(montant) somme,service"))
                        ->whereYear('created_at', date('Y')-2)
                        ->groupBy('service')
                        ->orderBy('somme','asc')
                        ->get();

        return [
            'charts' => [
                [
                    'name'   => 'Rectora',
                    'values' => [25, 40, 30, 35, 8],
                    'labels' => ['Prémier ', 'Sécond ', 'Troisième ', 'Quatrième '],
                ],
                [
                    'name'   => 'Secretariat gén. Adm',
                    'values' => [25, 50, -10, 15, 18],
                    'labels' => ['Prémier ', 'Sécond ', 'Troisième ', 'Quatrième '],
                ],
                [
                    'name'   => 'Admin. Bugjet',
                    'values' => [15, 20, -3, -15, 58,],
                    'labels' => ['Prémier ', 'Sécond ', 'Troisième ', 'Quatrième '],
                ],
                [
                    'name'   => 'Academique',
                    'values' => [10, 33, -8, -3, 70,],
                    'labels' => ['Prémier ', 'Sécond ', 'Troisième ', 'Quatrième '],
                ],
            ],
            'metrics' => [
                ['keyValue' => number_format($total_depenses_jours->somme,2,',','.'), 'keyDiff' => 3.84],
                // ['keyValue' => number_format(6851, 0), 'keyDiff' => 10.08],
                ['keyValue' => number_format($total_depenses_semaine->somme,2,',','.').' $', 'keyDiff' => 10.08],
                ['keyValue' => number_format($total_depenses_mois->somme,2,',','.'), 'keyDiff' => -30.76],
                ['keyValue' => number_format($total_depenses_annee->somme,2,',','.'), 'keyDiff' => 0],
            ],
            'table'   => [
                new Repository(['id' => 100, 'name' =>'Informatique', 'price' => 100.24, 'created_at' => '33']),
                new Repository(['id' => 200, 'name' =>'Ressources Humaines', 'price' => 65.9, 'created_at' => '4']),
                new Repository(['id' => 300, 'name' =>'Entretien', 'price' => 54.2, 'created_at' => '12']),
                new Repository(['id' => 400, 'name' =>'Dir Affaires Sociales', 'price' => 27.1, 'created_at' => '5']),
                new Repository(['id' => 500, 'name' =>'Dir Imprimerie et Librairie', 'price' => 26.15, 'created_at' => '8']),

            ],
            // dd($serviceGour1),
            'total_demandes_par_annee' => VueTopDemande5ans::orderby('annee','DESC')->limit(5)->countForGroup('annee')->toChart(),
            'top_services_gourm_annee1' => $serviceGour1,
            $this->targetGourm1='top_services_gourm_annee1',
            'top_services_gourm_annee2' => $serviceGour2,
            $this->targetGourm2 = 'top_services_gourm_annee2',
            'top_services_gourm_annee3' => $serviceGour3,
            $this->targetGourm3 = 'top_services_gourm_annee3',

            'top_services_non_gourm_annee1' => $serviceNonGour1,
            $this->targetNonGourm1='top_services_non_gourm_annee1',
            'top_services_non_gourm_annee2' => $serviceNonGour2,
            $this->targetNonGourm2 = 'top_services_non_gourm_annee2',
            'top_services_non_gourm_annee3' => $serviceNonGour3,
            $this->targetNonGourm3 = 'top_services_non_gourm_annee3',

            // WHERE YEAR(d.created_at)=YEAR(NOW()) GROUP BY s.name ORDER BY somme DESC LIMIT 5
            'demandeMois' => VueTopDemande5ans::select(DB::raw("(COUNT(*)) as count,montant"),DB::raw("MONTHNAME(created_at) as monthname"))->orderBy('monthname')
                        ->whereYear('created_at', date('Y'))
                        ->countForGroup('monthname')->toChart(),
            'demandeMoisService' => VueTopDemande5ans::select(DB::raw("(COUNT(*)) as count as somme,service"))
                ->whereBetween('created_at', [Carbon ::now()->startOfYear(), Carbon ::now()->endOfYear()])
                ->countForGroup('service')->toChart(),
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
     * @throws \Throwable
     *
     * @return string[]|\Orchid\Screen\Layout[]
     *
     */
    public function layout(): array
    {
         $Year1 = intval($this->getCurrentYear());
         $Year2 = $Year1-1;
         $Year3 = $Year1-2;

        return [
            MetricsDemandeSomme::class,
            // MetricsExample::class,
            Layout::columns([
                ChartLineExample::class,
                ChartBarExample::class,
            ]),
            Layout::columns([
                DemandeMoisChart::class,
            ]),
            DemandeMoisServiceChart::class,
            // MetricsExample::class,
            Layout::tabs([
                    "Top Services Gourmands  $Year1" => new ServiceGourAnneeLayout($this->targetGourm1),
                    "Top Services Gourmands $Year2" => new ServiceGourAnneeLayout( $this->targetGourm2),
                    "Top Services Gourmands $Year3" => new ServiceGourAnneeLayout( $this->targetGourm3),
                ]),
                Layout::tabs([
                    "Top Services moins Gourmands  $Year1" => new ServiceMoinsGourAnneeLayout($this->targetNonGourm1),
                    "Top Services moins Gourmands $Year2" => new ServiceMoinsGourAnneeLayout( $this->targetNonGourm2),
                    "Top Services moins Gourmands $Year3" => new ServiceMoinsGourAnneeLayout( $this->targetNonGourm3),
                ]),
            Layout::columns([
                ChartPieExample::class,
            ]),
        ];
    }
}
