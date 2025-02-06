<?php

namespace Zerotoprod\SpapiTokensCli\RdtFromScope;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zerotoprod\SpapiLwa\SpapiLwa;
use Zerotoprod\SpapiTokens\SpapiTokens;

#[AsCommand(
    name: RdtFromScopeCommand::signature,
    description: 'Get a Restricted Data Token (RDT) for restricted resources from a scope.'
)]
class RdtFromScopeCommand extends Command
{
    public const signature = 'spapi-tokens-cli:rdt-from-scope';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $Args = RdtFromScopeArguments::from($input->getArguments());
        $Options = RdtFromScopeOptions::from($input->getOptions());

        $response = SpapiLwa::clientCredentials(
            'https://api.amazon.com/auth/o2/token',
            $Args->scope,
            $Args->client_id,
            $Args->client_secret,
            $Options->user_agent
        );

        if ($response['info']['http_code'] !== 200) {
            $output->writeln(json_encode($response, JSON_PRETTY_PRINT));

            return Command::SUCCESS;
        }

        $rdt_response = SpapiTokens::createRestrictedDataToken(
            $response['response']['access_token'],
            $Args->path,
            $Args->dataElements,
            $Args->targetApplication,
            user_agent: $Options->user_agent
        );
        if ($rdt_response['info']['http_code'] !== 200) {
            $output->writeln(json_encode($rdt_response, JSON_PRETTY_PRINT));

            return Command::SUCCESS;
        }

        if ($Options->response) {
            $output->writeln(
                json_encode(
                    $rdt_response,
                    JSON_PRETTY_PRINT
                )
            );

            return Command::SUCCESS;
        }

        if ($Options->expiresIn) {
            $output->writeln($rdt_response['response']['expiresIn']);

            return Command::SUCCESS;
        }

        $output->writeln($rdt_response['response']['restrictedDataToken']);

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->addArgument(RdtFromScopeArguments::scope, InputArgument::REQUIRED, 'The LWA refresh token');
        $this->addArgument(RdtFromScopeArguments::client_id, InputArgument::REQUIRED, 'Get this value when you register your application');
        $this->addArgument(RdtFromScopeArguments::client_secret, InputArgument::REQUIRED, 'Get this value when you register your application');
        $this->addArgument(RdtFromScopeArguments::path, InputArgument::REQUIRED, 'The path in the restricted resource.');
        $this->addArgument(RdtFromScopeArguments::dataElements, InputArgument::REQUIRED, 'Comma separated list of data elements. Indicates the type of Personally Identifiable Information requested.');
        $this->addArgument(RdtFromScopeArguments::targetApplication, InputArgument::REQUIRED, 'The application ID for the target application to which access is being delegated.');
        $this->addOption(RdtFromScopeOptions::user_agent, mode: InputOption::VALUE_OPTIONAL, description: 'User Agent');
        $this->addOption(RdtFromScopeOptions::response, mode: InputOption::VALUE_NONE, description: 'Returns the full response');
        $this->addOption(RdtFromScopeOptions::expiresIn, mode: InputOption::VALUE_NONE, description: 'The expiresIn value for the restrictedDataToken');
    }
}