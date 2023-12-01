# Plugin Features for PHP

[![Tests](https://img.shields.io/github/actions/workflow/status/artkonekt/xtend/tests.yml?branch=master&style=flat-square)](https://github.com/artkonekt/xtend/actions?query=workflow%3Atests)
[![Packagist version](https://img.shields.io/packagist/v/konekt/xtend.svg?style=flat-square)](https://packagist.org/packages/konekt/xtend)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/xtend.svg?style=flat-square)](https://packagist.org/packages/konekt/xtend)
[![StyleCI](https://styleci.io/repos/725654237/shield?branch=master)](https://styleci.io/repos/725654237)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)


## Requirements

- PHP 8.2+

## Features

- Registries
- Hooks

## Installation

You can install the package via composer:

```bash
composer require konekt/xtend
```

## Usage

### Registries

The following example shows a sample registry that holds reference to various PaymentGateway implementations.

Steps:

1. Create a class
2. Add the `Registry` interface
3. Use the `HasRegistry` and `RequiresClassOrInterface` traits
4. Add the `$requiredInterface` static property, and set the interface

```php
final class PaymentGateways implements Registry
{
    use HasRegistry;
    use RequiresClassOrInterface;
    
    private static string $requiredInterface = PaymentGateway::class;
}
```

Having that, other developers can add new payment gateways:

```php
PaymentGateways::add('braintree', BrainTreePaymentGateway::class);
```
