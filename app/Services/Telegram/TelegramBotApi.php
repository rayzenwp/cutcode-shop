<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

// Better use SDK library if need more request to api
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

        } catch (\Throwable $exception) {
            //throw new Exception('My first Sentry error! '.$exception);
            //report(new TelegramBotApiException($exception->getMessage()));
            return false;
        }

    }
}
