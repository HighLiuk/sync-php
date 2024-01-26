<?php

namespace Examples\Http;

use AssertionError;

/**
 * Sample User model.
 */
class User
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
    ) {
    }

    /**
     * Create a User from an array.
     */
    public static function from(mixed $data): self
    {
        assert(is_array($data));

        assert(array_key_exists('id', $data));
        assert(array_key_exists('name', $data));
        assert(array_key_exists('email', $data));

        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];

        assert(is_string($id));
        assert(is_string($name));
        assert(is_string($email));

        return new self(
            id: $id,
            name: $name,
            email: $email,
        );
    }

    /**
     * Try to create a User from an array.
     */
    public static function tryFrom(mixed $data): ?self
    {
        try {
            return self::from($data);
        } catch (AssertionError) {
            return null;
        }
    }
}
