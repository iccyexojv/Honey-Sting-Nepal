<?php

namespace App\Filament\Admin\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BlogPostsPieChart extends ApexChartWidget
{
    protected static ?string $chartId = 'blogPostsPieChart';

    protected static ?string $heading = 'Blog Posts Distribution';

    protected static ?int $sort = 2;

    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [44, 55, 13, 43],
            'labels' => ['Technology', 'Business', 'Health', 'Education'],
            'colors' => ['#f59e0b', '#10b981', '#3b82f6', '#ef4444'],
            'legend' => [
                'position' => 'bottom',
            ],
        ];
    }
}