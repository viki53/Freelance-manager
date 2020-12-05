<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Concerns\UsesUuid;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'company_id',
        'rebate_percentage',
        'rebate_amount',
        'discount',
    ];

    protected $casts = [
        'rebate_percentage' => 'decimal:2',
        'rebate_amount' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function getUntaxedTotalAttribute() {
        $total = 0;
        $this->loadMissing('items');
        foreach ($this->items as $item) {
            $total += $item->untaxed_price;
        }
        return $total;
    }

    public function getTaxesTotalAttribute() {
        $total = 0;
        $this->loadMissing('items');
        foreach ($this->items as $item) {
            $total += $item->taxes_price;
        }
        return $total;
    }

    public function getTaxedTotalAttribute() {
        $total = 0;
        $this->loadMissing('items');
        foreach ($this->items as $item) {
            $total += $item->taxed_price;
        }
        return $total;
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function tax_rates() {
        return $this->hasManyThrough(TaxRate::class, InvoiceItem::class);
    }
}
