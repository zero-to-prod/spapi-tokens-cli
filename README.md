# Zerotoprod\SpapiTokensCli

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/spapi-tokens-cli)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-tokens-cli/test.yml?label=test)](https://github.com/zero-to-prod/spapi-tokens-cli/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-tokens-cli/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/spapi-tokens-cli/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-tokens-cli/build_docker_image.yml?label=build_docker_image)](https://github.com/zero-to-prod/spapi-tokens-cli/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/spapi-tokens-cli?color=blue)](https://packagist.org/packages/zero-to-prod/spapi-tokens-cli/stats)
[![php](https://img.shields.io/packagist/php-v/zero-to-prod/spapi-tokens-cli.svg?color=purple)](https://packagist.org/packages/zero-to-prod/spapi-tokens-cli/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/spapi-tokens-cli?color=f28d1a)](https://packagist.org/packages/zero-to-prod/spapi-tokens-cli)
[![License](https://img.shields.io/packagist/l/zero-to-prod/spapi-tokens-cli?color=pink)](https://github.com/zero-to-prod/spapi-tokens-cli/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/spapi-tokens-cli.svg)](https://wakatime.com/badge/github/zero-to-prod/spapi-tokens-cli)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/spapi-tokens-cli?branch=main)](https://hitsofcode.com/github/zero-to-prod/spapi-tokens-cli/view?branch=main)

## Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Documentation Publishing](#documentation-publishing)
    - [Automatic Documentation Publishing](#automatic-documentation-publishing)
- [Usage](#usage)
    - [Available Commands](#available-commands)
        - [`spapi-tokens-cli:src`](#spapi-tokens-clisrc)
        - [`spapi-tokens-cli:rdt`](#spapi-tokens-clirdt)
        - [`spapi-tokens-cli:rdt-from-token`](#spapi-tokens-clirdt-from-token)
        - [`spapi-tokens-cli:rdt-from-scope`](#spapi-tokens-clirdt-from-scope)
- [Docker Image](#docker-image)
- [Local Development](./LOCAL_DEVELOPMENT.md)
- [Image Development](./IMAGE_DEVELOPMENT.md)
- [Contributing](#contributing)

## Introduction

A CLI for getting a Restricted Data Token (RDT) for Amazon Selling Partner API (SPAPI).

## Requirements

- PHP 8.1 or higher.

## Installation

Install `Zerotoprod\SpapiTokensCli` via [Composer](https://getcomposer.org/):

```bash
composer require zero-to-prod/spapi-tokens-cli
```

This will add the package to your project's dependencies and create an autoloader entry for it.

## Documentation Publishing

You can publish this README to your local documentation directory.

This can be useful for providing documentation for AI agents.

This can be done using the included script:

```bash
# Publish to default location (./docs/zero-to-prod/spapi-tokens-cli)
vendor/bin/zero-to-prod-spapi-tokens-cli

# Publish to custom directory
vendor/bin/zero-to-prod-spapi-tokens-cli /path/to/your/docs
```

### Automatic Documentation Publishing

You can automatically publish documentation by adding the following to your `composer.json`:

```json
{
    "scripts": {
        "post-install-cmd": [
            "zero-to-prod-spapi-tokens-cli"
        ],
        "post-update-cmd": [
            "zero-to-prod-spapi-tokens-cli"
        ]
    }
}
```

## Usage

Run this command to see the available commands:

```shell
vendor/bin/spapi-tokens-cli list
```

### Available Commands

#### `spapi-tokens-cli:src`

Displays the project's GitHub repository URL.

**Usage:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:src
```

**Arguments:** None

**Example:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:src
```

**Output:**
```
https://github.com/zero-to-prod/spapi-tokens-cli
```

#### `spapi-tokens-cli:rdt`

Get a Restricted Data Token (RDT) for restricted resources using an existing access token.

**Usage:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:rdt <access_token> <path> <dataElements> <targetApplication> [options]
```

**Arguments:**
- `access_token` (required): The access token to get a restricted resource
- `path` (required): The path in the restricted resource
- `dataElements` (required): Comma separated list of data elements. Indicates the type of Personally Identifiable Information requested
- `targetApplication` (required): The application ID for the target application to which access is being delegated

**Options:**
- `--user_agent`: User Agent (optional)
- `--response`: Returns the full response
- `--expiresIn`: The expiresIn value for the restrictedDataToken

**Example:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:rdt \
  "Atza|IwEBIExampleAccessToken" \
  "/orders/v0/orders/123-4567890-1234567/buyerInfo" \
  "buyerInfo" \
  "amzn1.sp.solution.12345678-1234-1234-1234-123456789012"
```

**Example Response (default - token only):**
```
Atzr|IwEBIB6MHXJl5sLqTf_3n2e7TJQ4a3X7hZ2Y9k8N3F1R6Q5E4P2A9S8D7G6H5J4K3L2M1
```

**Example Response (with --response flag):**
```json
{
    "response": {
        "restrictedDataToken": "Atzr|IwEBIB6MHXJl5sLqTf_3n2e7TJQ4a3X7hZ2Y9k8N3F1R6Q5E4P2A9S8D7G6H5J4K3L2M1",
        "expiresIn": 3600
    },
    "info": {
        "http_code": 200
    }
}
```

**Example Response (with --expiresIn flag):**
```
3600
```

#### `spapi-tokens-cli:rdt-from-token`

Get a Restricted Data Token (RDT) for restricted resources from a refresh token. This command first exchanges the refresh token for an access token, then uses that access token to obtain the RDT.

**Usage:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:rdt-from-token <refresh_token> <client_id> <client_secret> <path> <dataElements> <targetApplication> [options]
```

**Arguments:**
- `refresh_token` (required): The LWA refresh token
- `client_id` (required): Get this value when you register your application
- `client_secret` (required): Get this value when you register your application
- `path` (required): The path in the restricted resource
- `dataElements` (required): Comma separated list of data elements. Indicates the type of Personally Identifiable Information requested
- `targetApplication` (required): The application ID for the target application to which access is being delegated

**Options:**
- `--user_agent`: User Agent (optional)
- `--response`: Returns the full response
- `--expiresIn`: The expiresIn value for the restrictedDataToken

**Example:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:rdt-from-token \
  "Atzr|IwEBIExampleRefreshToken" \
  "amzn1.application-oa2-client.12345678901234567890123456789012" \
  "your-client-secret-here" \
  "/orders/v0/orders/123-4567890-1234567/buyerInfo" \
  "buyerInfo" \
  "amzn1.sp.solution.12345678-1234-1234-1234-123456789012"
```

**Example Response (default - token only):**
```
Atzr|IwEBIB6MHXJl5sLqTf_3n2e7TJQ4a3X7hZ2Y9k8N3F1R6Q5E4P2A9S8D7G6H5J4K3L2M1
```

**Example Response (with --response flag):**
```json
{
    "response": {
        "restrictedDataToken": "Atzr|IwEBIB6MHXJl5sLqTf_3n2e7TJQ4a3X7hZ2Y9k8N3F1R6Q5E4P2A9S8D7G6H5J4K3L2M1",
        "expiresIn": 3600
    },
    "info": {
        "http_code": 200
    }
}
```

**Example Response (with --expiresIn flag):**
```
3600
```

**Example Error Response (invalid credentials):**
```json
{
    "response": {
        "error": "invalid_client",
        "error_description": "Client authentication failed"
    },
    "info": {
        "http_code": 401
    }
}
```

#### `spapi-tokens-cli:rdt-from-scope`

Get a Restricted Data Token (RDT) for restricted resources from a scope using client credentials. This command uses client credentials flow to obtain an access token, then uses that access token to obtain the RDT.

**Usage:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:rdt-from-scope <scope> <client_id> <client_secret> <path> <dataElements> <targetApplication> [options]
```

**Arguments:**
- `scope` (required): The LWA scope for the client credentials flow
- `client_id` (required): Get this value when you register your application
- `client_secret` (required): Get this value when you register your application
- `path` (required): The path in the restricted resource
- `dataElements` (required): Comma separated list of data elements. Indicates the type of Personally Identifiable Information requested
- `targetApplication` (required): The application ID for the target application to which access is being delegated

**Options:**
- `--user_agent`: User Agent (optional)
- `--response`: Returns the full response
- `--expiresIn`: The expiresIn value for the restrictedDataToken

**Example:**
```shell
vendor/bin/spapi-tokens-cli spapi-tokens-cli:rdt-from-scope \
  "sellingpartnerapi::notifications" \
  "amzn1.application-oa2-client.12345678901234567890123456789012" \
  "your-client-secret-here" \
  "/orders/v0/orders/123-4567890-1234567/buyerInfo" \
  "buyerInfo" \
  "amzn1.sp.solution.12345678-1234-1234-1234-123456789012"
```

**Example Response (default - token only):**
```
Atzr|IwEBIB6MHXJl5sLqTf_3n2e7TJQ4a3X7hZ2Y9k8N3F1R6Q5E4P2A9S8D7G6H5J4K3L2M1
```

**Example Response (with --response flag):**
```json
{
    "response": {
        "restrictedDataToken": "Atzr|IwEBIB6MHXJl5sLqTf_3n2e7TJQ4a3X7hZ2Y9k8N3F1R6Q5E4P2A9S8D7G6H5J4K3L2M1",
        "expiresIn": 3600
    },
    "info": {
        "http_code": 200
    }
}
```

**Example Response (with --expiresIn flag):**
```
3600
```

**Example Error Response (invalid scope):**
```json
{
    "response": {
        "error": "invalid_scope",
        "error_description": "The scope sellingpartnerapi::notifications is not valid for this application"
    },
    "info": {
        "http_code": 400
    }
}
```

## Docker Image

You can also run the cli using the [docker image](https://hub.docker.com/repository/docker/davidsmith3/spapi-tokens-cli/general):

```shell
docker run --rm davidsmith3/spapi-tokens-cli
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/spapi-tokens-cli/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.
