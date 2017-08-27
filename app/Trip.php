<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'name', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
