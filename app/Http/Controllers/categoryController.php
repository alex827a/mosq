<?php

namespace App\Http\Controllers;
use App\Category;

use Illuminate\Http\Request;
use Validator, Redirect; 

class categoryController extends Controller{
    
    // list all category
    public function index(){
        $categories = Category::all();
        return view('admin/category/index' , array('categories'=>$categories));
    }
    
    /* start add category function  */
    public function add(){
        return view('admin/category/add');
    }
    public function postadd(Request $request){
        $data = $request->all();
        
        $check = Validator::make($data, Category::$rules);
        // if the validator fails, redirect back to the form
        if ($check->fails()) {
            return Redirect::back()
                ->withErrors($check) // send back all errors to the login form
                ->withInput();
        } else {
            $category = new Category();
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->status = $request->input('status');
            $categories = $category->save();
            return redirect('admin/categories');
        }
    }
    /* end add category function  */
    
    /* edit category function  */
    public function edit($id){
        $category = Category::find($id);
        return view('admin/category/edit' , array('category'=>$category));
    }
    public function postedit(Request $request , $id){
        $data = $request->all();
        $check = Validator::make($data, array(
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories,slug,'.$id.'|max:255',
        ));
        // if the validator fails, redirect back to the form
        if ($check->fails()) {
            return Redirect::back()
                ->withErrors($check) // send back all errors to the login form
                ->withInput();
        } else {
            $category = Category::find($id);
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->status = $request->input('status');
            $categories = $category->save();
            return redirect('admin/categories');
        }
    }
    /* end edit category function  */
    
    /* delete category function*/
    public function delete($id){
        $category = Category::find($id);
        $category->delete();
        return redirect('admin/categories');
    }
    /* end delete category function*/
}
