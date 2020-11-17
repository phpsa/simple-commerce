<?php

namespace DoubleThreeDigital\SimpleCommerce\Tests\Repositories;

use DoubleThreeDigital\SimpleCommerce\Customers\Customer as CustomersCustomer;
use DoubleThreeDigital\SimpleCommerce\Facades\Customer;
use DoubleThreeDigital\SimpleCommerce\Repositories\CustomerRepository;
use DoubleThreeDigital\SimpleCommerce\Tests\TestCase;
use Statamic\Entries\Entry as EntriesEntry;
use Statamic\Facades\Entry;

class CustomerRepositoryTest extends TestCase
{
    /** @test */
    public function can_find_customer()
    {
        Entry::make()
            ->collection('customers')
            ->slug('donald-at-examplecom')
            ->data([
                'title' => 'Donald Duck <donald@example.com>',
                'name' => 'Donald Duck',
                'email' => 'donald@example.com',
            ])
            ->save();

        $entry = Entry::findBySlug('donald-at-examplecom', 'customers');

        $customer = Customer::find($entry->id());

        $this->assertSame($customer->title(), 'Donald Duck <donald@example.com>');
        $this->assertSame($customer->get('name'), 'Donald Duck');
        $this->assertSame($customer->get('email'), 'donald@example.com');
    }

    /** @test */
    public function can_find_customer_with_null_title_and_slug_and_see_they_have_been_generated()
    {
        Entry::make()
            ->collection('customers')
            ->data([
                'name' => 'Mickey Mouse',
                'email' => 'mickey@example.com',
            ])
            ->save();

        $entry = Entry::whereCollection('customers')->last();

        $this->assertFalse($entry->has('title'));
        $this->assertNull($entry->slug());

        $customer = Customer::find($entry->id());

        $this->assertNotNull($customer->slug());
        $this->assertSame($customer->slug(), 'mickey-at-examplecom');
        $this->assertSame($customer->title(), 'Mickey Mouse <mickey@example.com>');
        $this->assertSame($customer->get('name'), 'Mickey Mouse');
        $this->assertSame($customer->get('email'), 'mickey@example.com');
    }

    /** @test */
    public function can_find_customer_by_email()
    {
        Entry::make()
            ->collection('customers')
            ->slug('minnie-at-examplecom')
            ->data([
                'title' => 'Minnie Mouse <minnie@example.com>',
                'name' => 'Minnie Mouse',
                'email' => 'minnie@example.com',
            ])
            ->save();

        $customer = Customer::findByEmail('minnie@example.com');

        $this->assertSame($customer->title(), 'Minnie Mouse <minnie@example.com>');
        $this->assertSame($customer->get('name'), 'Minnie Mouse');
        $this->assertSame($customer->get('email'), 'minnie@example.com');
    }

    /** @test */
    public function can_generate_title_and_slug_from_name_and_email()
    {
        $customer = new CustomersCustomer(Entry::make()->collection('customers'));

        $customer->set('name', 'Duncan McClean');
        $customer->set('email', 'duncan@doublethree.digital');
        $customer->save();

        $generate = $customer->generateTitleAndSlug();

        $this->assertSame($customer->title(), 'Duncan McClean <duncan@doublethree.digital>');
        $this->assertSame($customer->slug(), 'duncan-at-doublethreedigital');
    }

    /** @test */
    public function can_generate_title_and_slug_from_just_email()
    {
        $customer = new CustomersCustomer(Entry::make()->collection('customers'));

        $customer->set('email', 'james@example.com');
        $customer->save();

        $generate = $customer->generateTitleAndSlug();

        $this->assertSame($customer->title(), ' <james@example.com>');
        $this->assertSame($customer->slug(), 'james-at-examplecom');
    }
}
