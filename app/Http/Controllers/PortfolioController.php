<?php

namespace App\Http\Controllers;

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
            ->sort($sort, $direction)->paginate()->withQueryString();

        $portfolios->getCollection()->transform(function ($item) {
            $item->imgUrl = '';
            if (isset($item->imgUrl)) {
                $item->imgUrl = $item->imgUrl;
            }
            return $item;
        });

        return inertia(
            'Admin/Portfolio/Index',
            [
                'defaultDirection' => $direction,
                'items' => $portfolios,
            ]
        );
    }


    public function store(PortfolioStoreRequest $request)
    {

        $data = $request->validated();

        if ($request->img) {
            $data['img'] = $request->img->store('portfolio');
        }

        Portfolio::create($data);

        return back()
            ->with('success', "The 'Portfolio' has created.");
    }


    public function update(Portfolio $portfolio, PortfolioStoreRequest $request)
    {


        $data = $request->validated();
        //dd($data);
        if ($request->img) {
            $data['img'] = $request->img->store('portfolio');
        } else {
            unset($data['img']);
        }

        $portfolio->update($data);


        return back()->with('success', "The 'Portfolio' has updated.");
    }


    public function destroy(Note $note)
    {
        $note->delete();

        return Redirect::route('notes')->with('success', 'Note deleted.');
    }
}
