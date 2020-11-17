<?php

namespace DoubleThreeDigital\SimpleCommerce\Customers;

use DoubleThreeDigital\SimpleCommerce\Data\HasEntry;
use Statamic\Contracts\Entries\Entry;
use Illuminate\Support\Str;

class Customer
{
    use HasEntry;

    protected Entry $entry;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;

        if (! $this->entry->slug() || ! $this->has('title')) {
            $this->generateTitleAndSlug();
        }
    }

    public function save()
    {
        $this->save();

        return $this;
    }

    public function generateTitleAndSlug(): self
    {
        if ($this->has('name')) {
            $name = $this->get('name');
        }

        if ($this->has('email')) {
            $email = $this->get('email');
        }

        $this->set('title', __('simple-commerce::customers.customer_entry_title', [
            'name' => isset($name) ? $name : '',
            'email' => isset($email) ? $email : '',
        ]));

        if (isset($email)) $this->slug(Str::slug($email));

        // dd($this->entry);

        $this->entry->save();

        return $this;
    }
}
