<?php

namespace user\ex2\SocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecWebSocketServer extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:cliApp')
            ->addArgument('address', InputArgument::REQUIRED)
            ->addArgument('port', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \HttpSocketException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $address = $input->getArgument('address');
        $port = $input->getArgument('port');
        $WebSocketServer = new WebSocketServer($address,$port);
        $WebSocketServer->run();
    }

}