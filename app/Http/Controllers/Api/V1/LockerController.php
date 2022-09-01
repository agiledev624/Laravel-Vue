<?php

namespace App\Http\Controllers\api\v1;

use App\Locker;
use App\Setting;
use App\Apart;
use App\Depart;
use App\User;
use App\Courier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Hash;

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
    public function show($id)
    {
        //
        return Locker::findOrFail($id);
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
    public function update(Request $request, $id)
    {
        //
        $company = Locker::findOrFail($id);
        $company->update($request->all());

        return $company;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $company = Locker::findOrFail($id);
        $company->delete();
        return '';
    }

    public function check_courier($courier)
    {
        return User::where('courier', $courier)->firstOrFail(['address', 'phone']);
    }

    public function list($id)
    {
        return Locker::select('*')->where('port', $id)->get();
    }

    public function check_owner($owner)
    {
        return User::where('owner', $owner)->firstOrFail(['address']);
    }

    public function new_assign(Request $request, Recaptcha $recaptcha)
    {
        $this->validate($request, [
            'size' => 'required',
            'owner' => 'required',
            'recaptcha' => ['required', $recaptcha],
            'unique' => 'required',
        ]);
        $input = $request->all();
        $depart = User::select('*')->where('courier', $input['unique'])->orderBy('id')->get();
        if ($depart->isEmpty()) {
            return response()->json([
                'message' => 'Invaid request to the server. (Illegal Url)'
            ], 500);
        }
        // $url = url('') . '/owner/' . $depart->first()->owner;
        $url = 'http://stratalockers.com.au' . '/owner/' . $depart->first()->owner;
        // return '';
        $locker = Locker::select('*')->where([['owner', '0'], ['size', $input['size']], ['port', $depart->first()->port]])->orderBy('number')->get();

        if (!$locker->isEmpty()) {
            $firstLocker = $locker->first();

            // send rs232 to open the available locker
            // temporary set port as 1, get the result and check if succeed

            try {
                // TODO reactivate this
                send_rs232($firstLocker->port, $firstLocker->code);

                // TODO if succeed, notify the owner by sms
                if (Apart::where([['number', $input['owner']], ['user_id', $depart->first()->id]])->get()->isEmpty()) {
                    return response()->json([
                        'message' => 'Apart number is invalid.'
                    ], 500);
                }
                $apart = Apart::where([['number', $input['owner']], ['user_id', $depart->first()->id]])->first();
                // TODO if $apart is null, we will throw error ( if there is no number for this apart owner)
                $phone = $apart->phone;
                $setting = Setting::where('key', 'total_use')->first();
                $setting->value = $setting->value + 1;
                $setting->save();
                // send_sms(Setting::where('key','sms_port')->first()->value, $phone, Setting::where('key', 'sms_msg')->first()->value);

                // TODO temporary commented for local test
                send_sms_via_gsm($phone, $input['owner'], Setting::where('key', 'sms_msg')->first()->value, $url);
                $firstLocker->owner = $input['owner'];
                $firstLocker->reminded = false;
                $firstLocker->locked_time = now()->timestamp;
                $firstLocker->save();
                $response = [
                    'result' => '0',
                    'message' => 'ok',
                    'locker' => $firstLocker->number
                ];

                return response()->json($response, 200);
            } catch (Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        } else {
            $response = [
                'result' => '1',
                'message' => 'not available',
            ];
            return response()->json($response, 200);
        }
    }

    public function open_lockers(Request $request, Recaptcha $recaptcha)
    {
        $this->validate($request, [
            'phone' => 'required',
            'number' => 'required',
            'pin' => 'required',
            'recaptcha' => ['required', $recaptcha],
            'unique' => 'required',
        ]);
        // return '';
        $input = $request->all();
        $depart = User::select('*')->where('owner', $input['unique'])->orderBy('id')->get();
        // $depart = Depart::select('*')->where('owner', $input['unique'])->orderBy('number')->get();
        if ($depart->isEmpty()) {
            return response()->json([
                'message' => 'Invaid request to the server. (Illegal Url)'
            ], 500);
        }
        $locker = Apart::select('*')->where([['number', $input['number']], ['user_id', $depart->first()->id]])->get();
        if (!$locker->isEmpty()) {
            $firstLocker = $locker->first();
            if (
                $firstLocker->pin == $input['pin'] &&
                remove_whitespace($firstLocker->phone) == remove_whitespace($input['phone'])
            ) {
                $result = Locker::select('*')->where([['owner', $input['number']], ['port', $depart->first()->port]])->get();
                foreach ($result as $r) {
                    // TODO open the locker and update
                    send_rs232($r->port, $r->code);
                    // TODO check if it succeed,
                    $r->owner = '0';
                    $r->reminded = false;
                    $r->save();
                    // echo $r->email;
                }
                if ($result->isEmpty()) {
                    $response = [
                        'result' => '2',
                        'message' => 'no parcles for this owner',
                    ];
                } else {
                    $response = [
                        'result' => '0',
                        'message' => 'succeed',
                        'ids' => $result->pluck('number')
                    ];
                }
            } else {
                $response = [
                    'result' => '1',
                    'message' => 'incorrect pin or number',
                ];
            }
        } else {
            $response = [
                'result' => '3',
                'message' => 'not available lockers for the input',
            ];
        }
        return response()->json($response, 200);
    }

    public function open_locker(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'port' => 'required'
        ]);
        // return '';
        $input = $request->all();
        $result = Locker::select('*')->where([['number', $input['number']], ['port', $input['port']]])->get();

        foreach ($result as $r) {
            // TODO open the locker and update
            send_rs232($r->port, $r->code);
            // TODO check if it succeed,
            $r->owner = '0';
            $r->reminded = false;
            $r->save();
            // echo $r->email;
        }
        $response = [
            'result' => '0',
            'message' => 'succeed',
        ];
        return response()->json($response, 200);
    }

    public function notify_owner(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'apart_number' => 'required'
        ]);
        $input = $request->all();

        $result = Apart::where([['number', $input['apart_number']], ['user_id', $input['user_id']]])->get();
        if ($result->isEmpty()) {
            $response = [
                'result' => '1',
                'message' => 'no apartment',
            ];
            return response()->json($response, 200);
        }
        $result->first();

        $depart = User::select('*')->where('id', $input['user_id'])->orderBy('id')->get();
        if ($depart->isEmpty()) {
            return response()->json([
                'message' => 'Invaid request to the server. (Illegal Url)'
            ], 500);
        }
        // $url = url('') . '/owner/' . $depart->first()->owner;
        $url = 'http://stratalockers.com.au' . '/owner/' . $depart->first()->owner;

        send_sms_via_gsm($result->first()->phone, $input['apart_number'], Setting::where('key', 'sms_msg')->first()->value, $url);

        $response = [
            'result' => '0',
            'message' => 'succeed',
        ];
        return response()->json($response, 200);
    }

    public function get_status($id)
    {
        $response = [];
        if ($id == 0) {
            $total_use = Setting::where('key', 'total_use')->first()->value;
            $total_users = User::count();
            $total_lockers = Locker::count();
            $total_apart = Apart::count();
            $response = [
                'result' => '0',
                'message' => 'ok',
                'total_users' => $total_users,
                'total_use' => $total_use,
                'total_lockers' => $total_lockers,
                'total_aparts' => $total_apart,
            ];
        } else {
            $apart_count = Apart::where('user_id', $id)->count();
            $user_port = User::where('id', $id)->first()->port;
            $locker_count = Locker::where('port', $user_port)->count();
            $unopened = Locker::where([['port', $user_port], ['owner', '!=', 0]])->count();
            $response = [
                'result' => '0',
                'message' => 'ok',
                'unopened' => $unopened,
                'total_lockers' => $locker_count,
                'total_aparts' => $apart_count,
            ];
        }
        return response()->json($response, 200);
    }

    public function check_reminder()
    {
        $MAX_DIFF_TIME = 24 * 60 * 60;
        $checked_lockers = 0;

        try {
            $result = Locker::where([['owner', '!=', '0'], ['reminded', false]])->get()->groupBy('port');
            foreach ($result as $r) {
                $port = -1;
                $user_id = -1;
                $url = '';
                foreach ($r as $locker) {
                    if ($port < 0) {
                        $user = User::select('*')->where('port', $locker->port)->orderBy('id')->get()->first();
                        $port = $locker->port;
                        // $url = url('') . '/owner/' . $user->owner;
                        $url = 'http://stratalockers.com.au' . '/owner/' . $user->owner;
                    }
                    if ((now()->timestamp - $locker->locked_time) >= $MAX_DIFF_TIME) {
                        $apart = Apart::where([['number', $locker['owner']], ['user_id', $user->id]])->first();

                        send_sms_via_gsm($apart->phone, $locker['owner'], 'Reminder Message ' . Setting::where('key', 'sms_msg')->first()->value, $url);

                        $locker->reminded = true;
                        $locker->save();

                        $checked_lockers++;
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        $response = [
            'result' => '0',
            'message' => 'succeed',
            'time' => date("D M d, Y G:i"),
            'count' => $checked_lockers,
        ];
        return response()->json($response, 200);
    }

    public function access_foyer(Request $request, Recaptcha $recaptcha)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'recaptcha' => ['required', $recaptcha],
            'unique' => 'required',
        ]);
        $input = $request->all();
        $depart = User::select('*')->where('courier', $input['unique'])->orderBy('id')->get();

        if ($depart->isEmpty()) {
            return response()->json([
                'message' => 'Invaid request to the server. (Illegal Url)'
            ], 500);
        }

        $courier = Courier::select('*')->where([['user_id', $depart->first()->id], ['name', $input['name']]])->get();

        if ($courier->isEmpty()) {
            return response()->json([
                'result' => '1',
                'message' => 'No user for the building'
            ], 200);
        }

        // if ($courier->first()->password != bcrypt($input['password'])) {
        if (!Hash::check($input['password'], $courier->first()->password)) {
            return response()->json([
                'result' => '1',
                'message' => 'Wrong password'
            ], 200);
        }


        // send rs232 to open the foyer front door
        // temporary set port as 1, get the result and check if succeed

        try {
            // TODO reactivate this

            $setting = Setting::where('key', 'foyer_code')->first();

            send_rs232($depart->first()->port, $setting->value);

            $response = [
                'result' => '0',
                'message' => 'ok',
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
