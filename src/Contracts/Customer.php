<?php

namespace DoubleThreeDigital\SimpleCommerce\Contracts;

use Statamic\Http\Resources\API\EntryResource;

interface Customer
{
    public function all();

    public function query();

    public function find(string $id): self;

    public function create(array $data = [], string $site = ''): self;

    public function save(): self;

    public function delete();

    public function toResource(): EntryResource;

    public function id();

    public function title(string $title = '');

    public function slug(string $slug = '');

    public function site($site = null): self;

    public function fresh(): self;

    public function data(array $data = []);

    public function has(string $key): bool;

    public function get(string $key);

    public function set(string $key, $value);

    public function toArray(): array;

    public function findByEmail(string $email): self;

    public function name(): string;

    public function email(): string;

    public function generateTitleAndSlug(): self;

    public static function bindings(): array;
}
