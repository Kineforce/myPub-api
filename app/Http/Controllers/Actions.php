<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

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

     /**
     * Return report of a especific date and/or client
     *
     * @param  string   $client_id
     * @param  string   $year
     * @param  string   $month
     * @return \Illuminate\Http\Response
     */
    public function getReport($year, $month, $client_name)
    {

        $results = [];
        $years = [];

        if ( $year == "empty" && $client_name == "empty"){

            $results =  DB::select("    SELECT     *
            FROM       ACTIONS
            ORDER BY   EXTRACT(YEAR FROM CREATED_AT) ");

            $years = DB::select( "  SELECT DISTINCT( EXTRACT(YEAR FROM CREATED_AT))
            FROM ACTIONS 
            ORDER BY EXTRACT(YEAR FROM CREATED_AT) ");

        }

        if ( $year == "empty" && $client_name != "empty"){

            $client_id = Client::where('name', 'ilike', "%".$client_name."%")->get();

            if (count($client_id) > 0){
                $results =  DB::select("    SELECT      *
                                            FROM        ACTIONS
                                            WHERE       CLIENT_ID = '".$client_id[0]->id."'
                                            ORDER BY    EXTRACT(YEAR FROM CREATED_AT) ");

                $years = DB::select( "  SELECT DISTINCT( EXTRACT(YEAR FROM CREATED_AT))
                                        FROM    ACTIONS 
                                        WHERE   CLIENT_ID = '".$client_id[0]->id."'
                                        ORDER BY EXTRACT(YEAR FROM CREATED_AT) ");
            }
           
            
        }

        if ( $year != "empty" && $client_name == "empty"){

            $results =  DB::select("    SELECT     *
                                        FROM       ACTIONS
                                        WHERE      EXTRACT(YEAR FROM CREATED_AT) = '".$year."'
                                        ORDER BY   EXTRACT(YEAR FROM CREATED_AT) ");

            $years = DB::select( "  SELECT DISTINCT( EXTRACT(YEAR FROM CREATED_AT))
                                    FROM        ACTIONS 
                                    WHERE       EXTRACT(YEAR FROM CREATED_AT) = '".$year."'
                                    ORDER BY    EXTRACT(YEAR FROM CREATED_AT) ");
            
        }

        if ( $year != "empty" && $client_name != "empty"){

            $client_id = Client::where('name', 'ilike', "%".$client_name."%")->get();

            if (count($client_id) > 0){
                $results =  DB::select("    SELECT      *
                                            FROM        ACTIONS
                                            WHERE       CLIENT_ID = '".$client_id[0]->id."'
                                            AND         EXTRACT(YEAR FROM CREATED_AT) = '".$year."'
                                            ORDER BY    EXTRACT(YEAR FROM CREATED_AT) ");

                $years = DB::select( "  SELECT DISTINCT( EXTRACT(YEAR FROM CREATED_AT))
                                        FROM    ACTIONS 
                                        WHERE   CLIENT_ID = '".$client_id[0]->id."'
                                        AND     EXTRACT(YEAR FROM CREATED_AT) = '".$year."'
                                        ORDER BY EXTRACT(YEAR FROM CREATED_AT) ");
            }
           
        }
     
        return [$results, $years];

    }



}
