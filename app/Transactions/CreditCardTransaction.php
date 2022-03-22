<?php


namespace App\Transactions;


use App\Models\Transaction;

class CreditCardTransaction extends AbstractTransaction
{
    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void
    {
        $this->request()->validate([
            'card_number' => 'required|digits:16|starts_with:4',
            'card_expiration' => 'required|date_format:m/Y|after:+1 month',
            'card_holder' => 'required|string|max:255',
            'card_cvv' => 'required|digits:3',
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
        return $this->request()->only(['card_number', 'card_expiration', 'card_holder', 'card_cvv', 'amount']);
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return Transaction::SOURCE_CREDIT_CARD;
    }
}
