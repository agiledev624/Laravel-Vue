<?php

namespace App\Http\Controllers\api\v1;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Setting::all();
    }

    public function set_sms(Request $request) 
    {
        $request->validate([
            'port' => 'required',
            'msg' => 'required',
        ]);
        $input = $request->all();
        $flight = Setting::updateOrCreate(
            ['key' => 'sms_port'],
            ['value' => $input['port']]
        );
        $flight = Setting::updateOrCreate(
            ['key' => 'sms_msg'],
            ['value' => $input['msg']]
        );
        $response = [
            'result' => '0',
            'msg' => 'ok',
        ];
        return response()->json($response, 200);
    }

    public function get_sms()
    {
        $response = [
            'port' => '',
            'msg' => '',
        ];
        $locker = Setting::select('*')->where('key', 'sms_port')->get();
        if (!$locker->isEmpty()){
            $firstLocker = $locker->first();
            $response['port'] = $firstLocker->value;
        }
        $locker = Setting::select('*')->where('key', 'sms_msg')->get();
        if (!$locker->isEmpty()){
            $firstLocker = $locker->first();
            $response['msg'] = $firstLocker->value;
        }
        return response()->json($response, 200);
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
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }


}
