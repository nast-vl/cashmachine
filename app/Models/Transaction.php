<?php

namespace App\Models;

use App\Support\CashMachine;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @var string
     */
    const SOURCE_CASH = 'cash';

    /**
     * @var string
     */
    const SOURCE_CREDIT_CARD = 'credit_card';

    /**
     * @var string
     */
    const SOURCE_BANK_TRANSFER = 'bank_transfer';

    /**
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var array
     */
    protected $fillable = [
        'source', 'amount', 'inputs'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
        'inputs' => 'array',
    ];

    /**
     * @param float $amount
     *
     * @return bool
     */
    public static function canStoreCashTransaction(float $amount): bool
    {
        return static::query()->where('source', static::SOURCE_CASH)->sum('amount') + $amount <= CashMachine::CASH_TRANSACTION_LIMIT;
    }

    /**
     * @param float $amount
     *
     * @return bool
     */
    public static function canStoreTransaction(float $amount): bool
    {
        return static::query()->sum('amount') + $amount <= CashMachine::MACHINE_LIMIT;
    }
}
