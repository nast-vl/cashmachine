<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Support\CashMachine;
use App\Transaction\CashTransaction;
use App\Factories\TransactionFactory;
use App\Transaction\CreditCardTransaction;
use App\Transaction\BankTransferTransaction;

class TransactionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeCashTransaction(Request $request)
    {
        return $this->storeTransaction(CashTransaction::class, $request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeCreditCardTransaction(Request $request)
    {
        return $this->storeTransaction(CreditCardTransaction::class, $request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeBankTransferTransaction(Request $request)
    {
        return $this->storeTransaction(BankTransferTransaction::class, $request);
    }

    /**
     * @param string $fqn
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException|\Exception
     */
    protected function storeTransaction(string $fqn, Request $request)
    {
        $transaction = (new CashMachine)->store(TransactionFactory::make($fqn, $request));

        $request->session()->flash('transaction', $transaction->toArray());

        return response()->json(['redirect' => route('transaction.success')]);
    }
}
