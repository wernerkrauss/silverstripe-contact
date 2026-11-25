# Changelog

All notable changes to this module are documented here.
The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.0] - 2026-11-25

### Added

- Initial release: contact form as Elemental block (`Netwerkstatt\Contact\Element\Contact`)
  with htmx-powered form submission (`ContactFormTrait`, `renderForm` partial + success view).
- `ContactRequest` DataObject storing submissions, viewable in `ContactAdmin` (CMS model admin).
- Email notification on submission with configurable sender/recipient in SiteConfig.
- Spam protection via `silverstripe/spamprotection`: `enableSpamProtection()` is called only
  when a protector is configured (e.g. `innoweb/silverstripe-spamprotection-honeypot` as
  `default_spam_protector`).
- Translations: de, en, es, it, nl, pt.
- PHPUnit smoke tests and CI (reusable Silverstripe CI) on GitHub Actions.
