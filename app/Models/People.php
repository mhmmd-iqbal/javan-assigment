<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'peoples';

    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'name',
        'gender'
    ];

    public function parent()
    {
        return $this->belongsTo(People::class, 'parent_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(People::class, 'parent_id', 'id');
    }
}
