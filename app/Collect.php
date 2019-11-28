<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $contract
 * @property string $location
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Collect extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'contract', 'location', 'data', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
