<?php

namespace Zerotoprod\SpapiTokensCli\RdtFromToken;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zerotoprod\SpapiLwa\SpapiLwa;
use Zerotoprod\SpapiTokens\SpapiTokens;

#[AsCommand(
    name: RdtFromTokenCommand::signature,
    description: 'Get a Restricted Data Token (RDT) for restricted resources from a refresh_token.'
)]
class RdtFromTokenCommand extends Command
{
    public const signature = 'spapi-tokens-cli:rdt-from-token';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $Args = RdtFromTokenArguments::from($input->getArguments());
        $Options = RdtFromTokenOptions::from($input->getOptions());

        $response = SpapiLwa::from(
            $Args->client_id,
            $Args->client_secret,
            user_agent: $Options->user_agent
        )->refreshToken($Args->refresh_token);

        if ($response['info']['http_code'] !== 200) {
            $output->writeln(json_encode($response, JSON_PRETTY_PRINT));

            return Command::SUCCESS;
        }

        $rdt_response = SpapiTokens::from(
            $response['response']['access_token'],
            $Args->targetApplication,
            user_agent: $Options->user_agent,
        )->createRestrictedDataToken($Args->path, $Args->dataElements);

        if ($rdt_response['info']['http_code'] !== 200) {
            $output->writeln(json_encode($response, JSON_PRETTY_PRINT));

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
        $this->addArgument(RdtFromTokenArguments::refresh_token, InputArgument::REQUIRED, 'The LWA refresh token');
        $this->addArgument(RdtFromTokenArguments::client_id, InputArgument::REQUIRED, 'Get this value when you register your application');
        $this->addArgument(RdtFromTokenArguments::client_secret, InputArgument::REQUIRED, 'Get this value when you register your application');
        $this->addArgument(RdtFromTokenArguments::path, InputArgument::REQUIRED, 'The path in the restricted resource.');
        $this->addArgument(RdtFromTokenArguments::dataElements, InputArgument::REQUIRED, 'Comma separated list of data elements. Indicates the type of Personally Identifiable Information requested.');
        $this->addArgument(RdtFromTokenArguments::targetApplication, InputArgument::REQUIRED, 'The application ID for the target application to which access is being delegated.');
        $this->addOption(RdtFromTokenOptions::user_agent, mode: InputOption::VALUE_OPTIONAL, description: 'User Agent');
        $this->addOption(RdtFromTokenOptions::response, mode: InputOption::VALUE_NONE, description: 'Returns the full response');
        $this->addOption(RdtFromTokenOptions::expiresIn, mode: InputOption::VALUE_NONE, description: 'The expiresIn value for the restrictedDataToken');
    }
}