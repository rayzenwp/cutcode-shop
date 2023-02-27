<?php

declare(strict_types=1);

namespace Services\Telegram;

use Services\Telegram\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;
use Throwable;

// Better use SDK library if need more request to api
// нужно добавить очередь на Http request
class TelegramBotApi implements TelegramBotApiContract
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function fake(): TelegramBotApiFake
    {
        return app()->instance(
            TelegramBotApiContract::class,
            new TelegramBotApiFake()
        );
    }

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text
            ])->throw()->json();

            $status = $response['ok'] ?? false;

            return $status;

        } catch (Throwable $e) {
            report(new TelegramBotApiException($e->getMessage())); // в лог отправляется но не отображается пользователю
            return false;
        }

    }
}
