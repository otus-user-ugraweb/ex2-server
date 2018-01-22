<?
use Symfony\Component\Console\Application;
use user\ex2\SocketServer\ExecWebSocketServer;
require __DIR__ . '/../vendor/autoload.php';

$application = new Application();
$application->add(new ExecWebSocketServer());
$application->run();