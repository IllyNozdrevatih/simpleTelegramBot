<?php
use GuzzleHttp\Client;

class TelegramBot
{
    protected $token="714627997:AAEPstASom72Es59eCqaJhDjMpmIj7jCggw";

    protected $updateId;

    protected function query($method, $params=[])
    {
        $url="https://api.telegram.org/bot";

        $url.=$this->token;

        $url.="/".$method;

        if (!empty($params)) {
            $url.="?".http_build_query($params);
        }

        $client= new Client([
            'base_uri' => $url
        ]);

        $result = $client->request('GET');

        return json_decode($result->getBody());
    }
    public function getUpdates()
    {
        $response=$this->query('getUpdates',[
            'offset' => $this->updateId + 1
        ]);

        if (!empty($response->result)) {
            $this->updateId = $response->result[count($response->result)-1]->update_id;
        }

        return $response->result;
    }

    public function sendMessage($chat_id, $text)
    {
        $response=$this->query('sendMessage', [
            'text'    => $text,
            'chat_id' => $chat_id
        ]);

        return $response;
    }
    public function sendKeyboard($chatId,$text,$buttons)
    {
        $response=$this->query('sendMessage', [
            'text' => $text,
            'chat_id' => $chatId,
            // отправляем встроенную клавиатуру
            'reply_markup' => $buttons,
        ]);

        return $response;
    }
    public function sendPhoto($chat_id , $photo){
        $response=$this->query('sendPhoto', [
        'photo'    => $photo,
        'chat_id' => $chat_id
    ]);

        return $response;
    }

    public function getKeyBoard($data)
    {
        $keyboard = array(
            "keyboard" => $data,
            "one_time_keyboard" => false,
            "resize_keyboard" => true
        );
        return json_encode($keyboard);
    }

    public function InlineKeyboardButton($text,$url){
    }
}
