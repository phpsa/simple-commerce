<?php

namespace DoubleThreeDigital\SimpleCommerce\Http\Controllers;

use DoubleThreeDigital\SimpleCommerce\Facades\Customer;
use DoubleThreeDigital\SimpleCommerce\Http\Requests\Customer\IndexRequest;
use DoubleThreeDigital\SimpleCommerce\Http\Requests\Customer\UpdateRequest;
use Illuminate\Support\Arr;

class CustomerController extends BaseActionController
{
    public function index(IndexRequest $request, $customer)
    {
        return Customer::find($customer)->toAugmentedArray();
    }

    public function update(UpdateRequest $request, $customer)
    {
        $customer = Customer::find($customer);
        $data = Arr::except($request->all(), ['_params', '_redirect', '_token']);

        foreach ($data as $key => $value) {
            $customer->set($key, $value);
        }

        $customer->save();

        return $this->withSuccess($request);
    }
}
