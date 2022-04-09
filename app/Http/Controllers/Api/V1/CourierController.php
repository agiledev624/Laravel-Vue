<?php

namespace App\Http\Controllers\Api\V1;

use App\Courier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO foreign key related rows
        // return Apart::with('user')->getall();
        return Courier::all();
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
        $request['password'] = bcrypt($request['password']);
        $company = Courier::create($request->all());
        return $company;
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
        return Courier::findOrFail($id);
    }

    public function list($id)
    {
        return Courier::select('*')->where('user_id', $id)->get();
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
        //
        $company = Courier::findOrFail($id);
        $request['password'] = bcrypt($request['password']);
        $company->update($request->all());
        $response = [
            'result' => '0',
            'message' => 'ok',
        ];
        return response()->json($response, 200);
        // return $company;
    }

    public function reset_password(Request $request)
    {
        //
        $input = $request->all();
        $company = Courier::findOrFail($input['id']);
        $company->password = bcrypt('123456');
        $company->save();
        $response = [
            'result' => '0',
            'message' => 'ok',
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $company = Courier::findOrFail($id);
        $company->delete();
        return '';
    }
}
