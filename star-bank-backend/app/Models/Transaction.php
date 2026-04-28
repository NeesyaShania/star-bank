<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'transaction_type',
        'amount',
        'transaction_date',
        'interest_amount',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}