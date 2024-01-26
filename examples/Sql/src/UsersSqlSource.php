<?php

namespace Examples\Sql;

use HighLiuk\Sync\Interfaces\SyncSource;
use HighLiuk\Sync\SyncModel;
use HighLiuk\Sync\Utils;
use PDO;

class UsersSqlSource implements SyncSource
{
    final public function __construct(protected UsersRepository $repository)
    {
    }

    /**
     * Create a new instance from a PDO connection string.
     */
    public static function fromConnectionString(string $connectionString): static
    {
        $db = new PDO($connectionString);
        $repository = new UsersRepository($db);

        return new static($repository);
    }

    public function get(array $emails): array
    {
        $users = $this->repository->getUsersByEmail($emails);

        return array_map($this->userToModel(...), $users);
    }

    public function list(): array
    {
        $users = $this->repository->listUsers();

        return array_map(fn (User $user) => $user->email, $users);
    }

    public function create(array $models): void
    {
        $items = array_map($this->modelToItem(...), $models);

        $this->repository->createUsers($items);
    }

    public function update(array $models): void
    {
        foreach ($models as $model) {
            $item = $this->modelToItem($model);

            $this->repository->updateUserByEmail($item['email'], $item['name']);
        }
    }

    public function delete(array $emails): void
    {
        $this->repository->deleteUsersByEmail($emails);
    }

    /**
     * Map the given user to its data.
     */
    protected function userToModel(User $user): SyncModel
    {
        return new SyncModel(
            $user->email,
            [
                'name' => $user->name,
                'email' => $user->email,
            ]
        );
    }

    /**
     * Map the given model to its data.
     *
     * @return array{name:string,email:string}
     */
    protected function modelToItem(SyncModel $model): array
    {
        $name = Utils::toString($model->item['name'] ?? null);
        $email = Utils::toString($model->item['email'] ?? null);

        return compact('name', 'email');
    }
}
