<?php


namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankTransferTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider inputsDataProvider
     *
     * @param array $inputs
     *
     * @return void
     */
    public function it_tests_invalid_inputs(array $inputs)
    {
        $this
            ->postJson(route('transactions.store.transfer'), $inputs)
            ->assertStatus(422);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_tests_valid_transaction_store()
    {
        $inputs = [
            'transfer_date' => today()->toDateString(),
            'customer_name' => 'Customer Name',
            'account_number' => 'ABC123',
            'amount' => '4500.99'
        ];

        $this
            ->postJson(route('transactions.store.transfer'), $inputs)
            ->assertOk();

        $this
            ->assertDatabaseCount('transactions', 1)
            ->assertDatabaseHas('transactions', [
                'source' => Transaction::SOURCE_BANK_TRANSFER,
                'amount' => '4500.99',
                'inputs' => json_encode($inputs)
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_tests_exceed_cash_machine_limit()
    {
        Transaction::create([
            'source' => Transaction::SOURCE_CREDIT_CARD,
            'amount' => 9500,
            'inputs' => []
        ]);

        $inputs = [
            'transfer_date' => today()->toDateString(),
            'customer_name' => 'Customer Name',
            'account_number' => 'ABC123',
            'amount' => '11000'
        ];

        $this
            ->postJson(route('transactions.store.transfer'), $inputs)
            ->assertJsonFragment(['Cannot exceed the cash machine amount limit of 20k.']);
    }

    /**
     * @return array
     */
    public function inputsDataProvider(): array
    {
        return [
            'null' => [
                [
                    'transfer_date' => null,
                    'customer_name' => null,
                    'account_number' => null,
                    'amount' => null
                ]
            ],
            'wrong_transfer_date' => [
                [
                    'transfer_date' => now()->addDay()->toDateString(),
                    'customer_name' => 'Customer Name',
                    'account_number' => 'ABC123',
                    'amount' => '300'
                ]
            ],
            'wrong_customer_name' => [
                [
                    'transfer_date' => today()->toDateString(),
                    'customer_name' => Str::random(300),
                    'account_number' => 'ABC123',
                    'amount' => '300'
                ]
            ],
            'wrong_account_number' => [
                [
                    'transfer_date' => today()->toDateString(),
                    'customer_name' => 'Customer Name',
                    'account_number' => '!BC12=',
                    'amount' => '300'
                ]
            ],
            'wrong_amount' => [
                [
                    'transfer_date' => today()->toDateString(),
                    'customer_name' => 'Customer Name',
                    'account_number' => 'ABC123',
                    'amount' => '20001'
                ]
            ]
        ];
    }
}
