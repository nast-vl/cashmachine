<?php


namespace App\Contracts;


interface TransactionContract
{
    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return array
     */
    public function inputs(): array;

    /**
     * @return string
     */
    public function source(): string;
}
