<?php


namespace Tests\Feature;


use Tests\TestCase;
use App\Support\CashMachine;
use Illuminate\Http\Request;
use App\Transactions\CashTransaction;
use App\Factories\TransactionFactory;
use App\Transactions\CreditCardTransaction;
use App\Transactions\BankTransferTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashMachineTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider transactionsDataProvider
     *
     * @param string $fqn
     * @param array $inputs
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException|\Throwable
     */
    public function it_tests_valid_store(string $fqn, array $inputs)
    {
        $transaction = (new CashMachine)->store(TransactionFactory::make($fqn, new Request($inputs)));

        $this
            ->assertDatabaseCount('transactions', 1)
            ->assertDatabaseHas('transactions', [
                'id' => $transaction->getKey(),
                'source' => $transaction->getAttribute('source'),
                'amount' => $transaction->getAttribute('amount'),
                'inputs' => $transaction->getRawOriginal('inputs'),
            ]);
    }

    /**
     * @return array
     */
    public function transactionsDataProvider()
    {
        return [
            'cash' => [
                CashTransaction::class,
                [
                    'banknote_of_1' => 10,
                    'banknote_of_5' => 10,
                    'banknote_of_10' => 10,
                    'banknote_of_50' => 10,
                    'banknote_of_100' => 10
                ]
            ],
            'card' => [
                CreditCardTransaction::class,
                [
                    'card_number' => '4024007167647915',
                    'card_expiration' => '12/2022',
                    'card_holder' => 'Card Holder',
                    'card_cvv' => '123',
                    'amount' => '350.55'
                ]
            ],
            'transfer' => [
                BankTransferTransaction::class,
                [
                    'transfer_date' => today()->toDateString(),
                    'customer_name' => 'Customer Name',
                    'account_number' => 'ABC123',
                    'amount' => '11000'
                ]
            ]
        ];
    }
}
