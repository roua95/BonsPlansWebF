<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use App\Role;
use App\Role_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|unique:users',
            'password' => 'string|nullable',
            'provider' => 'in:facebook,google|required_without:password|nullable',
            'facebook_id' => 'string|nullable|required_without:google_id|required_if:provider,==,"facebook',
            'google_id' => 'string|nullable|required_without_all:password,facebook_id|required_if:provider,==,"google',]);

        $credentials_login_facebook = $request->only('facebook_id', 'password');

        $credentials_login_mail = $request->only('email', 'password');
        $credentials_login_google = $request->only('google_id', 'password');

        if ($token = JWTAuth::attempt($credentials_login_mail)) {

            return response()->json(['message' => 'you are successfully logged in via mail'], 200);

        } elseif (($token = JWTAuth::attempt($credentials_login_facebook) &&
            $user = \DB::table('users')->where("facebook_id", $request->facebook_id)->first())) {
            return response()->json(['message' => 'you are successfully logged in via facebook'], 200);
        } elseif (($token = JWTAuth::attempt($credentials_login_google) &&
            $user = \DB::table('users')->where("google_id", $request->google_id)->first())) {
            return response()->json(['message' => 'you are successfully logged in via google'], 200);
        } else    return response()->json(['error' => 'check your credentials'], 400);

    }

    //return response()->json(compact('user', 'token'));


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'string|required_without:provider',
            'confirmpassword' => 'string|same:password|required_without:provider|nullable',
            'provider' => 'in:facebook,google|required_without:password|nullable',
            'facebook_id' => 'string|nullable|required_without_all:password,google_id|required_if:provider,==,"facebook',
            'google_id' => 'string|nullable|required_without_all:password,facebook_id|required_if:provider,==,"google',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            if (!$request->provider) {
                $user = User::create([
                    'firstname' => $request->get('firstname'),
                    'lastname' => $request->get('lastname'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password'))]);


            } else if ($request->provider = 'google') {

                $user = User::create([
                    'firstname' => $request->get('firstname'),
                    'lastname' => $request->get('lastname'),
                    'email' => $request->get('email'),
                    'google_id' => $request->get('google_id'),
                    'facebook_id' => $request->get('facebook_id')]);

            } else {
                if ($request->provider = 'facebook') {
                    $user = User::create([
                        'firstname' => $request->get('firstname'),
                        'lastname' => $request->get('lastname'),
                        'email' => $request->get('email'),
                        'google_id' => $request->get('google_id'),
                        'facebook_id' => $request->get('facebook_id')]);

                }
            }

            $token = JWTAuth::fromUser($user);


            //adding default roles
            $user
                ->roles()
                ->attach(Role::where('name', $request->get('role'))->first());
            /* $roles = Role::all();
             $user->roles()->attach(
                 $roles->toArray());
                 return $roles;*/

            return response()->json(compact('user', 'token'), 201);
        }
    }

    public function getAuthenticatedUser()
    {
        try { $admins = Role_user::where('role_id',2)->get()->pluck('user_id');
        foreach ($admins as $admin){
        $adminas[]=User::find($admin);
        }
        return $adminas;

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function getAllUsers()
    {
        return User::all()->toArray();
    }

    public function getFavoritePlans(Request $request)
    {
        $user = User::find($request->get('user_id'));
       return $user->favorite(Plan::class);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('api/users/index')->with('success', 'user has been deleted Successfully');
    }
    public function index()
    {

        $user_ids = Role_user::where('role_id',2)->get()->pluck('user_id');
        foreach ($user_ids as $user){
            $users[]=User::find($user);
        }
        return view('users.index')->with('users',$users);
    }
    public function find(Request $request){
        $user = User::find($request->get('user_id'));

    }
    public function findUserRole(Request $request){
        $user = User::find($request->get('user_id'));

    }
    public function login()//($name,$password)
    {

        /*
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|unique:users',
            'password' => 'string|required',]);

        $credentials_login_mail = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials_login_mail)) {

            $user = User::where('email', $request->get('email'));
            if ($user->password == $request->get('password')) {
                $role_id = Role_user::where('user_id', $user->id)->get()->pluck('role_id');
                if ($role_id == 2) redirect('/welcome');
                else if ($role_id == 3) redirect('/welcomeSuperAdmin');
            }
        }
        */
        return view('login');

    }
    public function showAllAdmins(){
        $admins = Role_user::where('role_id',2)->get()->pluck('user_id');
        foreach ($admins as $admin){
        $adminas[]=User::find($admin);
        }
        return view('superAdmin.index',[ 'admins' => $adminas]);

    }
    public function createAdmin(Request $request){
        return view('superAdmin.create');

    }
    public function store(Request $request)
    {

        $user=new User();
        $user->firstname =$request['firstname'];
        $user->lastname =$request['lastname'];
        $user->email =serialize($request['email']);
        $user->password =Hash::make($request->get('password'));
        $user->save();
        return redirect('api/users/index')->with('success', 'Admin has been added');

    }

}

