<?php

namespace App\Models\Api\Paper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseRequestPaper extends Model
{
    use HasFactory;

    protected $table = 'mgr.response_request_paper';

    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'transaction_number',
        'response_payper_url',
        'json',
        'audit_date',
    ];
}
