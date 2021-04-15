<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index');
    }

    public function old()
    {

        // Artisan::call('migrate');

        // $media = Media::create([
        //     'name'         => 'media name1',
        // ]);

        // $tag = $media->tags()->create([
        //     'name' => 'tag name1',

        // ]);




        // $tag1 = Tag::firstOrCreate(
        //     ['name' => 'tag1'],
        // );

        // $tag2 = Tag::firstOrCreate(
        //     ['name' => 'tag2'],
        // );

        // $post = Media::create([
        //     'name' => 'tag name1',

        // ]);
        // $insertData = [
        //     ['tag_id' => $tag1->id, 'taggable_id' => $post->id, 'taggable_type' => Media::class],
        //     ['tag_id' => $tag2->id, 'taggable_id' => $post->id, 'taggable_type' => Media::class],

        // ];
        // Taggable::insert($insertData);

        // //dd('');
        // $tests = Test::select(['tests.id as id', 'records.id as record_id', 'firmwares.id as firmware_id'])

        //     ->join('records', 'tests.id', '=', 'records.test_id')
        //     ->join('firmwares', 'firmwares.id', '=', 'records.firmware_id')
        //     ->with(['firmvares' => function ($query) {
        //         //$query->where('records.firmware_id', '=', '1');
        //     }])
        //     ->whereHas('firmvares', function ($query) {
        //         $query->where('records.firmware_id', '=', '3');
        //     })
        //     ->get()->toArray();

        // dd($tests);

        //include 'ccxt.php';
        // $binance = new BinanceApi(array(
        //     'apiKey' => '1u4rcJJ3G54H6CTuPld9fa0OrekZYOeyj8jb1T8kpamc5IiM7Rw3Q1IiFhu49nk3',
        //     'secret' => 'jwlixYSD8H1D5Juqp3avPmhNduBUrfNRPyvNMAEd4PY9903Chob9pkrTDlPyXVPE',
        //     'enableRateLimit' => true,
        // ));

        //$markets = $binance->fetch_markets();
        //$binance->set_markets($markets);
        // dd($binance->markets);

        // $time_start = microtime(true);

        // $balances = $binance->fetch_balance();


        // echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);

    }
}
