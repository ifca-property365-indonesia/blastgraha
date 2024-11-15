<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLog extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'mgr.ar_email_inv_log_msg';

    public $timestamps = false;

    protected $fillable = [
        'entity_cd',
        'entity_name',
        'project_no',
        'project_name',
        'debtor_acct',
        'debtor_name',
        'email_addr',
        'gen_date',
        'doc_no',
        'status_code',
        'process_id',
        'response_message',
        'send_date',
        'audit_user',
        'audit_date'
    ];
}
