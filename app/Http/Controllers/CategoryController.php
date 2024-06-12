<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Category/Index', [
            'page_title' => 'Categories',
            'categories' => Auth::user()->categories,

        ]);
    }


    public function create(): \Inertia\Response
    {
        return Inertia::render('Category/Create', [
            'page_title' => 'Add Category',
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);
        $request->user()->categories()->create([
            'name' => $request->name,
            'type' => $request->type,
        ]);
        return redirect()->route('categories.index')->with('message', [
                'body' => 'Category created successfully.',
                'type' => 'success'
            ]
        );

    }


    public function show(string $id): \Inertia\Response
    {
        return Inertia::render('Category/Show', [
            'page_title' => 'Category Details',
            'category' => Category::where(['id' => $id, 'user_id' => auth()->user()->id])->first()
        ]);
    }


    public function edit(string $id): \Inertia\Response
    {
        return Inertia::render('Category/Edit', [
            'page_title' => 'Edit Category',
            'category' => Category::where(['id' => $id, 'user_id' => auth()->user()->id])->first()
        ]);
    }


    public function update(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);
        $category = Category::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $category->name = $request->input('name');
        $category->type = $request->input('type');
        $category->save();
        return redirect()->route('categories.index');
    }

    public function destroy(string $id): \Symfony\Component\HttpFoundation\Response
    {
        $category = Category::find($id);
        $category->delete();
        return Inertia::location(route('categories.index'));
    }
}
