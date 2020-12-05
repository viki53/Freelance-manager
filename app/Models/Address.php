<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\UsesUuid;

class Address extends Model
{
    use HasFactory;
    use UsesUuid;

    public $fillable = [
        'company_id',
        'label',
        'street_address',
        'postal_code',
        'city',
        'country_code',
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}
