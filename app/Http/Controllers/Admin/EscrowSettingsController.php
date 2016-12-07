<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\EscrowSettings;
use App\Http\Requests\CreateEscrowSettingsRequest;
use App\Http\Requests\UpdateEscrowSettingsRequest;
use Illuminate\Http\Request;



class EscrowSettingsController extends Controller {

	/**
	 * Display a listing of escrowsettings
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $escrowsettings = EscrowSettings::all();

		return view('admin.escrowsettings.index', compact('escrowsettings'));
	}

	/**
	 * Show the form for creating a new escrowsettings
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.escrowsettings.create');
	}

	/**
	 * Store a newly created escrowsettings in storage.
	 *
     * @param CreateEscrowSettingsRequest|Request $request
	 */
	public function store(CreateEscrowSettingsRequest $request)
	{
	    
		EscrowSettings::create($request->all());

		return redirect()->route(config('quickadmin.route').'.escrowsettings.index');
	}

	/**
	 * Show the form for editing the specified escrowsettings.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$escrowsettings = EscrowSettings::find($id);
	    
	    
		return view('admin.escrowsettings.edit', compact('escrowsettings'));
	}

	/**
	 * Update the specified escrowsettings in storage.
     * @param UpdateEscrowSettingsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateEscrowSettingsRequest $request)
	{
		$escrowsettings = EscrowSettings::findOrFail($id);

        

		$escrowsettings->update($request->all());

		return redirect()->route(config('quickadmin.route').'.escrowsettings.index');
	}

	/**
	 * Remove the specified escrowsettings from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		EscrowSettings::destroy($id);

		return redirect()->route(config('quickadmin.route').'.escrowsettings.index');
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
            EscrowSettings::destroy($toDelete);
        } else {
            EscrowSettings::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.escrowsettings.index');
    }

}
