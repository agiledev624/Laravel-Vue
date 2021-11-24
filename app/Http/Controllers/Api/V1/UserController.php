<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\Locker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
    return User::all();
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
    //
    $company = User::findOrFail($id);
    $input = $request->all();
    if ($input['allow'] == 1 && $company['port'] == 0 && $company['role'] == 'manager') {
      $available_id = DB::select("SELECT MIN(t1.port + 1) AS nextID
      FROM users t1
         LEFT JOIN users t2
             ON t1.port + 1 = t2.port
      WHERE t2.port IS NULL");
      // var_dump($available_id[0]->nextID);
      // exit(1);
      $input['port'] = (int)$available_id[0]->nextID;

      try {
        $lines = collect(file(base_path() . '/RS232.txt'))->map(function ($item) {
          return explode("\t", $item);
        });


        $insert_data = [];
        for ($i = 6; $i < count($lines); $i++) {
          array_push($insert_data, array('number' => $lines[$i][0], 'port' => $input['port'], 'size' => $lines[$i][1], 'owner' => '0', 'code' => substr($lines[$i][2], 0, -2)));
        }
        Locker::insert($insert_data);
        //code...
      } catch (\Throwable $th) {
        dd($th);
        //throw $th;
      }
    }
    $company->update($input);

    return $company;
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
  }
}
