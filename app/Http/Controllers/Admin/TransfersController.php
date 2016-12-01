<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Transfers;
use App\Http\Requests\CreateTransfersRequest;
use App\Http\Requests\UpdateTransfersRequest;
use Illuminate\Http\Request;

use App\User;


class TransfersController extends Controller {

	/**
	 * Display a listing of transfers
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $transfers = Transfers::with("user")->get();

		return view('admin.transfers.index', compact('transfers'));
	}

	/**
	 * Show the form for creating a new transfers
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("id", "id")->prepend('Please select', null);

	    
	    return view('admin.transfers.create', compact("user"));
	}

	/**
	 * Store a newly created transfers in storage.
	 *
     * @param CreateTransfersRequest|Request $request
	 */
	public function store(CreateTransfersRequest $request)
	{
	    
		Transfers::create($request->all());

		return redirect()->route(config('quickadmin.route').'.transfers.index');
	}

	/**
	 * Show the form for editing the specified transfers.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$transfers = Transfers::find($id);
	    $user = User::pluck("id", "id")->prepend('Please select', null);

	    
		return view('admin.transfers.edit', compact('transfers', "user"));
	}

	/**
	 * Update the specified transfers in storage.
     * @param UpdateTransfersRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTransfersRequest $request)
	{
		$transfers = Transfers::findOrFail($id);

        

		$transfers->update($request->all());

		return redirect()->route(config('quickadmin.route').'.transfers.index');
	}

	/**
	 * Remove the specified transfers from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Transfers::destroy($id);

		return redirect()->route(config('quickadmin.route').'.transfers.index');
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
            Transfers::destroy($toDelete);
        } else {
            Transfers::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.transfers.index');
    }

}
