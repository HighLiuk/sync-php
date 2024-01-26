<?php

namespace Examples\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class UsersClient
{
    public function __construct(public readonly Client $client)
    {
    }

    /**
     * Get a user by id.
     */
    public function getUser(string $id): ?User
    {
        $response = $this->get("/users/$id");

        return User::tryFrom($response);
    }

    /**
     * Get a user by email.
     */
    public function getUserByEmail(string $email): ?User
    {
        $response = $this->get("/users?email_eq=$email");

        if ($response === null || ! array_is_list($response)) {
            return null;
        }

        $user = array_shift($response);

        return User::tryFrom($user);
    }

    /**
     * List all users.
     *
     * @return User[]
     */
    public function listUsers(): array
    {
        $response = $this->get('/users');

        if ($response === null || ! array_is_list($response)) {
            return [];
        }

        $users = [];

        foreach ($response as $data) {
            if ($user = User::tryFrom($data)) {
                $users[] = $user;
            }
        }

        return $users;
    }

    /**
     * Create a new user.
     */
    public function createUser(string $name, string $email): ?User
    {
        $response = $this->post('/users', compact('name', 'email'));

        return User::tryFrom($response);
    }

    /**
     * Update a user.
     */
    public function updateUser(string $id, ?string $name = null, ?string $email = null): ?User
    {
        $body = [];
        if ($name !== null) {
            $body['name'] = $name;
        }
        if ($email !== null) {
            $body['email'] = $email;
        }

        $response = $this->patch("/users/$id", $body);

        return User::tryFrom($response);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(string $id): bool
    {
        $response = $this->delete("/users/$id");

        return $response !== null;
    }

    /**
     * Safe get request.
     *
     * @return ?array<array-key,mixed>
     */
    protected function get(string $url): ?array
    {
        try {
            $response = $this->client->get($url);
            $body = $response->getBody()->getContents();
            $json = json_decode($body, true);

            if (! is_array($json)) {
                return null;
            }

            return $json;
        } catch (GuzzleException) {
            return null;
        }
    }

    /**
     * Safe post request.
     *
     * @param  array<string,mixed>  $data
     * @return ?array<array-key,mixed>
     */
    protected function post(string $url, array $data): ?array
    {
        try {
            $response = $this->client->post($url, [
                'json' => $data,
            ]);
            $body = $response->getBody()->getContents();
            $json = json_decode($body, true);

            if (! is_array($json)) {
                return null;
            }

            return $json;
        } catch (GuzzleException) {
            return null;
        }
    }

    /**
     * Safe patch request.
     *
     * @param  array<string,mixed>  $data
     * @return ?array<array-key,mixed>
     */
    protected function patch(string $url, array $data): ?array
    {
        try {
            $response = $this->client->patch($url, [
                'json' => $data,
            ]);
            $body = $response->getBody()->getContents();
            $json = json_decode($body, true);

            if (! is_array($json)) {
                return null;
            }

            return $json;
        } catch (GuzzleException) {
            return null;
        }
    }

    /**
     * Safe delete request.
     *
     * @return ?array<array-key,mixed>
     */
    protected function delete(string $url): ?array
    {
        try {
            $response = $this->client->delete($url);
            $body = $response->getBody()->getContents();
            $json = json_decode($body, true);

            if (! is_array($json)) {
                return null;
            }

            return $json;
        } catch (GuzzleException) {
            return null;
        }
    }
}
