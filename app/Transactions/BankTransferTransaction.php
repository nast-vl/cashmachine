<?php


namespace App\Transactions;


use App\Models\Transaction;

class BankTransferTransaction extends AbstractTransaction
{
    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void
    {
        $this->request()->validate([
            'transfer_date' => 'required|date_format:Y-m-d|after:yesterday',
            'customer_name' => 'required|string|max:255',
            'account_number' => 'required|alpha_num|size:6',
            'amount' => 'required|numeric|gt:0|max:20000'
        ]);
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return (float) $this->request()->input('amount');
    }

    /**
     * @return array
     */
    public function inputs(): array
    {
        return $this->request()->only(['transfer_date', 'customer_name', 'account_number', 'amount']);
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return Transaction::SOURCE_BANK_TRANSFER;
    }
}
