<?php
/**
 * Created by PhpStorm.
 * User: hebin
 * Date: 2017-09-15
 * Time: 13:11
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Crypt;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Session;
use App\Record;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    public function apiGetCSRF()
    {
        return Response::json(array(
            'csrf' => csrf_token(),
        ));
    }

    public function apiScore(Request $request)
    {
        $score = $request->score;
        $csrf = $request->_token;
        $sign = $request->sign;
        $success = true;
        $err_msg = "";
        $beat = 0;
        $all_score = 0;

        if ($sign != hash('sha256', "{$csrf}_is_t0_s1gn_{$score}")) {
            $suceess = false;
            $err_msg = "Invalid sign";
        } else {
            $record = new Record(array(
                'record' => $score
            ));
            $record->save();
            $records = Record::orderBy('record', 'desc')->get();
            $count = 0;
            $rank = -1;
            foreach ($records as $n_record) {
                $count++;
                if ($n_record->id == $record->id) {
                    $rank = $count;
                }
                $all_score += $n_record->record;
            }
            $beat = round(((float)$records->count() - $rank + 1) / $records->count() * 10000) / 100;
        }
        return Response::json(array(
            "success" => $success,
            "msg" => $err_msg,
            "beat" => $beat,
            "all" => $all_score
        ));
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
