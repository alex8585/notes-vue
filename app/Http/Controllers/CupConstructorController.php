<?php

namespace App\Http\Controllers;

use App\Models\Cup;
use App\Models\Tag;
use App\Models\Test;
use Inertia\Inertia;
use App\Models\Media;
use App\Models\Market;
use App\Utils\Binance;
use App\Models\Taggable;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api as TelegramApi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request as HttpRequest;
use anlutro\LaravelSettings\Facade as Setting;

class CupConstructorController extends Controller
{
    public function __construct()
    {
    }

    public function index(HttpRequest $request, Setting $s)
    {


        $cup = Cup::latest('updated_at')->first();

        $thumbnail = $path = null;
        if ($cup) {
            $path = $cup->imgUrl;
            $thumbnail = $cup->ImgUrl20;
        }
        return Inertia::render('CupConstructor/Index.vue', [
            'path' => '',
            'thumbnail' => ''
        ]);
    }

    public function saveImage(HttpRequest $request)
    {
        //$p = Storage::put('public/CupConstructor', $request->photo);
        //$path = str_replace('public', "storage", $p);

        //setting(['path' => $path])->save();

        $thumbnail = $path = null;
        if ($request->photo) {
            $path = $request->photo->store('cups');

            $cup = Cup::firstOrCreate(
                ['img' => $path],
                ['user_id' => Auth::user()->id, 'img' =>  $path]
            );
            $path = $cup->imgUrl;
            $thumbnail = $cup->ImgUrl20;
        }

        return [
            'path' =>  $path,
            'thumbnail' => $thumbnail,
            'result' => 'success',
        ];


        // return Redirect::route('cup-constructor')->with([
        //     'path' =>  $path,
        //     'thumbnail' => $thumbnail,
        //     'result' => 'success',
        // ]);;
    }
}
