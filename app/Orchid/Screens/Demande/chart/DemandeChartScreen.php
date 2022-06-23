<?php

namespace App\Orchid\Screens\demande\chart;

use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ChartPercentageExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use App\Orchid\Layouts\Examples\MetricsExample;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Str;

class DemandeChartScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Statistiques des demandes';
    public $description = "L'essentiel des statistique concernat les demandes.";

    /**
     * Query data.
     *
     * @return array
     */
    public const TEXT_EXAMPLE = 'Lorem ipsum at sed ad fusce faucibus primis, potenti inceptos ad taciti nisi tristique
    urna etiam, primis ut lacus habitasse malesuada ut. Lectus aptent malesuada mattis ut etiam fusce nec sed viverra,
    semper mattis viverra malesuada quam metus vulputate torquent magna, lobortis nec nostra nibh sollicitudin
    erat in luctus.';

    public function query(): array
    {
        return [
            'charts' => [
                [
                    'name'   => 'Some Data',
                    'values' => [25, 40, 30, 35, 8, 52, 17],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'Another Set',
                    'values' => [25, 50, -10, 15, 18, 32, 27],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'Yet Another',
                    'values' => [15, 20, -3, -15, 58, 12, -17],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
                [
                    'name'   => 'And Last',
                    'values' => [10, 33, -8, -3, 70, 20, -34],
                    'labels' => ['12am-3am', '3am-6am', '6am-9am', '9am-12pm', '12pm-3pm', '3pm-6pm', '6pm-9pm'],
                ],
            ],
            'metrics' => [
                ['keyValue' => number_format(6851, 0), 'keyDiff' => 10.08],
                ['keyValue' => number_format(24668, 0), 'keyDiff' => -30.76],
                ['keyValue' => number_format(10000, 0), 'keyDiff' => 0],
                ['keyValue' => number_format(65661, 2), 'keyDiff' => 3.84],
            ],

            'table'   => [
                new Repository(['id' => 100, 'name' =>'Informatique', 'price' => 100.24, 'created_at' => '33']),
                new Repository(['id' => 200, 'name' =>'Ressources Humaines', 'price' => 65.9, 'created_at' => '4']),
                new Repository(['id' => 300, 'name' =>'Entretien', 'price' => 54.2, 'created_at' => '12']),
                new Repository(['id' => 400, 'name' =>'Dir Affaires Sociales', 'price' => 27.1, 'created_at' => '5']),
                new Repository(['id' => 500, 'name' =>'Dir Imprimerie et Librairie', 'price' => 26.15, 'created_at' => '8']),

            ],
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
            MetricsExample::class,
            Layout::columns([
                ChartLineExample::class,
                ChartBarExample::class,
            ]),

            // Layout::columns([
            //     ChartPercentageExample::class,
            //     ChartPieExample::class,
            // ]),

            Layout::tabs([
                'Top Services Gourmands 2022' =>  Layout::table('table', [
                    TD::make('id', 'ID')
                        ->width('150')
                        ->render(function (Repository $model) {
                            // Please use view('path')
                            return "<img src='https://picsum.photos/450/200?random={$model->get('id')}'
                                  alt='sample'
                                  class='mw-100 d-block img-fluid'>
                                <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>";
                        }),

                    TD::make('name', 'Service')
                        ->width('450')
                        ->render(function (Repository $model) {
                            return Str::limit($model->get('name'), 200);
                        }),

                    TD::make('price', 'Montant')
                        ->render(function (Repository $model) {
                            return '$ '.number_format($model->get('price'), 2);
                        }),

                    TD::make('created_at', 'Nombre demandes'),
                ]),
                'Top Services Gourmands 2021' => Layout::table('table', [
                    TD::make('id', 'ID')
                        ->width('150')
                        ->render(function (Repository $model) {
                            // Please use view('path')
                            return "<img src='https://picsum.photos/450/200?random={$model->get('id')}'
                                  alt='sample'
                                  class='mw-100 d-block img-fluid'>
                                <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>";
                        }),

                    TD::make('name', 'Service')
                        ->width('450')
                        ->render(function (Repository $model) {
                            return Str::limit($model->get('name'), 200);
                        }),

                    TD::make('price', 'Montant')
                        ->render(function (Repository $model) {
                            return '$ '.number_format($model->get('price'), 2);
                        }),

                    TD::make('created_at', 'Nombre demandes'),
                ]),
                'Top Services Gourmands 2020' =>Layout::table('table', [
                    TD::make('id', 'ID')
                        ->width('150')
                        ->render(function (Repository $model) {
                            // Please use view('path')
                            return "<img src='https://picsum.photos/450/200?random={$model->get('id')}'
                                  alt='sample'
                                  class='mw-100 d-block img-fluid'>
                                <span class='small text-muted mt-1 mb-0'># {$model->get('id')}</span>";
                        }),

                    TD::make('name', 'Service')
                        ->width('450')
                        ->render(function (Repository $model) {
                            return Str::limit($model->get('name'), 200);
                        }),

                    TD::make('price', 'Montant')
                        ->render(function (Repository $model) {
                            return '$ '.number_format($model->get('price'), 2);
                        }),

                    TD::make('created_at', 'Nombre demandes'),
                ]),
            ]),

        ];
    }
}
