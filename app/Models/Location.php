<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property float latitude
 * @property float longitude
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'longitude'
    ];

    /**
     * Scope a query to only include locations that fall within the given radius of the given coordinates.
     */
    public function scopeWithinRadius(Builder $query, float $latitude, float $longitude, int $radius, string $radiusUnit = 'km'): void
    {
        $earthRadius = $radiusUnit == 'mi' ? '3961' : '6371';

        $query->whereRaw("($earthRadius * acos(cos(radians(?))
                                * cos(radians(latitude))
                                * cos(radians(longitude) - radians(?))
                                + sin(radians(?))
                                * sin(radians(latitude)))) <= ?", [$latitude, $longitude, $latitude, $radius]);
    }
}
