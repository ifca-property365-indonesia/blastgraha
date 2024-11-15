<?php

namespace App\Models\Api\Paper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPaper extends Model
{
    use HasFactory;

    protected $table = 'mgr.request_paper';

    public $timestamps = false;

    protected $fillable = [
        'entity_cd',
        'project_no',
        'project_name',
        'debtor_acct',
        'debtor_name',
        'email_addr',
        'mobile_customer',
        'order_id',
        'order_amount',
        'order_descs',
        'total',
        'audit_date'
    ];
}
