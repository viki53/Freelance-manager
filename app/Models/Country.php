<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    public $fillable = [
        'code',
        'name',
        'phone_prefix',
    ];

    public function addresses() {
        return $this->hasMany(Address::class, 'country_code', 'code');
    }
}
