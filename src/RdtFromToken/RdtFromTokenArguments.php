<?php

namespace Zerotoprod\SpapiTokensCli\RdtFromToken;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;

/**
 * @link https://github.com/zero-to-prod/spapi-tokens-cli
 */
class RdtFromTokenArguments
{
    use DataModel;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const refresh_token = 'refresh_token';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public string $refresh_token;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const client_id = 'client_id';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public string $client_id;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const client_secret = 'client_secret';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public string $client_secret;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const path = 'path';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public string $path;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const dataElements = 'dataElements';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    #[Describe(['cast' => [self::class, 'dataElements']])]
    public array $dataElements = [];

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public static function dataElements(string $value): array
    {
        return $value
            ? explode(',', $value)
            : [];
    }

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const targetApplication = 'targetApplication';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public string $targetApplication;
}