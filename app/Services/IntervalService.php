<?php

namespace App\Services;

use App\Models\OpeningHour;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;

class IntervalService
{
    public function generateInterval(string $intervalClass, array $days): array
    {
        $intervals = [];
        foreach ($days as $day => $item) {
            if ($day !== null && $item['from'] !== null && $item['to'] !== null) {
                $intervals[] = $this->generateOpeningHour($intervalClass, $day, $item['from'], $item['to']);
            }
        }

        return $intervals;
    }

    private function generateOpeningHour(string $intervalClass, int $day, int $from, int $to): object
    {
        $openingHour = new $intervalClass();
        $openingHour->day = $day;
        $openingHour->from = $from;
        $openingHour->to = $to;

        return $openingHour;
    }

}