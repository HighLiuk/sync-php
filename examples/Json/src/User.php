<?php

namespace HighLiuk\Sync\Examples\Json\Src;

use HighLiuk\Sync\Adapters\Json\JsonModel;

/**
 * @extends JsonModel<int>
 */
class User extends JsonModel
{
    /**
     * The name of the user.
     */
    public readonly string $name;

    /**
     * The email of the user.
     */
    public readonly string $email;

    /**
     * Create a new User instance.
     *
     * @param array<string,mixed> $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->name = (string) ($data['name'] ?? '');
        $this->email = (string) ($data['email'] ?? '');
    }

    public function isSame($other): bool
    {
        return parent::isSame($other)
            && $this->name === $other->name
            && $this->email === $other->email;
    }
}
