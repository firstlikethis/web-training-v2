<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('courses')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $category = Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'หมวดหมู่ถูกสร้างเรียบร้อยแล้ว');
    }
    
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $category->name = $validated['name'];
        $category->description = $validated['description'];
        $category->save();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'หมวดหมู่ถูกอัปเดตเรียบร้อยแล้ว');
    }
    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'หมวดหมู่ถูกลบเรียบร้อยแล้ว');
    }
}