<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityAddress extends Model
{
    use HasFactory;

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country', 'short_name');
    }

    /**
     * Get the user that owns the ActivityAddress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
