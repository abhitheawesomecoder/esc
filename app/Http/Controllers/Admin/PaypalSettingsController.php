<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\PaypalSettings;
use App\Http\Requests\CreatePaypalSettingsRequest;
use App\Http\Requests\UpdatePaypalSettingsRequest;
use Illuminate\Http\Request;



class PaypalSettingsController extends Controller {

	/**
	 * Display a listing of paypalsettings
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $paypalsettings = PaypalSettings::all();

		return view('admin.paypalsettings.index', compact('paypalsettings'));
	}

	/**
	 * Show the form for creating a new paypalsettings
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.paypalsettings.create');
	}

	/**
	 * Store a newly created paypalsettings in storage.
	 *
     * @param CreatePaypalSettingsRequest|Request $request
	 */
	public function store(CreatePaypalSettingsRequest $request)
	{
	    
		PaypalSettings::create($request->all());

		return redirect()->route(config('quickadmin.route').'.paypalsettings.index');
	}

	/**
	 * Show the form for editing the specified paypalsettings.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$paypalsettings = PaypalSettings::find($id);
	    
	    
		return view('admin.paypalsettings.edit', compact('paypalsettings'));
	}

	/**
	 * Update the specified paypalsettings in storage.
     * @param UpdatePaypalSettingsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePaypalSettingsRequest $request)
	{
		$paypalsettings = PaypalSettings::findOrFail($id);

        

		$paypalsettings->update($request->all());

		return redirect()->route(config('quickadmin.route').'.paypalsettings.index');
	}

	/**
	 * Remove the specified paypalsettings from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		PaypalSettings::destroy($id);

		return redirect()->route(config('quickadmin.route').'.paypalsettings.index');
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
            PaypalSettings::destroy($toDelete);
        } else {
            PaypalSettings::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.paypalsettings.index');
    }

}
