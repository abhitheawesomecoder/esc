<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\WithdrawalRequest;
use App\Http\Requests\CreateWithdrawalRequestRequest;
use App\Http\Requests\UpdateWithdrawalRequestRequest;
use Illuminate\Http\Request;

use App\User;


class WithdrawalRequestController extends Controller {

	/**
	 * Display a listing of withdrawalrequest
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $withdrawalrequest = WithdrawalRequest::with("user")->get();

		return view('admin.withdrawalrequest.index', compact('withdrawalrequest'));
	}

	/**
	 * Show the form for creating a new withdrawalrequest
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("id", "id")->prepend('Please select', null);

	    
	    return view('admin.withdrawalrequest.create', compact("user"));
	}

	/**
	 * Store a newly created withdrawalrequest in storage.
	 *
     * @param CreateWithdrawalRequestRequest|Request $request
	 */
	public function store(CreateWithdrawalRequestRequest $request)
	{
	    
		WithdrawalRequest::create($request->all());

		return redirect()->route(config('quickadmin.route').'.withdrawalrequest.index');
	}

	/**
	 * Show the form for editing the specified withdrawalrequest.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$withdrawalrequest = WithdrawalRequest::find($id);
	    $user = User::pluck("id", "id")->prepend('Please select', null);

	    
		return view('admin.withdrawalrequest.edit', compact('withdrawalrequest', "user"));
	}

	/**
	 * Update the specified withdrawalrequest in storage.
     * @param UpdateWithdrawalRequestRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateWithdrawalRequestRequest $request)
	{
		$withdrawalrequest = WithdrawalRequest::findOrFail($id);

        

		$withdrawalrequest->update($request->all());

		return redirect()->route(config('quickadmin.route').'.withdrawalrequest.index');
	}

	/**
	 * Remove the specified withdrawalrequest from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		WithdrawalRequest::destroy($id);

		return redirect()->route(config('quickadmin.route').'.withdrawalrequest.index');
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
            WithdrawalRequest::destroy($toDelete);
        } else {
            WithdrawalRequest::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.withdrawalrequest.index');
    }

}
