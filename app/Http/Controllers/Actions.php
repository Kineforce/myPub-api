<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;

class Actions extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
 
        $results =  Action::where('client_id', 'ilike', "%".$id."%")->orderBy('id')->get();
        $new_results = [];

        foreach($results as $result){
            $result->formated_date = [
                'date' => date('d-m-Y', strtotime($result->created_at)),
                'hour' => date('H:i', strtotime($result->created_at))
            ];
            array_push($new_results, $result);
        };


        return $new_results;

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
            'client_id' => 'required',
            'action'    => 'required',
            'product'   => 'required',
            'price'     => 'required'
        ]);

        return Action::create($request->all());    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Action::find($id);
        $client->update($request->all());
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Action::destroy($id);
    }
}
