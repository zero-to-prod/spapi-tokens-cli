<?php

namespace Zerotoprod\SpapiTokensCli;

use Symfony\Component\Console\Application;
use Zerotoprod\SpapiTokensCli\Rdt\RdtCommand;
use Zerotoprod\SpapiTokensCli\RdtFromScope\RdtFromScopeCommand;
use Zerotoprod\SpapiTokensCli\RdtFromToken\RdtFromTokenCommand;
use Zerotoprod\SpapiTokensCli\Src\SrcCommand;

/**
 * A CLI for getting a Restricted Data Token (RDT) for Amazon Selling Partner API (SPAPI).
 *
 * @link https://github.com/zero-to-prod/spapi-tokens-cli
 */
class SpapiTokensCli
{
    /**
     * @link https://github.com/zero-to-prod/spapi-tokens-cli
     */
    public static function register(Application $Application): void
    {
        $Application->add(new SrcCommand());
        $Application->add(new RdtCommand());
        $Application->add(new RdtFromTokenCommand());
        $Application->add(new RdtFromScopeCommand());
    }
}