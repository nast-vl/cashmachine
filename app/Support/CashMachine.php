<?php


namespace App\Support;


use App\Models\Transaction;
use App\Contracts\TransactionContract;
use Illuminate\Validation\ValidationException;

class CashMachine
{
    /**
     * @var int
     */
    const CASH_TRANSACTION_LIMIT = 10_000;

    /**
     * @var int
     */
    const MACHINE_LIMIT = 20_000;

    /**
     * @param \App\Contracts\TransactionContract $transaction
     *
     * @return \App\Models\Transaction
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(TransactionContract $transaction)
    {
        $transaction->validate();

        $this->afterValidation($transaction);

        return Transaction::create([
            'source' => $transaction->source(),
            'amount' => $transaction->amount(),
            'inputs' => $transaction->inputs()
        ]);
    }

    /**
     * @param \App\Contracts\TransactionContract $transaction
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function afterValidation(TransactionContract $transaction)
    {
        if ($transaction->source() === Transaction::SOURCE_CASH) {
            if (! Transaction::canStoreCashTransaction($transaction->amount())) {
                throw ValidationException::withMessages(['Cannot exceed the cash source amount limit of 10k.']);
            }
        }

        if (! Transaction::canStoreTransaction($transaction->amount())) {
            throw ValidationException::withMessages(['Cannot exceed the cash machine amount limit of 20k.']);
        }
    }
}
