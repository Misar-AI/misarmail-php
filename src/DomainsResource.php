<?php

declare(strict_types=1);

namespace MisarMail;

// ── Resource: Domains ─────────────────────────────────────────────────────────

class DomainsResource
{
    public function __construct(private readonly Client $client) {}

    public function list(): array
    {
        return $this->client->request('GET', '/domains');
    }

    public function create(array $data): array
    {
        return $this->client->request('POST', '/domains', $data);
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', "/domains/{$id}");
    }

    public function verify(string $id): array
    {
        return $this->client->request('POST', "/domains/{$id}/verify");
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', "/domains/{$id}");
    }
}
