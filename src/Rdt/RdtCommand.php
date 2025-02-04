<?php

namespace Zerotoprod\SpapiTokensCli\Rdt;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zerotoprod\SpapiTokens\SpapiTokens;

#[AsCommand(
    name: RdtCommand::signature,
    description: 'Get a Restricted Data Token (RDT) for restricted resources.'
)]
class RdtCommand extends Command
{
    public const signature = 'spapi-tokens-cli:rdt';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $Args = RdtArguments::from($input->getArguments());
        $Options = RdtOptions::from($input->getOptions());

        $response = SpapiTokens::restrictedDataToken(
            $Args->access_token,
            $Args->path,
            $Args->dataElements,
            $Args->targetApplication,
            $Options->user_agent,
        );

        if ($response['info']['http_code'] !== 200) {
            $output->writeln(json_encode($response, JSON_PRETTY_PRINT));

            return Command::SUCCESS;
        }

        if ($Options->response) {
            $output->writeln(
                json_encode(
                    $response,
                    JSON_PRETTY_PRINT
                )
            );

            return Command::SUCCESS;
        }

        if ($Options->expiresIn) {
            $output->writeln($response['response']['expiresIn']);

            return Command::SUCCESS;
        }

        $output->writeln($response['response']['restrictedDataToken']);

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->addArgument(RdtArguments::access_token, InputArgument::REQUIRED, 'The access_token to get a restricted resource.');
        $this->addArgument(RdtArguments::path, InputArgument::REQUIRED, 'The path in the restricted resource.');
        $this->addArgument(RdtArguments::dataElements, InputArgument::REQUIRED, 'Comma separated list of data elements. Indicates the type of Personally Identifiable Information requested.');
        $this->addArgument(RdtArguments::targetApplication, InputArgument::REQUIRED, 'The application ID for the target application to which access is being delegated.');
        $this->addOption(RdtOptions::user_agent, mode: InputOption::VALUE_OPTIONAL, description: 'User Agent');
        $this->addOption(RdtOptions::response, mode: InputOption::VALUE_NONE, description: 'Returns the full response');
        $this->addOption(RdtOptions::expiresIn, mode: InputOption::VALUE_NONE, description: 'The expiresIn value for the restrictedDataToken');
    }
}