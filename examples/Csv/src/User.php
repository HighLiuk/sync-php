<?php

namespace HighLiuk\Sync\Examples\Csv\Src;

use HighLiuk\Sync\Adapters\Csv\CsvModel;

class User extends CsvModel
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
     * @param array<string,string> $data
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
