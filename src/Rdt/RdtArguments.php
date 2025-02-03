<?php

namespace Zerotoprod\SpapiTokensCli\Rdt;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;

class RdtArguments
{
    use DataModel;

    public const access_token = 'access_token';
    public string $access_token;

    public const path = 'path';
    public string $path;

    public const dataElements = 'dataElements';
    #[Describe(['cast' => [self::class, 'dataElements']])]
    public array $dataElements = [];

    public static function dataElements(string $value): array
    {
        return $value
            ? explode(',', $value)
            : [];
    }

    public const targetApplication = 'targetApplication';
    public string $targetApplication;
}