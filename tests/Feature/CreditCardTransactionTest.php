<?php


namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreditCardTransactionTest extends TestCase
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
            ->postJson(route('transactions.store.card'), $inputs)
            ->assertStatus(422);
    }

    /**
     * @test
     * @return void
     */
    public function it_tests_valid_transaction_store()
    {
        $inputs = [
            'card_number' => '4024007167647915',
            'card_expiration' => '12/2022',
            'card_holder' => 'Card Holder',
            'card_cvv' => '123',
            'amount' => '9430.33'
        ];

        $this
            ->postJson(route('transactions.store.card'), $inputs)
            ->assertOk();

        $this
            ->assertDatabaseCount('transactions', 1)
            ->assertDatabaseHas('transactions', [
                'source' => Transaction::SOURCE_CREDIT_CARD,
                'amount' => '9430.33',
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
            'source' => Transaction::SOURCE_BANK_TRANSFER,
            'amount' => 19800,
            'inputs' => []
        ]);

        $inputs = [
            'card_number' => '4024007167647915',
            'card_expiration' => '12/2022',
            'card_holder' => 'Card Holder',
            'card_cvv' => '123',
            'amount' => 201
        ];

        $this
            ->postJson(route('transactions.store.card'), $inputs)
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
                    'card_number' => null,
                    'card_expiration' => null,
                    'card_holder' => null,
                    'card_cvv' => null,
                    'amount' => null
                ]
            ],
            'wrong_card_number' => [
                [
                    'card_number' => '302400716764791',
                    'card_expiration' => '12/2022',
                    'card_holder' => 'Card Holder',
                    'card_cvv' => '123',
                    'amount' => '200'
                ]
            ],
            'wrong_card_expiration' => [
                [
                    'card_number' => '4024007167647915',
                    'card_expiration' => '33/3333',
                    'card_holder' => 'Card Holder',
                    'card_cvv' => '123',
                    'amount' => '200'
                ]
            ],
            'wrong_card_holder' => [
                [
                    'card_number' => '4024007167647915',
                    'card_expiration' => '12/2022',
                    'card_holder' => Str::random(300),
                    'card_cvv' => '123',
                    'amount' => '200'
                ]
            ],
            'wrong_cvv' => [
                [
                    'card_number' => '4024007167647915',
                    'card_expiration' => '12/2022',
                    'card_holder' => 'Card Holder',
                    'card_cvv' => 'abc',
                    'amount' => '200'
                ]
            ],
            'wrong_amount' => [
                [
                    'card_number' => '4024007167647915',
                    'card_expiration' => '12/2022',
                    'card_holder' => 'Card Holder',
                    'card_cvv' => '333',
                    'amount' => '230000'
                ]
            ],
        ];
    }
}
