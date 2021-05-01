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

class ConstructorController extends Controller
{
    public function __construct()
    {
    }

    public function index(Binance $binance, Setting $s)
    {
        $fonts = [
            'Arial',
            'Alexa',
            'Allura',
            'Dancer',
            'Darcey',
            'Gruenewald',
            'NewCursive',
            'Vintage',
            'Vultures',
            'Amanda',
            'Nickainley',
            'cantilena',
            'Signature',
            'Hamillton',
            'Hesterica',
            'LoveNote',
            'Northwell',
            'Quinzey',
            'RedVelvet',
            'Rocket',
            'WildSpirit',
            'AvantGarde',
            'Bauhaus',
            'DolceVita',
            'Kiona',
            'NixieOne',
            'PaperDaisy',
            'Bayshore',
            'Roboto',
            'Lovelo',
            'NeonGlow',
            'NeonLite',
            'NeonTube',
            'Budhayanti',
            'KBWriters',
            'Ahsley',
            'Linoleo',
            'Seaside',
            'Southampton',
            'Echo',
            'Sebastrian',
            'MarqueeMoon',
            'TypewrittenTypewriter',
        ];


        //dd('7');






        return Inertia::render('Constructor/Index.vue', compact('fonts'));
    }
}
