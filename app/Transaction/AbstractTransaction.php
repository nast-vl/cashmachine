<?php


namespace App\Transaction;


use Illuminate\Http\Request;
use App\Contracts\TransactionContract;

abstract class AbstractTransaction implements TransactionContract
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

    /**
     * Create new instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\Request
     */
    public function request()
    {
        return $this->request;
    }
}
