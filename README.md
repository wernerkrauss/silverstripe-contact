# silverstripe-contact

Simple contact module for Silverstripe CMS 5/6: an Elemental block with an htmx-powered
contact form, submission storage in the CMS and email notification. Spam protection via
`silverstripe/spamprotection` (e.g. honeypot) is enabled automatically when a protector
is configured.

## Installation

```bash
composer require wernerkrauss/silverstripe-contact
```

Then run `dev/build?flush=1`.

## Usage

1. Add the **Contact** block to a page in the CMS (Content → Blocks). The form submits via
   htmx to `<page>/element/<id>/renderForm` and swaps in the form partial or a success
   message without a full page reload.
2. Submitted messages are stored as `ContactRequest` records and listed under
   **Contact requests** in the CMS (`ContactAdmin`).
3. In SiteConfig → Contact form, set the **sender** and **recipient** email addresses and
   the success message.

## Spam protection

The form calls `enableSpamProtection()` only if a spam protector is configured. To use the
honeypot protector:

```bash
composer require innoweb/silverstripe-spamprotection-honeypot
```

```yaml
SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension:
  default_spam_protector: innoweb\spamprotection\honeypot\HoneypotProtector
```

## Requirements

- PHP 8.1+ (8.4+ for Silverstripe 6)
- silverstripe/framework + silverstripe/cms `^5 || ^6`
- dnadesign/silverstripe-elemental `^5 || ^6`
- silverstripe/spamprotection `^4 || ^5`

## License

MIT — see [LICENSE](LICENSE).
