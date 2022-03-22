<?php


namespace App\Transaction;


use App\Models\Transaction;
use App\Support\CashMachine;
use Illuminate\Validation\ValidationException;

class CashTransaction extends AbstractTransaction
{
    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void
    {
        $this->request()->validate([
            'banknote_of_1' => 'required|numeric|integer|min:0|max:10000',
            'banknote_of_5' => 'required|numeric|integer|min:0|max:2000',
            'banknote_of_10' => 'required|numeric|integer|min:0|max:1000',
            'banknote_of_50' => 'required|numeric|integer|min:0|max:200',
            'banknote_of_100' => 'required|numeric|integer|min:0|max:100',
        ]);

        if ($this->amount() <= 0) {
            throw ValidationException::withMessages(['The total amount should be greater than 0.']);
        }

        if ($this->amount() > CashMachine::CASH_TRANSACTION_LIMIT) {
            throw ValidationException::withMessages(['The total amount cannot exceed 10k.']);
        }
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return (float) array_sum([
            (int) $this->request()->input('banknote_of_1') * 1,
            (int) $this->request()->input('banknote_of_5') * 5,
            (int) $this->request()->input('banknote_of_10') * 10,
            (int) $this->request()->input('banknote_of_50') * 50,
            (int) $this->request()->input('banknote_of_100') * 100,
        ]);
    }

    /**
     * @return array
     */
    public function inputs(): array
    {
        return $this->request()->only([
            'banknote_of_1',
            'banknote_of_5',
            'banknote_of_10',
            'banknote_of_50',
            'banknote_of_100'
        ]);
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return Transaction::SOURCE_CASH;
    }
}
