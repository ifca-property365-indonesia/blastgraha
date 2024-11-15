<?php

namespace App\Models\Api\Paper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifcationCallbackPaper extends Model
{
    use HasFactory;

    protected $table = 'mgr.notification_callback_paper';

    public $timestamps = false;

    protected $fillable = [
        'payment_date',
        'amount',
        'paid_amount',
        'status',
        'payment_channel',
        'payment_method',
        'ref_id',
        'transaction_date',
        'transaction_id',
        'transaction_status',
        'res_json',
        'audit_date'
    ];
}
