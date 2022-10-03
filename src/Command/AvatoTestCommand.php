<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

define('TIME_TO_WAIT', 60);

class AvatoTestCommand extends Command
{
    protected static $defaultName = 'app:avato:test';
    protected static $defaultDescription = 'Add a short description for your command';
    private UrlGeneratorInterface $router;
    private HttpClientInterface $client;

    public function __construct(
        UrlGeneratorInterface $router,
        HttpClientInterface $client
    )
    {
        $this->router = $router;
        $this->client = $client;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'str',
                InputArgument::REQUIRED,
                'Argument description'
            )
            ->addOption(
                'requests',
                null,
                InputOption::VALUE_OPTIONAL,
                'I entered the number of requests to be made',
                1
            )
        ;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int
    {
        $io = new SymfonyStyle($input, $output);
        $context = $this->router->getContext();
        $context->setHost('localhost:8000');
        $str = $input->getArgument('str');
        $requests = $input->getOption('requests');
        $date = new \DateTime();
        for($index = 1; $index <= $requests; $index++){
            $strGeneratedHash = $this->RequestGenerateHash($str, $index, $date);
            $str = $strGeneratedHash;

        }

        return Command::SUCCESS;
    }

    private function RequestGenerateHash(string $str, $req, \DateTime $date)
    {

        $response = $this->postRequest(
            'api_generate_hash',
             ['str' => $str]
        );

        if($response->getStatusCode() == 429){

            $executionTime = $this->dateDiff($date);
            $msg = "[maximum limit of 10 requests every 1 minute]".PHP_EOL;
            printf( $msg);
            sleep(TIME_TO_WAIT);
            $strResponse = $this->RequestGenerateHash($str, $req, $date);
        }else{
            $arrResponse = $response->toArray();
            $arr = $this->createRequestSaveHash($str, $req, $arrResponse, $date);
            $msg = '[input]: '.$str.' [key]: '.$arrResponse['key'];
            $msg .= ' [hash]: '.$arrResponse['hash'].PHP_EOL;
            printf($msg);
            $strResponse = $arr['generatedHash'];
        }

        return $strResponse;
    }

    private function dateDiff(\DateTime $dateStart): string
    {
        $dateEnd = new \DateTime('NOW');
        $diff   =   $dateStart->diff($dateEnd, true);
        return $diff->format( '%s' );
    }

    private function createRequestSaveHash(
        string $input,
        int $blockNumber,
        array $arrResponse,
        \DateTime $date
    ): array
    {

        $response = $this->postRequest(
            '_api_/hashes.{_format}_post',
            [
                'batch' => $date->format(DATE_W3C),
                'input' => $input,
                'key' => $arrResponse['key'],
                'blockNumber' => $blockNumber,
                'generatedHash' => $arrResponse['hash'],
                'numberOfAttempts' => $arrResponse['numberOfAttempts']
            ]
        );
        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function postRequest(
        string $routeName,
        array $arrayToJson
    ): ResponseInterface
    {
        $url = $this->router->generate(
            $routeName,
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return $this->client->request(
            'POST',
            $url,
            ['json' => $arrayToJson]
        );
    }
}
