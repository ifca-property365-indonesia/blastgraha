<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeader extends Model
{
    use HasFactory;

    protected $table = 'mgr.blast_doc';

    public $timestamps = false;

    protected $fillable = [
        'submit_pay',
        'transaction_id',
        'transaction_number',
        'redirect_url',
        'paid_flag',
        'send_flag',
        'send_date'
    ];
}
