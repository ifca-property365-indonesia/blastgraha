<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceView extends Model
{
    use HasFactory;

    protected $table = 'mgr.v_blast_doc';
}
