<?php

declare(strict_types=1);

namespace MisarMail;

// ── Resource: Workspaces ──────────────────────────────────────────────────────

class WorkspacesResource
{
    private const BILLING_BASE = 'https://api.misar.io/mail';

    public function __construct(private readonly Client $client) {}

    public function list(): array
    {
        return $this->client->request('GET', '/workspaces', [], self::BILLING_BASE);
    }

    public function create(array $data): array
    {
        return $this->client->request('POST', '/workspaces', $data, self::BILLING_BASE);
    }

    public function get(string $id): array
    {
        return $this->client->request('GET', "/workspaces/{$id}", [], self::BILLING_BASE);
    }

    public function update(string $id, array $data): array
    {
        return $this->client->request('PATCH', "/workspaces/{$id}", $data, self::BILLING_BASE);
    }

    public function delete(string $id): array
    {
        return $this->client->request('DELETE', "/workspaces/{$id}", [], self::BILLING_BASE);
    }

    public function listMembers(string $wsId): array
    {
        return $this->client->request('GET', "/workspaces/{$wsId}/members", [], self::BILLING_BASE);
    }

    public function inviteMember(string $wsId, array $data): array
    {
        return $this->client->request('POST', "/workspaces/{$wsId}/members", $data, self::BILLING_BASE);
    }

    public function updateMember(string $wsId, string $userId, array $data): array
    {
        return $this->client->request('PATCH', "/workspaces/{$wsId}/members/{$userId}", $data, self::BILLING_BASE);
    }

    public function removeMember(string $wsId, string $userId): array
    {
        return $this->client->request('DELETE', "/workspaces/{$wsId}/members/{$userId}", [], self::BILLING_BASE);
    }
}
