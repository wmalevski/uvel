<?php

namespace App\Http\Controllers;
use Newsletter;
use App\ModelStone;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Newsletter::getMembers('subscribers');
        return view('admin.mailchimp.index', compact('subscribers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $Newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $Newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $Newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Newsletter  $model_stones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $Newsletter)
    {
        //
    }
}
