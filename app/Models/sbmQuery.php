<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sbmQuery extends Model
{
    protected $fillable = [
        'location',
        'user_id',
        'plate',
        'ended_date',
    ];

    protected function casts(): array
    {
        return [
            'ended_date' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
