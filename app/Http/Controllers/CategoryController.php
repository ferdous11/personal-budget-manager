<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Category/Index', [
            'categories' => Category::select(['id', 'name', 'type'])->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return [$request->input('name'), $request->input('type')];
        Category::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->getCategoryById($id);
        return Inertia::render('Category/Edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->getCategoryById($id);
        $category->name = $request->input('name');
        $category->type = $request->input('type');
        $category->save();

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return Inertia::location(route('categories.index'));
    }
    
    private function getCategoryById(int $id): Category | null
    {
        return Category::select(['id', 'name', 'type'])
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();
    }

}
