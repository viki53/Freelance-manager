<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\UsesUuid;

class Company extends Model
{
    use HasFactory;
    use UsesUuid;

    public $fillable = [
        'name',
        'owner_id',
        'headquarters_address_id',
    ];

    public function owner() {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    public function headquarters_address() {
        return $this->belongsTo(Address::class, 'headquarters_address_id', 'id');
    }

    public function addresses() {
        return $this->hasMany(Address::class, 'company_id', 'id');
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'company_id', 'id');
    }
}
