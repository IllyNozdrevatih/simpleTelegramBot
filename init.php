<?php

include('vendor/autoload.php');
include('TelegramBot.php');
//Получаем сообщение
$telegramApi = new TelegramBot();
$updates = $telegramApi->getUpdates();

//print_r($updates);
while (true) {
    sleep(1);
    $updates = $telegramApi->getUpdates();
    //Продвегаемся по каждому сообщению
    foreach ($updates as $update) {
        $UserText=$update->message->text;
        $chatId = $update->message->chat->id;

        if ($UserText == 'Привет') {
            $telegramApi->sendMessage($chatId, "Привет!");
            $UserText=$update->message->text;
            $justKeyboard = $telegramApi->getKeyBoard([[["text" => "Как дела?"], ["text" => "Что делаешь?"]]]);
            $telegramApi->sendKeyboard($chatId,'Выберите вариант сообщения',$justKeyboard);
        } elseif ($UserText == "Как дела?"){
            $telegramApi->sendMessage($chatId, "Хорошо!");
            $telegramApi->sendPhoto($chatId, "http://joxi.ru/KAgOvbGf4DbJnA");
        } elseif ($UserText == "Что делаешь?"){
            $telegramApi->sendMessage($chatId, "Работаю!");
            $telegramApi->sendPhoto($chatId, "http://joxi.ru/5mdajlMfkgQJp2");
        }else {
            $telegramApi->sendMessage($chatId, "Не понимаю");
        }
    }
}
