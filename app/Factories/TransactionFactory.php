<?php


namespace App\Factories;


use Exception;
use Illuminate\Http\Request;
use App\Contracts\TransactionContract;

class TransactionFactory
{
    /**
     * @param string $fqn
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Contracts\TransactionContract
     * @throws \Exception
     */
    public static function make(string $fqn, Request $request)
    {
        if (array_key_exists(TransactionContract::class, class_implements($fqn))) {
            return resolve($fqn, compact('request'));
        }

        throw new Exception(sprintf('The given class [%s] must implement %s.', $fqn, TransactionContract::class));
    }
}
