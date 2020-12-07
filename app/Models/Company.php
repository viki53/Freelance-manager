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
        'customer_of',
        'headquarters_address_id',
    ];

    public function owner() {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    public function customers() {
        return $this->hasMany(Company::class, 'customer_of', 'id');
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

    public function pending_invoices() {
        return $this->invoices()->whereNull('sent_at');
    }
    public function sent_invoices() {
        return $this->invoices()->whereNotNull('sent_at');
    }

    public function received_invoices() {
        return $this->hasMany(Invoice::class, 'customer_id', 'id')->whereNotNull('sent_at');
    }
}
