<?php

namespace Examples\Sql;

use PDO;
use PDOStatement;

class UsersRepository
{
    public function __construct(public readonly PDO $db)
    {
    }

    /**
     * Get a user by email.
     *
     * @param  string[]  $emails
     * @return User[]
     */
    public function getUsersByEmail(array $emails): array
    {
        $placeholders = implode(', ', array_fill(0, count($emails), '?'));
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email IN ($placeholders)");
        $stmt->execute($emails);

        return $this->fetchUsers($stmt);
    }

    /**
     * List all users.
     *
     * @return User[]
     */
    public function listUsers(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM users');
        $stmt->execute();

        return $this->fetchUsers($stmt);
    }

    /**
     * Create new users.
     *
     * @param  array{name:string,email:string}[]  $data
     */
    public function createUsers(array $data): void
    {
        $placeholders = implode(', ', array_fill(0, count($data), '(?, ?)'));
        $values = [];

        foreach ($data as $item) {
            $values[] = $item['name'];
            $values[] = $item['email'];
        }

        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES $placeholders");
        $stmt->execute($values);
    }

    /**
     * Update a user by email.
     */
    public function updateUserByEmail(string $email, string $name): void
    {
        $stmt = $this->db->prepare('UPDATE users SET name = :name WHERE email = :email');
        $stmt->execute(compact('name', 'email'));
    }

    /**
     * Delete users by email.
     *
     * @param  string[]  $emails
     */
    public function deleteUsersByEmail(array $emails): void
    {
        $placeholders = implode(', ', array_fill(0, count($emails), '?'));
        $stmt = $this->db->prepare("DELETE FROM users WHERE email IN ($placeholders)");
        $stmt->execute($emails);
    }

    /**
     * Fetch users from the given statement.
     *
     * @return User[]
     */
    protected function fetchUsers(PDOStatement $stmt): array
    {
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (! is_array($list) || ! array_is_list($list)) {
            return [];
        }

        $users = [];

        foreach ($list as $data) {
            if ($user = User::tryFrom($data)) {
                $users[] = $user;
            }
        }

        return $users;
    }
}
