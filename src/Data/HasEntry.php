<?php

namespace DoubleThreeDigital\SimpleCommerce\Data;

trait HasEntry
{
    public function entry()
    {
        return $this->entry;
    }

    public function id(): ?string
    {
        return $this->entry->id();
    }

    public function title(): ?string
    {
        return $this->entry->get('title');
    }

    public function slug(string $slug = null)
    {
        if (is_null($slug)) {
            return $this->entry->slug();
        }

        $this->entry->slug($slug);

        return $this;
    }

    public function data($data = null)
    {
        if (is_null($data)) {
            return $this->entry->data();
        }

        $this->entry->data($data);
        $this->entry->save();

        return $this;
    }

    public function get(string $key)
    {
        return $this->entry->get($key);
    }

    public function set(string $key, $value)
    {
        $this->entry->set($key, $value);

        $this->entry->save();

        return $this;
    }

    public function __call($name, $arguments)
    {
        return $this->entry->{$name}($arguments);
    }
}
