<?php

namespace App\Http\Controllers;

use \App\Setting;
use App\UserGroup;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;

class UserGroupController extends Controller
{
    private $userGroup;
    public function __construct(
        UserGroup $userGroup = null
    ) {
        $this->userGroup = $userGroup;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = $this->userGroup->paginate(Setting::where('key','per_page')->first()->value ?? 30);
        return view('admin.users.usergroups')
            ->with([
                'groups' => $groups,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string',
            'domain' => [
                'required',
                'string',
                'regex:/^@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
        ], [
            'name.required'   => __('Пропуснахте да въведете име.'),
            'domain.required' => __('Пропуснахте да въведете домейн.'),
            'domain.regex'    => __('Домейнът трябва да е във формат @example.com.'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingGroup = $this->userGroup->where('domain', '=', $request->domain)->first();
        if ( !is_null($existingGroup) ) {
            return redirect()->back()->withErrors([
                'message' => 'Вече има съществуваща група: ' . $request->domain
            ])->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attributes = [
            'name' => $request->name,
            'domain' => $request->domain
        ];

        $this->userGroup->store($attributes);

        return redirect()->back()->with('success', 'Group uploaded successfully!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = $this->userGroup->find($id);

        if (!$group) {
            return response()->json(['success' => 'Group not found', 'message' => 'Group not found.'], 404);
        }

        $group->delete();
        return response()->json(['success' => 'Изтрито успешно!', 'message' => 'Group deleted successfully.'], 200);
    }

    public function select_search(Request $request){
        $search = $request->search;

        $userGroups = UserGroup::where(function ($query) use ($search) {
            $query
                ->where('domain', 'like', '%' .$search. '%')
                ->orWhere('name', 'like', '%' .$search. '%');

        })->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        $results = $userGroups->map(function ($group) {
            return [
                'id' => $group->id,
                'text' => sprintf('%s (%s)', $group->name, $group->domain),
                'attributes' => [
                    'data-search-users-url' => '/ajax/users/groups/show/users/' . $group->id,
                ],
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $userGroups->hasMorePages()],
        ]);
    }
}
