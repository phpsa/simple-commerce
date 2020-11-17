<?php

namespace DoubleThreeDigital\SimpleCommerce\Repositories;

use DoubleThreeDigital\SimpleCommerce\Contracts\CustomerRepository as Contract;
use DoubleThreeDigital\SimpleCommerce\Customers\Customer;
use DoubleThreeDigital\SimpleCommerce\Exceptions\CustomerNotFound;
use Statamic\Entries\Entry;
use Statamic\Facades\Entry as EntryFacade;
use Illuminate\Support\Str;

class CustomerRepository implements Contract
{
    public function make()
    {
        return (
            new Customer(EntryFacade::make()->collection('customers'))
        );
    }

    public function find(string $id): Customer
    {
        $entry = EntryFacade::find($id);

        if (! $entry) {
            throw new CustomerNotFound(__('simple-commerce::customers.customer_not_found', ['id' => $id]));
        }

        return (new Customer($entry));
    }

    public function findByEmail(string $email): Customer
    {
        $entry = Entry::query()
            ->where('slug', Str::slug($email))
            ->first();

        if (! $entry) {
            throw new CustomerNotFound(__('simple-commerce::customers.customer_not_found_by_email', ['email' => $email]));
        }

        return (new Customer($entry));
    }

    public static function bindings(): array
    {
        return [];
    }
}
