<?php

namespace Examples\Http;

use GuzzleHttp\Client;
use HighLiuk\Sync\Interfaces\SyncSource;
use HighLiuk\Sync\Traits\ReadsRecordsOneByOne;
use HighLiuk\Sync\Traits\WritesRecordsOneByOne;
use HighLiuk\Sync\Utils;

class UsersHttpSource implements SyncSource
{
    use ReadsRecordsOneByOne, WritesRecordsOneByOne;

    final public function __construct(protected UsersClient $client)
    {
    }

    /**
     * Create a new instance from the given URL.
     */
    public static function fromUrl(string $url): static
    {
        $client = new Client(['base_uri' => $url]);
        $usersClient = new UsersClient($client);

        return new static($usersClient);
    }

    /**
     * Get the item with the given email.
     *
     * @return ?array<string,mixed>
     */
    public function getOne(string $email): ?array
    {
        $user = $this->client->getUserByEmail($email);

        if ($user === null) {
            return null;
        }

        return $this->userToItem($user);
    }

    /**
     * Get all model emails.
     */
    public function list(): array
    {
        $users = $this->client->listUsers();

        return array_map(fn (User $user) => $user->email, $users);
    }

    /**
     * Add the given item to the source.
     *
     * @param  array<string,mixed>  $item
     */
    public function createOne(string $email, array $item): void
    {
        $name = Utils::toString($item['name'] ?? null);

        $this->client->createUser($name, $email);
    }

    /**
     * Update the given item in the source.
     *
     * @param  array<string,mixed>  $item
     */
    public function updateOne(string $email, array $item): void
    {
        $user = $this->client->getUserByEmail($email);

        if ($user === null) {
            return;
        }

        $name = Utils::toString($item['name'] ?? null);

        $this->client->updateUser($user->id, $name, $email);
    }

    /**
     * Delete the item with the given email from the source.
     */
    public function deleteOne(string $email): void
    {
        $user = $this->client->getUserByEmail($email);

        if ($user === null) {
            return;
        }

        $this->client->deleteUser($user->id);
    }

    /**
     * Map the given user to its data.
     *
     * @return array<string,mixed>
     */
    protected function userToItem(User $user): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
