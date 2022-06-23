<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Metric;

class BControlMetrics extends Metric
{
    // protected $depense = 'metrics';
    protected $engagement = 'metrics';

    /**
     * Get the labels available for the metric.
     *
     * @return array
     */
    protected $target = 'metrics';

    /**
     * @var array
     */
    protected $labels = [
        // 'Imputation',
        'Crédit initial',
        'Engagement antérieur',
        "Solde disponible",
        "Engagement déméndé",
        'Nouveau solde',

    ];
}
