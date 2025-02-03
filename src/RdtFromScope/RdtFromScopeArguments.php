<?php

namespace Zerotoprod\SpapiTokensCli\RdtFromScope;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;

class RdtFromScopeArguments
{
    use DataModel;

    public const scope = 'scope';
    public string $scope;

    public const client_id = 'client_id';
    public string $client_id;

    public const client_secret = 'client_secret';
    public string $client_secret;

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