<?php


namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashTransactionTest extends TestCase
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
            ->postJson(route('transactions.store.cash'), $inputs)
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
            'banknote_of_1' => 200,
            'banknote_of_5' => 0,
            'banknote_of_10' => 10,
            'banknote_of_50' => 0,
            'banknote_of_100' => 0,
        ];

        $this
            ->postJson(route('transactions.store.cash'), $inputs)
            ->assertOk();

        $this
            ->assertDatabaseCount('transactions', 1)
            ->assertDatabaseHas('transactions', [
                'source' => Transaction::SOURCE_CASH,
                'amount' => 300,
                'inputs' => json_encode($inputs)
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_tests_exceed_cash_transaction_limit()
    {
        Transaction::create([
            'source' => Transaction::SOURCE_CASH,
            'amount' => 9500,
            'inputs' => []
        ]);

        // 501
        $inputs = [
            'banknote_of_1' => 1,
            'banknote_of_5' => 0,
            'banknote_of_10' => 0,
            'banknote_of_50' => 0,
            'banknote_of_100' => 5,
        ];

        $this
            ->postJson(route('transactions.store.cash'), $inputs)
            ->assertJsonFragment(['Cannot exceed the cash source amount limit of 10k.']);
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
            'amount' => 19500,
            'inputs' => []
        ]);

        // = 501
        $inputs = [
            'banknote_of_1' => 1,
            'banknote_of_5' => 0,
            'banknote_of_10' => 0,
            'banknote_of_50' => 0,
            'banknote_of_100' => 5,
        ];

        $this
            ->postJson(route('transactions.store.cash'), $inputs)
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
                    'banknote_of_1' => null,
                    'banknote_of_5' => null,
                    'banknote_of_10' => null,
                    'banknote_of_50' => null,
                    'banknote_of_100' => null,
                ]
            ],
            'wrong_banknote_1' => [
                [
                    'banknote_of_1' => '10001',
                    'banknote_of_5' => '0',
                    'banknote_of_10' => '0',
                    'banknote_of_50' => '0',
                    'banknote_of_100' => '0',
                ]
            ],
            'wrong_banknote_5' => [
                [
                    'banknote_of_1' => '0',
                    'banknote_of_5' => '2001',
                    'banknote_of_10' => '0',
                    'banknote_of_50' => '0',
                    'banknote_of_100' => '0',
                ]
            ],
            'wrong_banknote_10' => [
                [
                    'banknote_of_1' => '0',
                    'banknote_of_5' => '0',
                    'banknote_of_10' => '1001',
                    'banknote_of_50' => '0',
                    'banknote_of_100' => '0',
                ]
            ],
            'wrong_banknote_50' => [
                [
                    'banknote_of_1' => '0',
                    'banknote_of_5' => '0',
                    'banknote_of_10' => '0',
                    'banknote_of_50' => '201',
                    'banknote_of_100' => '0',
                ]
            ],
            'wrong_banknote_100' => [
                [
                    'banknote_of_1' => '0',
                    'banknote_of_5' => '0',
                    'banknote_of_10' => '0',
                    'banknote_of_50' => '0',
                    'banknote_of_100' => '101',
                ]
            ],
        ];
    }
}
