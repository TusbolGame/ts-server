<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\Movie\SubtitleService;
use App\TheaterSubtitleManager as TSM;
class SubtitleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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

    public function download($subFileId) {
        
        return TSM::downloadSubtitle($subFileId);
        // return $this->respond($resp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * return list of subtitle names from given
     * languages. If no language given, all 
     * available subnames will be return
     *
     * @param  int  $imdbId
     * @param  $lanuguage the language
     * @return Response
     */
    public function show(Request $request, $imdbId)
    {
        $languages = [];
        if ($request->has('lang')) {
            $languages = explode(',',$request->input('lang'));
        }
        $raw = FALSE;
        if ($request->has('raw')) {
            $raw = $request->input('raw');
        }
        $resp = TSM::getSubtitle($imdbId, $languages);
        return $this->respond($resp);
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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
