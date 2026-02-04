# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-04

### Added

- Initial release
- ApcoPay service for hosted payment page and payment status
- `getHostedPage()` for redirecting users to ApcoPay hosted page
- `getPayment()` for retrieving payment status
- `getPaymentWithRetry()` for polling payment status with retries
- `PaymentStateFields` enum for payment state values (CANCELLED, SUCCESS, FAILED)
- `ApcoPayServiceInterface` contract for dependency injection
- Configurable sandbox and production environments
- `apcopay-config` publish tag for config customization
