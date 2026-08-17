<?php

declare(strict_types=1);

namespace MisarMail;

// ── Resource: Aliases ─────────────────────────────────────────────────────────

class AliasesResource
{
    public function __construct(private readonly Client $client) {}

    public function list(): array
    {
        return $this->client->request('GET', '/aliases');
    }

    public function create(array $data): array
    {
        return $this->client->request('POST', '/aliases', $data);
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', "/aliases/{$id}");
    }

    public function update(string $id, array $data): array
    {
        return $this->client->request('PATCH', "/aliases/{$id}", $data);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', "/aliases/{$id}");
    }
}
