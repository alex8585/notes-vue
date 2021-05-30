<?php

namespace App\Http\Controllers;


use App\Models\Tag;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;


class TagsController extends Controller
{
    public function index(HttpRequest $request)
    {
        $direction =  $request->direction ?? 'asc';
        $sort = $request->sort ?? 'id';

        $tags = Tag::filter(Request::only('search'))
            ->sort($sort, $direction)
            ->paginate()->withQueryString();

        //dd($tags);

        return inertia(
            'Admin/Tags/Index',
            [
                'filters' => Request::all('search'),
                'defaultDirection' => $direction,
                'items' => $tags,
            ]
        );
    }
}
