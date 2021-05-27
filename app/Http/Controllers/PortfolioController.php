<?php

namespace App\Http\Controllers;

use League\Glide\Server;
use App\Models\Portfolio;
use App\Models\Tag;
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
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HttpRequest $request, Server $glide)
    {
        $direction =  $request->direction ?? 'asc';
        $sort = $request->sort ?? 'id';

        $portfolios = Portfolio::filter(Request::only('search', 'category_id', 'trashed'))
            ->sort($sort, $direction)->with('tags')->paginate(20)->withQueryString();

        $portfolios->getCollection()->transform(function ($item) {
            $item->imgUrl = $item->imgUrl;

            $item->tags->transform(function ($tag) {
                return $tag->id;
            })->toArray();

            return $item;
        });

        //dd($portfolios);

        $tags = Tag::all()->transform(function ($item) {
            $item->text = $item->name;
            $item->value = $item->id;
            return $item;
        });

        return inertia(
            'Admin/Portfolio/Index',
            [
                'tags' => $tags,
                'defaultDirection' => $direction,
                'items' => $portfolios,
            ]
        );
    }


    public function store(PortfolioStoreRequest $request)
    {

        $data = $request->validated();

        $tags = $data['tags'];
        unset($data['tags']);
        //dd($tags);

        if ($request->img) {
            $data['img'] = $request->img->store('portfolio');
        }

        $portfolio = Portfolio::create($data);

        $portfolio->tags()->sync($tags);
        return back()
            ->with('success', "The 'Portfolio' has created.");
    }


    public function update(Portfolio $portfolio, PortfolioStoreRequest $request)
    {


        $data = $request->validated();

        $tags = $data['tags'];
        unset($data['tags']);

        //dd($tags);
        if ($request->img) {
            $data['img'] = $request->img->store('portfolio');
        } else {
            unset($data['img']);
        }

        $portfolio->update($data);
        $portfolio->tags()->sync($tags);

        return back()->with('success', "The 'Portfolio' has updated.");
    }


    public function destroy(Portfolio $portfolio)
    {
        $portfolio->tags()->sync([]);
        $portfolio->delete();

        return Redirect::route('portfolios')->with('success', 'Portfolio deleted.');
    }
}
