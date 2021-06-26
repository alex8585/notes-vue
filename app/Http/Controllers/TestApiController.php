<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Portfolio;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;

class TestApiController extends Controller
{
    public function test(HttpRequest $request)
    {
        //dd($request);
        $direction =  $request->direction ?? 'asc';
        $sort = $request->sort ?? 'id';
        $perPage = $request->perPage ?? 10;
        //$page = $request->page ?? 1;


        $notes = Note::with('category')
            ->filter(Request::only('search', 'category_id', 'trashed'))
            ->sort($sort, $direction)
            ->paginate($perPage)->withQueryString();


        $notes->getCollection()->transform(function ($notes) {
            $notes->cat_name = '';
            if (isset($notes->category->name)) {
                $notes->cat_name = $notes->category->name;
            }

            return $notes;
        });
        return $notes;
    }
}
