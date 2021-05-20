<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Test;
use Inertia\Inertia;
use App\Models\Media;
use Telegram\Bot\Api as TelegramApi;
use App\Models\Market;
use App\Utils\Binance;
use App\Models\Taggable;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use anlutro\LaravelSettings\Facade as Setting;

class DashboardController extends Controller
{
    public function __construct()
    {

        // dd(Auth::user());
        // Setting::setExtraColumns(array(
        //     'user_id' => Auth::user()->id
        // ));
    }

    public function index(Binance $binance, Setting $s)
    {
        //$response =  Telegram::getMe();

        // $user_id         = Telegram::getWebhookUpdates()->getMessage()->getFrom()->getId();
        // $user_name         = Telegram::getWebhookUpdates()->getMessage()->getFrom()->getFirstName();
        // $chat_id         = Telegram::getWebhookUpdates()->getMessage()->getChat()->getId();
        // $user_message     = Telegram::getWebhookUpdates()->getMessage()->getText();




        // $botId = $response->getId();
        // $firstName = $response->getFirstName();
        // $username = $response->getUsername();






        return Inertia::render('Admin/Dashboard/Index.vue');
    }
}
