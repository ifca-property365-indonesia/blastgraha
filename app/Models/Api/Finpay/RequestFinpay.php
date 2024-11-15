<?php

namespace App\Models\Api\Finpay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFinpay extends Model
{
    use HasFactory;

    protected $table = 'mgr.api_request_finpay';

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
