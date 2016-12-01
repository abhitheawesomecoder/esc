<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Temp;
use App\Http\Requests\CreateTempRequest;
use App\Http\Requests\UpdateTempRequest;
use Illuminate\Http\Request;



class TempController extends Controller {

	/**
	 * Display a listing of temp
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $temp = Temp::all();

		return view('admin.temp.index', compact('temp'));
	}

	/**
	 * Show the form for creating a new temp
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.temp.create');
	}

	/**
	 * Store a newly created temp in storage.
	 *
     * @param CreateTempRequest|Request $request
	 */
	public function store(CreateTempRequest $request)
	{
	    
		Temp::create($request->all());

		return redirect()->route(config('quickadmin.route').'.temp.index');
	}

	/**
	 * Show the form for editing the specified temp.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$temp = Temp::find($id);
	    
	    
		return view('admin.temp.edit', compact('temp'));
	}

	/**
	 * Update the specified temp in storage.
     * @param UpdateTempRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTempRequest $request)
	{
		$temp = Temp::findOrFail($id);

        

		$temp->update($request->all());

		return redirect()->route(config('quickadmin.route').'.temp.index');
	}

	/**
	 * Remove the specified temp from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Temp::destroy($id);

		return redirect()->route(config('quickadmin.route').'.temp.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Temp::destroy($toDelete);
        } else {
            Temp::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.temp.index');
    }

}
