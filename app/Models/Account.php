<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    /**
     * Get the transactions for the account.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
