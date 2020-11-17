<?php

namespace DoubleThreeDigital\SimpleCommerce\Contracts;

interface CustomerRepository
{
    public function make();

    public function find(string $id);

    public function findByEmail(string $email);
}
