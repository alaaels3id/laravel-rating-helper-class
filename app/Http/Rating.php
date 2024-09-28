<?php

namespace App\Http;

class Rating
{
    public static function setCalculatedRate($model, $rate): array
    {
        $mul = $model->rates_count * $model->rate;

        $sum = $mul + $rate;

        $new_count = $model->rates_count + 1;

        $data = [
            'rate'        => round($sum / $new_count),
            'rates_count' => $new_count,
        ];

        $model->update($data);

        return $data;
    }

    public static function getStarsRateCount($collection): array
    {
        return [
            'one'   => self::getRatePercentage($collection, 1),
            'two'   => self::getRatePercentage($collection, 2),
            'three' => self::getRatePercentage($collection, 3),
            'four'  => self::getRatePercentage($collection, 4),
            'five'  => self::getRatePercentage($collection, 5),
        ];
    }

    private static function getRatePercentage($collection, $star): array
    {
        $rate_count = $collection->where('rate', $star)->count();

        $percentage = ($collection->count() != 0) ? ($rate_count / $collection->count() * 100) : 0;

        return [
            'count'      => $rate_count,
            'percentage' => round($percentage),
        ];
    }
}