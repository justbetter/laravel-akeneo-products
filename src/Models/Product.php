<?php

namespace JustBetter\AkeneoProducts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;

/**
 * @property int $id
 * @property string $identifier
 * @property bool $synchronize
 * @property bool $retrieve
 * @property bool $update
 * @property int $fail_count
 * @property array $data
 * @property ?string $checksum
 * @property ?Carbon $retrieved_at
 * @property ?Carbon $modified_at
 * @property ?Carbon $failed_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $created_at
 * @property ?Carbon $deleted_at
 */
class Product extends Model
{
    use SoftDeletes;

    protected $table = 'akeneo_products';

    protected $guarded = [];

    protected $casts = [
        'synchronize' => 'boolean',
        'retrieve' => 'boolean',
        'update' => 'boolean',
        'retrieved_at' => 'datetime',
        'modified_at' => 'datetime',
        'failed_at' => 'datetime',
        'data' => 'array',
    ];

    public function scopeShouldRetrieve(Builder $builder): Builder
    {
        return $builder
            ->where('synchronize', '=', true)
            ->where('retrieve', '=', true);
    }

    public function scopeShouldUpdate(Builder $builder): Builder
    {
        return $builder
            ->where('synchronize', '=', true)
            ->where('update', '=', true);
    }

    public function failed(): void
    {
        $this->fail_count++;
        $this->failed_at = now();

        $tries = BaseProductRetriever::current()->tries();

        if ($tries > 0 && $this->fail_count >= $tries) {
            $this->synchronize = false;
        }

        $this->save();
    }
}
