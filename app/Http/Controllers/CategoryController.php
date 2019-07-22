<?php

namespace App\Http\Controllers;

use App\Category;
use App\Category_plan;
use App\Plan;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /* public function index()
    {

return Category::All();
    }*/
    public function index()
    {
        //
        $categories = Category::all();
           // return view('categories.index')->with('categories',$categories);
        return view('categories.index',[ 'categories' => $categories]);
         }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request)
    {

      /*   $category =Category::create([
             'id' => $request->get('id'),
             'category_name' => $request->get('category_name'),
        ]);

        $category->save();
*/
        return view('categories.create');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required', 'int'],
            'category_name' => ['required', 'string', 'max:255'],

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        /*$category= new Category;
        $category->category_name=$request->get('category_name');
        $category->id=$request->get('id');
        */
        $category = new Category([
            'category_name' => $request->get('category_name'),
            'id'=> $request->get('id'),
        ]);
        $category->save();
      // return view('categories.store');
        return redirect('api/category/index')->with('success', 'Category has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $category= Category::find($request->get('id'));
        return response()->json(compact('category'));


    }

   public function update($id,Request $request)
   {
      /* $request->validate([
            'id'=>'required',
            'category_name'=>'required',
        ]);

*/

       $category = Category::find($id);

     //  $category = Category::update($category->category_name,$request->get('category_name'));

       $category->category_name = $request->get('category_name');
       //$category->id = $request->get('id');

       $category->save();

       return redirect('/api/category/index')->with('success', 'Category has been updated');


   }
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect('/api/category/index')->with('success', 'Category has been deleted Successfully');
    }
public function edit($id){
    $category = Category::find($id);

    return view('categories.edit',[ 'category' => $category]);

}


    public function getPlansByCategoryName(Request $request){
        $plans=array();
        $category_id=Category::where('category_name',$request->get('category_name'))->pluck('id');
        $plans[]=Category_plan::where('category_id',$category_id)->select('plan_id')->get();
        foreach ($plans as $plan){
            return Plan::find($plan);
        }
    }
}
