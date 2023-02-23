<?php

declare(strict_types=1);

namespace Services\Telegram;

use Services\Telegram\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;
use Throwable;

// Better use SDK library if need more request to api
// нужно добавить очередь на Http request
final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

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
