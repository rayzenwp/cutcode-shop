<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Services\Telegram\TelegramBotApi;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Services\Telegram\TelegramBotApiContract;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;
    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->chatId = (int) $config['chat_id'];
        $this->token = (string) $config['token'];
    }

    protected function write(array $record): void
    {
        TelegramBotApiContract::sendMessage($this->token, $this->chatId, $record['formatted']);
	}

}
