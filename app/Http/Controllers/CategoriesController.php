<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\CategoryCollection;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request as HttpRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HttpRequest $request)
    {
        $direction =  $request->direction ?? 'asc';
        $sort = $request->sort ?? 'id';
        // \App\Models\Category::factory()->count(100)->create();
        // \App\Models\Note::factory()->count(100)->create();
        //die;

        // $categories = Auth::user()->categories()->sort($sort, $direction)
        //     ->get()->map(function ($e) {
        //         $e->subrow = json_decode($e->subrow);
        //         return $e;
        //     })

        //     ->toArray();
        // dd($categories);

        $categories = Auth::user()->categories()->sort($sort, $direction)->paginate()->appends(Request::all());
        return Inertia::render(
            'Categories/Index',

            ['categories' => $categories, 'defaultDirection' => $direction]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {

        Auth::user()->categories()->create(
            $request->validated()
        );

        return Redirect::route('categories')->with('success', 'Category created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => new JsonResource($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, CategoryUpdateRequest $request)
    {
        $category->update(
            $request->validated()
        );

        return Redirect::route('categories')->with('success', 'Category created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return Redirect::route('categories')->with('success', 'Category deleted.');
    }
}
