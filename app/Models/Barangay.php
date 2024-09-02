<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the drivers for the Barangay
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'barangay_id', 'id');
    }
}
