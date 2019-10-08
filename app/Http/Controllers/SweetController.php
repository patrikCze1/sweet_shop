<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sweet;

class SweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.novy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'count' => 'required',
            'price' => 'required',
        ]);

        $sweet = new Sweet;
        $sweet->name = $request->name;
        $sweet->count = $request->count;
        $sweet->price = $request->price;
        $sweet->save();

        return redirect('/administrace')->with('success', 'Cukrovinka přidána');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sweet = Sweet::find($id);

        return view('admin.upravit')->with('sweet', $sweet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sweet = Sweet::find($request->id);
        $sweet->name = $request->name;
        $sweet->count = $request->count;
        $sweet->price = $request->price;
        $sweet->save();

        return redirect('/administrace')->with('success', 'Cukrovinka upravena');
    }

    /**
     * Deactivate the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        DB::table('sweets')
            ->where('id', $request->id)
            ->update(['active' => 0]);

        return redirect('/administrace')->with('success', 'Cukrovinka odebrána');
    }
}
