<?php

declare(strict_types=1);

namespace MisarMail;

// ── Resource: Contacts ────────────────────────────────────────────────────────

class ContactsResource
{
    public function __construct(private readonly Client $client) {}

    public function list(int $page = 1, int $limit = 20): array
    {
        return $this->client->request('GET', '/contacts?' . http_build_query(['page' => $page, 'limit' => $limit]));
    }

    public function create(array $data): array
    {
        return $this->client->request('POST', '/contacts', $data);
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', "/contacts/{$id}");
    }

    public function update(string $id, array $data): array
    {
        return $this->client->request('PATCH', "/contacts/{$id}", $data);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', "/contacts/{$id}");
    }

    public function import(array $data): array
    {
        return $this->client->request('POST', '/contacts/import', $data);
    }
}
