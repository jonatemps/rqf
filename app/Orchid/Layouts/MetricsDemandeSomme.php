<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Metric;

class MetricsDemandeSomme extends Metric
{
    /**
     * @var string
     */
    protected $target = 'metrics';

    /**
     * @var array
     */
    protected $labels = [
        'Dépenses du jours',
        'Depenses de la semaine',
        'Dépenses du mois',
        "Dépenses de l'année",
    ];
}
