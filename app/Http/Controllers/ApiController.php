<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram\Bot\Api;

class ApiController extends Controller
{

    public function me()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $telegram->getMe();
        return $response;
    }


    public function update()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $telegram->getUpdates();
        return $response;
    }

    // public function respond(){
    //     $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    //     $response = $telegram->getUpdates();
    //     $request = collect(end($response)); // fetch the last request from the collection

    //     $chatid = $request['message']['chat']['id']; // get chatid from request
    //     $text = $request['message']['text']; // get the user sent text

    //     $response = $telegram->sendMessage([
    //       'chat_id' => $chatid, 
    //       'text' => 'Hey! This is bot sending you the first message :)'
    //     ]);
    // }

    public function respond()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $telegram->getUpdates();
        $request = collect(end($response));

        $chatid = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        switch ($text) {
            case '/start':
                $this->showMenu($telegram, $chatid);
                break;
            case '/menu':
                $this->showMenu($telegram, $chatid);
                break;
            case '/website':
                $this->showWebsite($telegram, $chatid);
                break;
            case '/contact';
                $this->showContact($telegram, $chatid);
                break;
            default:
                $info = 'I do not understand what you just said. Please choose an option';
                $this->showMenu($telegram, $chatid, $info);
        }
    }

    public function webhook(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $chatid = $request['message']['chat']['id'];
        $text = $request['message']['text'];

        switch ($text) {
            case '/start':
                $this->showMenu($telegram, $chatid);
                break;
            case '/menu':
                $this->showMenu($telegram, $chatid);
                break;
            case '/website':
                $this->showWebsite($telegram, $chatid);
                break;
            case '/contact';
                $this->showContact($telegram, $chatid);
                break;
            default:
                $info = 'I do not understand what you just said. Please choose an option';
                $this->showMenu($telegram, $chatid, $info);
        }
    }

    public function setWebHook()
    {
        $telegram = new Api(env('TELEGRAM-BOT-TOKEN'));

        $response = $telegram->setWebhook(['url' => 'https://limitless-wave-38455.herokuapp.com/442718912:AAFfm5yVq225XAsWMNRi7lifOVcRmFmsDjg/webhook']);

        return $response;
    }

    public function showMenu($telegram, $chatid, $info = null)
    {
        $message = '';
        if ($info !== null) {
            $message .= $info . chr(10);
        }
        $message .=  '/website' . chr(10);
        $message .= '/contact' . chr(10);

        $response = $telegram->sendMessage([
            'chat_id' => $chatid,
            'text' => $message
        ]);
    }

    public function showWebsite($telegram, $chatid)
    {
        $message = 'http://google.com';

        $response = $telegram->sendMessage([
            'chat_id' => $chatid,
            'text' => $message
        ]);
    }

    public function showContact($telegram, $chatid)
    {
        $message = 'info@jqueryajaxphp.com';

        $response = $telegram->sendMessage([
            'chat_id' => $chatid,
            'text' => $message
        ]);
    }
}
