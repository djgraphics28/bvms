<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the incident for the IncidentCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incident(): HasMany
    {
        return $this->hasMany(Incident::class, 'incident_category_id', 'id');
    }
}
