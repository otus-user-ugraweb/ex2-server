<?php
namespace user\ex2\SocketServer;

use HttpSocketException;

class WebSocketServer
{
    private $port;
    private $address;
    private $socket;
    private $bufferSize;

    /**
     * WebSocketServer constructor.
     * @param $address
     * @param $port
     * @param int $bufferSize
     * @throws HttpSocketException
     */
    public function __construct($address, $port, $bufferSize = 2048)
    {
        $this->address = $address;
        $this->port = $port;
        $this->bufferSize = $bufferSize;
        $this->socketParamInitialize();
    }

    /**
     * @throws HttpSocketException
     */
    public function run()
    {
        while (true) {
            if (($resSocket = socket_accept($this->socket)) < 0) {
                throw new HttpSocketException();
            }
            while (true) {
                if (false === ($buffer = $this->readMessage($resSocket))) {
                    throw new HttpSocketException();
                }
                if ($buffer == 'destroy') {
                    $this->destroySocket();
                    break 2;
                }
                $statusValid = (new Validator($buffer))->checkSequence();
                echo "Получена последовательность: " .  $buffer . "\n" . $statusValid . "\n";
                $this->writeMessage($resSocket, $statusValid);
                break 1;
            }
        }
    }

    public function writeMessage(&$messageFromSocket, $msg)
    {
        socket_write($messageFromSocket, $msg, strlen($msg));
    }

    public function readMessage(&$messageFromSocket)
    {
        return socket_read($messageFromSocket, $this->bufferSize);
    }

    public function destroySocket()
    {
        socket_close($this->socket);
    }

    /**
     * @throws HttpSocketException
     */
    private function socketParamInitialize()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (((socket_bind($this->socket, $this->address, $this->port)) < 0) ||
            ((socket_listen($this->socket, SOMAXCONN)) < 0)) {
            throw new HttpSocketException();
        } else {
            echo "Сокет успешно открыт\n";
        }
    }


}