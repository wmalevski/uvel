<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Partner;
use App\Store;
use App\Permission;
use Response;
use Bouncer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);
        $stores = Store::take(env('SELECT_PRELOADED'))->get();

        return \View::make('admin/users/index', array('users' => $users, 'stores' => $stores));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $stores = Store::all();

        return \View::make('admin/users/edit', array('user' => $user, 'stores' => $stores));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make( $request->all(), [
            'email' => 'required',
            'role' => 'required',
            'store_id' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $user->email = $request->email;
        $user->store_id = $request->store_id;
        $user->role = $request->role;

        $user->save();

        Bouncer::sync($user)->roles([$request->role]);

        return Response::json(array('ID' => $user->id, 'table' => View::make('admin/users/table',array('user'=>$user))->render()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make( $request->all(), [
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
            'store_id' => 'required'
         ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'store_id' => $request->store_id
        ]);

        $user->assign($request->role);

        if($request->role == 'corporate_partner'){
            $partner = new Partner();
            $partner->user_id = $user->id;
            $partner->save();
        }

        return Response::json(array('success' => View::make('admin/users/table',array('user'=>$user))->render()));
    }

    public function select_search(Request $request){
        $search = $request->input('search');

        // There are specific scenarios where header named 'search' is not present in the request so  we have overwrite it
        if (is_null($search)) {
            foreach($request->all() as $k => $v) {
                $search = $request->input($k);
                break;
            }
        }

        $users = User::where(function ($query) use ($search) {
            $query
                ->where('email', 'like', '%' .$search. '%')
                ->orWhere('first_name', 'like', '%' .$search. '%')
                ->orWhere('last_name', 'like', '%' .$search. '%');
        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $users->map(function ($user) {
            $firstName = $user->first_name;
            $lastName = $user->last_name;
            $email = $user->email;

            return [
                'id' => $user->id,
                'text' => sprintf('%s %s %s', $firstName, $lastName, $email),
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $users->hasMorePages()],
        ]);
    }

    public function filter(Request $request){
        $query = User::select('*');

        $users_new = new User();
        $users = $users_new->filterUsers($request, $query);
        $users = $users->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $response = '';
        foreach($users as $user){
            $response .= \View::make('admin/users/table', array('user' => $user, 'listType' => $request->listType));
        }

        $users->setPath('');
        $response .= $users->appends(request()->except('page'))->links();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user){
            foreach($user->discountCodes as $discountCode) {
                if($discountCode->active == "yes") {
                   $discountCode->active = "no";
                   $discountCode->save();
                }
            }

            $user->delete();
            return Response::json(array('success' => 'Успешно изтрито!'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('store');
    }
}
