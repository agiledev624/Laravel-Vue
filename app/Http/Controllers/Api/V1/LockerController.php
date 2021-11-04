<?php

namespace App\Http\Controllers\api\v1;

use App\Locker;
use App\Setting;
use App\Apart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LockerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Locker::all();
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
    public function add(Request $request)
    {
        //
        $request->validate([
            'port' => 'required',
            'size' => 'required',
            'code' => 'required',
            'owner' => 'required',
        ]);
        Locker::create($request->all());
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function show(Locker $locker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function edit(Locker $locker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Locker $locker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locker $locker)
    {
        //
    }

    public function new_assign(Request $request)
    {
        $input = $request->all();
        $locker = Locker::select('*')->where('owner', '0')->where('size', $input['size'])->orderBy('number')->get();

        if (!$locker->isEmpty()){
            $firstLocker = $locker->first();
            
            // send rs232 to open the available locker
            // temporary set port as 1, get the result and check if succeed

            // TODO reactivate this
            send_rs232(4, $firstLocker->code);

            // TODO if succeed, notify the owner by sms
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
            // if (Apart::where('number', $input['owner'])->isEmpty()) {
            //     return response()->json([
            //         'message' => 'Apart number is invalid.'], 500);
            // }
>>>>>>> Stashed changes
=======
            if (Apart::where('number', $input['owner'])->get()->isEmpty()) {
                return response()->json([
                    'message' => 'Apart number is invalid.'], 500);
            }
>>>>>>> Stashed changes
            $apart = Apart::where('number', $input['owner'])->first();
            // TODO if $apart is null, we will throw error ( if there is no number for this apart owner)
            $phone = $apart->phone;
            send_sms(Setting::where('key','sms_port')->first()->value, $phone, Setting::where('key', 'sms_msg')->first()->value);
            $firstLocker->owner = $input['owner'];
            $firstLocker->save();
            $response = [
                'result' => '0',
                'message' => 'ok', 
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'result' => '1',
                'message' => 'not available', 
            ];
            return response()->json($response, 200);
        }
    }

    public function open_lockers(Request $request)
    {
        $input = $request->all();
        $locker = Apart::select('*')->where('number', $input['number'])->get();
        if (!$locker->isEmpty()){
            $firstLocker = $locker->first();
            if ($firstLocker->pin == $input['pin']) {
                $result = Locker::select('*')->where('owner', $input['number'])->get();
                foreach($result as $r){
                    // TODO open the locker and update
<<<<<<< Updated upstream
                    send_rs232(4, $r->code);
=======
                    send_rs232($r->port, $r->code);
>>>>>>> Stashed changes
                    // TODO check if it succeed,
                    $r->owner = '0';
                    $r->save();
                    // echo $r->email;
                }
                $response = [
                    'result' => '0',
                    'message' => 'succeed', 
                ];
            } else {
                $response = [
                    'result' => '1',
                    'message' => 'incorrect pin', 
                ];
            }
        } else {
            $response = [
                'result' => '2',
                'message' => 'no available lockers for this owner', 
            ];
        }
        return response()->json($response, 200);
    }
}
