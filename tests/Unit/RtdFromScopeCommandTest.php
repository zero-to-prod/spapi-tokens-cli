<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;
use Zerotoprod\SpapiTokensCli\RdtFromScope\RdtFromScopeArguments;
use Zerotoprod\SpapiTokensCli\RdtFromScope\RdtFromScopeCommand;

class RtdFromScopeCommandTest extends TestCase
{
    #[Test] public function command(): void
    {
        $Application = new Application();
        $Application->add(new RdtFromScopeCommand());
        $Command = $Application->find(RdtFromScopeCommand::signature);
        $CommandTester = new CommandTester($Command);

        $CommandTester->execute([
            RdtFromScopeArguments::scope => RdtFromScopeArguments::scope,
            RdtFromScopeArguments::client_id => RdtFromScopeArguments::client_id,
            RdtFromScopeArguments::client_secret => RdtFromScopeArguments::client_secret,
            RdtFromScopeArguments::path => RdtFromScopeArguments::path,
            RdtFromScopeArguments::dataElements => RdtFromScopeArguments::dataElements,
            RdtFromScopeArguments::targetApplication => RdtFromScopeArguments::targetApplication
        ]);

        $CommandTester->assertCommandIsSuccessful();
    }
}