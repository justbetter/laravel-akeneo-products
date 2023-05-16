<?php

namespace JustBetter\AkeneoProducts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JustBetter\AkeneoProducts\Enums\MappingType;

/**
 * @property int $id
 * @property MappingType $type
 * @property string $source
 * @property string $destination
 * @property bool $override
 * @property ?Carbon $updated_at
 * @property ?Carbon $created_at
 * @property ?Carbon $deleted_at
 */
class Mapping extends Model
{
    use SoftDeletes;

    protected $table = 'akeneo_products_mappings';

    protected $guarded = [];

    protected $casts = [
        'type' => MappingType::class,
        'override' => 'boolean',
    ];

    public static function of(MappingType $mappingType): Builder
    {
        return static::query()->where('type', '=', $mappingType);
    }

    public static function get(MappingType $mappingType, string $source): ?static
    {
        /** @var ?static $mapping */
        $mapping = static::of($mappingType)
            ->where('source', '=', $source)
            ->first();

        return $mapping;
    }
}
