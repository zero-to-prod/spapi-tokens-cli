<?php

namespace Zerotoprod\SpapiTokensCli\RdtFromScope;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;

/**
 * @link https://github.com/zero-to-prod/spapi-tokens-cli
 */
class RdtFromScopeArguments
{
    use DataModel;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const scope = 'scope';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public string $scope;

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