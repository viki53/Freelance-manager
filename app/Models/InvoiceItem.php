<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\UsesUuid;

class InvoiceItem extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $fillable = [
        'invoice_id',
        'label',
        'description',
        'quantity',
        'unit_price',
        'percentage',
        'item_type_id',
        'tax_rate_id',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'percentage' => 'decimal:2',
    ];

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function item_type() {
        return $this->belongsTo(ItemType::class, 'item_type_id', 'id');
    }

    public function tax_rate() {
        return $this->belongsTo(TaxRate::class, 'tax_rate_id', 'id');
    }
}
