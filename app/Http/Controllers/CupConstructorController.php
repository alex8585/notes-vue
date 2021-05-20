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
        return Inertia::render('Admin/CupConstructor/Index.vue', [
            'path' => '',
            'thumbnail' => ''
        ]);
    }

    public function saveImage(HttpRequest $request)
    {
        //$p = Storage::put('public/CupConstructor', $request->photo);
        //$path = str_replace('public', "storage", $p);

        //setting(['path' => $path])->save();




        $path = null;
        if ($request->photo) {
            $path = $request->photo->store('cups');
            $data = getimagesize($request->photo);
            $params = ['real_width' => $data[0], 'real_height' => $data[1]];

            $cup = Cup::firstOrCreate(
                ['img' => $path],
                ['user_id' => Auth::user()->id, 'img' =>  $path, 'params' => $params],
            );
            $path = $cup->ImgUrl;

            return [
                'path' =>  $path,
                'cup_id' => $cup->id,
                'result' => 'success',
            ];
        }


        return null;

        // return Redirect::route('cup-constructor')->with([
        //     'path' =>  $path,
        //     'thumbnail' => $thumbnail,
        //     'result' => 'success',
        // ]);;
    }
    public function cropImage(HttpRequest $request)
    {
        $cup = Cup::findOrFail($request->cup_id);

        $params['real_width'] = $cup->params['real_width'];
        $params['real_height'] = $cup->params['real_height'];


        $params['width'] =  $params['real_width'] * $request->width / 100;
        $params['height'] = $params['real_height'] * $request->height / 100;

        $params['left'] = $params['real_width'] * $request->left / 100;
        $params['top'] =  $params['real_height'] *  $request->top / 100;

        $cup->params = $params;
        $cup->save();

        return [
            'cropped' => $cup->croppedImgUrl,
            'result' => 'success',
        ];
    }
}
