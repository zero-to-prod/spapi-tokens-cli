<?php

namespace Zerotoprod\SpapiTokensCli\Rdt;

use Zerotoprod\DataModel\DataModel;

/**
 * @link https://github.com/zero-to-prod/spapi-tokens-cli
 */
class RdtOptions
{
    use DataModel;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const user_agent = 'user_agent';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public ?string $user_agent = null;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const response = 'response';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public bool $response = false;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public const expiresIn = 'expiresIn';
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public bool $expiresIn = false;
}