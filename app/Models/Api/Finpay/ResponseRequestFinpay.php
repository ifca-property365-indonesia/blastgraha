<?php

namespace App\Models\Api\Finpay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseRequestFinpay extends Model
{
    use HasFactory;

    protected $table = 'mgr.api_response_request_finpay';

    public $timestamps = false;

    protected $fillable = [
        'response_code',
        'response_message',
        'response_url',
        'expiry_link',
        'transaction_id',
        'json',
        'audit_date',
    ];
}
