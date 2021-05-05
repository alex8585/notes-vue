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
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CupConstructorController extends Controller
{
    public function __construct()
    {
    }

    public function index(HttpRequest $request, Setting $s)
    {
        $path = setting('path');
      
        return Inertia::render('CupConstructor/Index.vue', ['path' => $path]);
    }

    public function saveImage(HttpRequest $request)
    {
        $p = Storage::put('public/CupConstructor', $request->photo);
        $path = str_replace('public', "storage", $p);

        setting(['path' => $path])->save();

        return Redirect::route('cup-constructor')->with([
            'path' =>  $path,
            'result' => 'success',
        ]);;
    }
}
