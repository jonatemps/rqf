<?php

namespace App\Orchid\Layouts\demande;

use Orchid\Screen\Layouts\Chart;

class DemandeMoisChart extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'Nombre de demandes par mois';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'bar';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'demandeMois';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
