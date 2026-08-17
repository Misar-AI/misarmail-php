# MisarMail PHP SDK

Official PHP SDK for the [MisarMail](https://misarmail.com) API — transactional
send, campaigns, contacts, templates, automations, deliverability, warmup,
monetization and the two AI streams.

Full reference: [`misarmail.com/docs`](https://misarmail.com/docs).

## Install

```bash
composer require misarai/misarmail-php
```

## Auth

Use a MisarMail developer key (`msk_…`), created at
[misarmail.com/developers](https://misarmail.com/developers). It is sent as
`Authorization: Bearer msk_…`.

Every call is metered against the subscription attached to that key. There is no
client-side limit checking — the server decides, and the SDK surfaces its answer.

## Quick start

```bash
<?php
use MisarMail\Client;

$mail = new Client('msk_your_key');

$mail->email->send([
    'from'    => 'you@yourdomain.com',
    'to'      => ['someone@example.com'],
    'subject' => 'Hello',
    'html'    => '<p>Hi there</p>',
]);

$contacts = $mail->contacts->list();
```

## Plan limits

A spent allowance answers `429` and a feature that is not on the plan answers
`402`; both carry `code: "plan_limit_exceeded"`. The SDK raises
`PlanLimitError` for either, and **does not retry** it — retrying cannot
help until the allowance resets or the plan changes. Read ``$upgradeUrl`` to
send the user somewhere useful.

`GET /plan` reports the plan, its allowances and per-feature usage, so an
expensive call can be checked before it is attempted rather than after it is
refused.

```bash
$plan = $mail->plan->get();

try {
    $mail->campaigns->create(['name' => 'Blast']);
} catch (MisarMail\PlanLimitError $e) {
    fwrite(STDERR, "{$e->feature} exhausted on {$e->plan}: {$e->upgradeUrl}\n");
}
```

## Streaming

Two endpoints stream Server-Sent Events. Both sit **outside** `/v1`, which the
SDK handles for you:

| Method | Route |
| --- | --- |
| `streaming.generateEmail` | `POST /api/ai/generate-email/stream` |
| `streaming.campaignSend` | `GET /api/campaigns/{id}/send-stream` |

Frames are unnamed (`data: {…}`) and the stream ends with `data: [DONE]`, which
the SDK consumes rather than handing on. A stream is never retried: replaying one
that failed mid-flight would duplicate whatever you had already read.

```bash
$mail->streaming->generateEmail(['prompt' => 'a launch email'],
    function (MisarMail\StreamEvent $e) {
        echo $e->data['delta'] ?? '';
        // return false to stop the stream early
    });
```

## License

MIT — see [LICENSE](LICENSE).
