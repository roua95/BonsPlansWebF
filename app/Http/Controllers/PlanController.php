<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Category;
use App\Category_plan;
use App\User;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    static $totalRates;
    static $rateUsers = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return Plan::All()->toArray();

    }
public function showAll(Request $request){
        $plans = Plan::All();
        $categories = Category::all();
    return view('plans.index',[ 'plans' => $plans , 'categories' => $categories]);

}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $plan = Plan::create([

            'id' => $request->get('id'),
            'user_id' => $request->get('user_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'adresse' => $request->get('adresse'),
            'rate' => $request->get('rate'),
            'longitude' => $request->get('longitude'),
            'lattitude' => $request->get('lattitude'),
            'ApprovedBy' => $request->get('ApprovedBy'),


        ]);


        $plan
            ->category();
            //->attach(category::where('category_name', 'café')->first());

        //  return response()->json(compact([$category
        /* store(Request::$request);
             $category= new Category;
             $category->category_name=$request->get('category_name');
             $category->id=$request->get('id');*/

        $plan->save();

        //return response()->json(compact('plan'));
        return view('plans.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'adresse' => 'required|string|max:255|unique',
            'region' => 'string',
            'longitude' => 'numeric|nullable',
            'lattitude' => 'numeric|nullable',
            'user_id' => 'numeric|required',
            'rate' => 'integer|nullable',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $plan = new Plan();

            $plan->title = $request['title'];
            $plan->description = $request['description'];
            $plan->user_id = $request['user_id'];
            $plan->longitude = $request['longitude'];
            $plan->lattitude = $request['latitude'];
            $plan->region = $request['region'];
            $plan->adresse = $request['adresse'];
            $plan->rate = $request['rate'];
            $plan->save();
            return redirect('/api/plans/index')->with('success', 'Plan has been created');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $plan = Plan::find($request->get('id'));
        return response()->json(compact('plan'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {

        $plan = Plan::find($id);

        return view('plans.edit',[ 'plan' => $plan]);

    }

//////tawel belik
    public function update(Request $request,$id)
    {
        //Session::flash('flash_message', 'Task successfully added!');

        $plan1 = Plan::find($id);
        echo $id;
        if ($request['title'] != "") {

            $plan1->title = $request['title'];
        }
        if ($request['description'] != "") {

            $plan1->description = $request['description'];
        }

        if ($request['user_id']!= "") {
            $plan1->user_id = $request['user_id'];
        }
        if ($request['longitude']!= "") {
            $plan1->longitude = $request['longitude'];}
            if ( $request['lattitude'] != "") {

                $plan1->lattitude = $request['lattitude'];
            }
            if ($request['region'] != "") {

                $plan1->region = $request['region'];
            }

            if ($request['adresse']!= "") {

                $plan1->adresse = $request['adresse'];
            }
            if ($request['rate']!= "") {

                $plan1->rate =  $request['rate'];
            }


            $plan1->save();


            return redirect('/api/plans/index')->with('success', 'Plan has been updated');
        }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateMobile(Request $request, Plan $plan)
    {
        $plan = Plan::find($request->get('id'));
        $plan->description = $request->get('description');

        $plan->title = $request->get('title');

        if ($request->get('user_id') != "") {
            $plan->user_id = $request->get('user_id');
        }
        if ($request->get('longitude') != "") {
            $plan->longitude = $request->get('longitude');
            if ($request->get('lattitude') != "") {
                $plan->lattitude = $request->get('lattitude');
            }
            if ($request->get('region') != "") {
                $plan->region = $request->get('region');
            }

            if ($request->get('adresse') != "") {
                $plan->adresse = $request->get('adresse');
            }
            if ($request->get('rate') != "") {
                $plan->rate = $request->get('rate');
            }


            $plan->save();

        }
        return response()->json(compact('plan'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $plan = Plan::find($id);
        $plan->delete();
        return redirect('/api/plans/index')->with('success', 'Plan has been deleted Successfully');


    }

    public function approve($id)
    {
        $plan = Plan::find($id);
            if ($plan->approvedBy == 0) {
                //it should be user_id
                $plan->approvedBy = 1;
                $plan->save();
                return redirect('/api/plans/index')->with('success','Plan successfully approved');

            } else return redirect('/api/plans/index')->with('success','Plan already approved');}



    public function showAllApprovedPlans(Request $request)
    {
        $plan = Plan::all();
       // $approvedPlan = Plan::where(($plan->approvedBy) != 0);//where(($plan->approvedBy) != 0);
        $approvedPlan = DB::table('plans')->get()->where('approvedBy','==',1);

        return $approvedPlan;

    }

    public function showAllNotApprovedPlans(Request $request)
    {
        $plan = DB::table(Plan::all());

        $plan = Plan::find(where($plan->approvedBy == ""));
        return $plan->toArray();

    }

    public function showAllApprovedPlansByUserId(Request $request, Plan $plan)
    {
        $plans = Plan::find(where($request->get('userId') == $plan->approvedBy));
        return $plans->toArray();

    }



    public function getFavoritePlans(Request $request)
    {
        $ratedPlansByUser = DB::table('ratings')->get()->where('user_id', $request->get('user_id'));
        return $ratedPlansByUser->where($ratedPlansByUser->rating >= $request->min);

    }

    public function getRecommandedPlans(Request $request)
    {
        $ratedPlansByUser = DB::table('ratings')->get();

        $mostRatedPlansByUser = DB::table('ratings')->get()->where(($ratedPlansByUser->rating >= $request->min));
        return $mostRatedPlansByUser->toArray();

    }


    public function ratePlan(Request $request)

    {

        request()->validate(['rate' => 'required']);

        $plan = Plan::find($request->id);

        $rating = new \willvincent\Rateable\Rating;

        $rating->rating = $request->rate;

        // $rating->user_id = auth()->user()->id;

        $rating->user_id = $request->get('user_id');
        $requete = DB::table('ratings')->select('id')->where('user_id', $request->get('user_id'))->where('rateable_id', $request->get('id'))->first();
        if ($requete == null) {
            $plan->ratings()->save($rating);
            //$plan->rate = ((integer)$plan->rate + $rating->rating)/((integer)self::$totalRates);
            $totalRates = DB::table('ratings')->count();
            $sum = DB::table('ratings')->sum('rating');


            // $plan->rate = ((integer)$plan->rate + $rating->rating)/((integer)$totalRates);
            $plan->rate = $sum / $totalRates;
            //return $requete;
            $plan->save();
        } else return ("you already rated this plan !");

    }

////////////////////////////if user changes his mind about a plan !!
    public function changeRating(Request $request)
    {
        request()->validate(['rate' => 'required']);

        $plan = Plan::find($request->id);

        $rating = new \willvincent\Rateable\Rating;

        $rating->rating = $request->rate;

        // $rating->user_id = auth()->user()->id;

        $rating->user_id = $request->get('user_id');
        //$requete = DB::table('ratings')->select('id')->where('user_id', $request->get('user_id'))->where('rateable_id', $request->get('id'))->first();
        $sum = DB::table('ratings')->sum('rating');
        $totalRates = DB::table('ratings')->count();
        echo "avant" . $sum;
        $sum = $sum - $plan->rate;
        echo "après" . $sum;

        $sum = $sum + $request->rate;
        echo "après update" . $sum;
        $plan->rate = $sum / $totalRates;
        $plan->save();
        // $requete = DB::table('ratings')->get()->where('user_id', $request->get('user_id'))->where('rateable_id', $request->get('id'));
        $requete = DB::table('ratings')->get()->where('id', 'id')->where('user_id', 'user_id')->first();
        echo $requete;

        if ($requete != null)
            //$requete->update("rating",$request->rate);
            $requete->rating = $request->rate;
        echo $requete;
    }

    public function addTofavorites(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));
        $plan->addFavorite($request->get('user_id'));
        return $plan;
    }

    public function removeFromFavorites(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));

        $plan->removeFavorite($request->get('user_id'));
    }

    public function favoriteCount(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));
        return $plan->favoritesCount;
    }

    public function whoFavoritePlan(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));
        return $plan->favoritedBy();
    }

    public function isFavorited(Request $request)
    {
        $plan = Plan::find($request->get('plan_id'));

        return $plan->isFavorited($request->get('user_id'));
    }


    ///Liking methods
    public function mostLikedPlans()
    {
        $likeCount=array();
        //$plans=DB::table("plans")->where('id' ,'>' ,0)->pluck('id')->toArray();
        $plans=Plan::where('id' ,'>' ,0)->pluck('id');

        foreach ($plans as $index){
            $likeCount[]= array( $index => $this->likesNumber1($index));

          //   print_r($likeCount);
            // $array = collect($likeCount)->sortBy($this->likesNumber1($index),1)->toArray();
            // $likeCount[]=Plan::all()->sortByDesc($this->likesNumber1($index));
            $array = json_decode(json_encode($likeCount),true);
            $laravelArray = collect($array);
            asort($likeCount);
            //$laravelArray->sortByDesc($this->likesNumber1($index));
        }


        return $likeCount;

    }

    public function likesNumber1($plan_id){
        return Like::where("plan_id",$plan_id)->count();

    }

    public function whoLikedThisPost(Request $request){
        $likes= Like::where("plan_id",$request->plan_id)->get();
        $usersTab=array();

        foreach ($likes as $like){
            $usersTab[]=$like->user_id;

        }
        $likers=array();
        foreach ($usersTab as $user_id){
            $likers[]=User::find($user_id);

        }
        return $likers;
    }

    public function likesNumber(Request $request){
        return Like::where("plan_id",$request->plan_id)->count();
    }

    public function isLikedByMe(Request $request)
    {
        $plan = Plan::find($request->plan_id)->first();
        if (Like::where("user_id",$request->user_id)->where("plan_id",$request->plan_id)->exists()){
            return 'true';
        }
        return 'false';
    }

    public function like(Request $request)
    {
        $existing_like = Like::all()->where('plan_id',$request->plan_id)->where('user_id',$request->user_id)->first();

        if (is_null($existing_like)) {
            Like::create([
                'plan_id' => $request->plan_id,
                'user_id' => $request->user_id,

            ]);
        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }

    public function shareOnFacebook(Request $request)
    {
        return Share::page('http://jorenvanhocht.be')->facebook();
    }

    public function shareOnTwitter(Request $request)
    {
        return Share::page('http://jorenvanhocht.be', 'Your share text can be placed here')->twitter();
    }
    public function shareOnGooglePlus(Request $request){
        return Share::page('http://jorenvanhocht.be')->googlePlus();
    }
    public function shareCurrentPage(Request $request){
        return Share::currentPage()->facebook();
    }
    public function shareMultiple(Request $request){
        return  Share::page('http://jorenvanhocht.be', 'Share title')
            ->facebook()
            ->twitter()
            ->googlePlus()
            ->linkedin('Extra linkedin summary can be passed here')
            ->whatsapp();
    }



    public function searchPlanByRegion(Request $request){
        $plan = Plan::all()->where('region',$request->region);
        return $plan->toArray();
    }

    public function searchByMostRatedInCategory(Request $request){
        $plans =$this->searchPlanByCategorie();
    }

    public function searchPlanByCategorie(Request $request)
    {
        //  $plan = Plan::all()->where(DB::table('categories'))

        //search category id from category name given (((((think about REGULAR expressions in front or in mobile part to consider all fors of category name,)
        $result = DB::table('categories')
            ->select('id')
            ->where("category_name", '=', $request->categorie)->get()->first();
        //  return $result->id;


        //search all plans wanted ids
        $plans = DB::table('category_plan')
            ->select(DB::raw("plan_id"))
            ->where('category_id', '=', $result->id)
            ->get();

        // return $plans->toArray();

        //find plans from their ids
        $plaan=array();
        if ($request->region == null){
            foreach ($plans as $plan) {
                //   $plan = Plan::All()->where('id','=',$plans->plan_id)->get();
                // $res = DB::table('plans')->select('*')->where('id', 'in', $plans-¦plan_id);
                $plaan [] = DB::table("plans")
                    ->select('*')->where('id', '=', $plan->plan_id)->get();

            }
        }
        else  if ($request->region =! null) {
            {
                foreach ($plans as $plan) {
                    //   $plaan [] = DB::table("plans")
                    //  ->select('*')->where('id', '=', $plan->plan_id)->where('region', '=', $request->region)->get();
                    $plaan = Plan::all()->where('region',$request->region)->where('id', '=', $plan->plan_id);

                }
            }

        }
        return $plaan;

    }


////// à revoir quoi !!!! how to pass params from global function to internal function this function does not work!!!

    public function searchByClosestInCategory(Request $request){
        $plans =$this->searchPlanByCategorie($this->$request->categorie);
        $plansInRegion=$plans->where('region','=',$request->region);
        return $plansInRegion;
    }

    public function searchPlanByName(Request $request){
        $plan = Plan::where('title', $request->get('plan_name'))->get();
        return $plan;
    }

    public  function addPlanToCategory(){

    }
///parametres passés rayon+ GPS localisation : longitude et lattitude de l'utilisateur
    public function filterProximity(Request $request)
    {
        $lon = $request->longitude;
        $lat = $request->lattitude;
        $radius = $request->rayon;
         $closestPlans = Plan::select(

            DB::raw("*,
                              ( 6371 * acos( cos( radians($lat) ) *
                                cos( radians(lattitude ) )
                                * cos( radians(longitude ) - radians($lon)
                                ) + sin( radians($lat) ) *
                                sin( radians( lattitude) ) )
                              ) AS distance"))
            ->having("distance", "<", $radius)
            ->orderBy("distance")
            ->pluck('id');
        //  return $closestPlans;


      $plans = array();
        $category_id=Category::where('category_name',$request->get('categorie'))->pluck('id');

        $plans=Category_plan::where('category_id',$category_id)->whereIn('plan_id',$closestPlans)->pluck('plan_id');
        //return $plans;
        $wantedPlans=array();

        foreach ($plans as $p){
            $wantedPlans[]=Plan::find($p);
        }
        return $wantedPlans;
    }
    public function assignToCategory($id){
        $getSelectedValue =Input::get('category');
        $category_id = Category::where('category_name', $getSelectedValue)->first()->id;
        $cat=new Category_plan();
        $cat->category_id = $category_id;
        $cat->plan_id = $id;
        $cat->save();
        return redirect('api/plans/index')->with('success','plan has been assigned successfully');
    }
    public function getSelectedCategory(){
        $getSelectedValue =Input::get('category');
    }
}




