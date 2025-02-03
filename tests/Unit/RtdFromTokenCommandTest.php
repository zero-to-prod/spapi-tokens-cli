<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;
use Zerotoprod\SpapiTokensCli\RdtFromToken\RdtFromTokenArguments;
use Zerotoprod\SpapiTokensCli\RdtFromToken\RdtFromTokenCommand;

class RtdFromTokenCommandTest extends TestCase
{
    #[Test] public function command(): void
    {
        $Application = new Application();
        $Application->add(new RdtFromTokenCommand());
        $Command = $Application->find(RdtFromTokenCommand::signature);
        $CommandTester = new CommandTester($Command);

        $CommandTester->execute([
            RdtFromTokenArguments::refresh_token => RdtFromTokenArguments::refresh_token,
            RdtFromTokenArguments::client_id => RdtFromTokenArguments::client_id,
            RdtFromTokenArguments::client_secret => RdtFromTokenArguments::client_secret,
            RdtFromTokenArguments::path => RdtFromTokenArguments::path,
            RdtFromTokenArguments::dataElements => RdtFromTokenArguments::dataElements,
            RdtFromTokenArguments::targetApplication => RdtFromTokenArguments::targetApplication,
        ]);
        
        $CommandTester->assertCommandIsSuccessful();
    }
}