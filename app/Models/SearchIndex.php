<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchIndex extends Model
{
    protected $fillable = [
        'entity_type',
        'entity_id',
        'keyword',
    ];
}
