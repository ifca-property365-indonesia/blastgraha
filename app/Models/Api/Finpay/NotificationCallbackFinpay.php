<?php

namespace App\Models\Api\Finpay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCallbackFinpay extends Model
{
    use HasFactory;

    protected $table = 'mgr.api_notification_callback_finpay';

    public $timestamps = false;

    protected $fillable = [
        'entity_cd',
        'project_no',
        'debtor_acct',
        'debtor_name',
        'lot_no',
        'transaction_id',
        'payment_metode',
        'payment_code',
        'payment_status',
        'payment_date',
        'payment_total',
        'json',
        'audit_date'
    ];
}
