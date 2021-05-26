<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use League\Glide\Server;
use App\Models\Portfolio;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NoteStoreRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;
use App\Http\Requests\PortfolioStoreRequest;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PortfolioController extends Controller
{

    public function index(HttpRequest $request)
    {
        $items = Portfolio::paginate(20);


        // $items->transform(function ($item) {
        //     $item->bigImgUrl = $item->bigImgUrl;
        //     return $item;
        // });

        $items->getCollection()->transform(function ($item) {
            $item->bigImgUrl = $item->bigImgUrl;
            $item->tags = $item->tags;
            // $item->tags->transform(function ($tag) {
            //     $newTag =
            //     return $tag->id;
            // })->toArray();

            return $item;
        });


        //dd( $items);
        return Inertia::render('Frontend/Index.vue', ['items' => $items]);
    }
}
