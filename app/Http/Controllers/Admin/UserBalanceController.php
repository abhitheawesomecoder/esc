<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\UserBalance;
use App\Http\Requests\CreateUserBalanceRequest;
use App\Http\Requests\UpdateUserBalanceRequest;
use Illuminate\Http\Request;

use App\User;


class UserBalanceController extends Controller {

	/**
	 * Display a listing of userbalance
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $userbalance = UserBalance::with("user")->get();

		return view('admin.userbalance.index', compact('userbalance'));
	}

	/**
	 * Show the form for creating a new userbalance
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("id", "id")->prepend('Please select', null);

	    
	    return view('admin.userbalance.create', compact("user"));
	}

	/**
	 * Store a newly created userbalance in storage.
	 *
     * @param CreateUserBalanceRequest|Request $request
	 */
	public function store(CreateUserBalanceRequest $request)
	{
	    
		UserBalance::create($request->all());

		return redirect()->route(config('quickadmin.route').'.userbalance.index');
	}

	/**
	 * Show the form for editing the specified userbalance.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$userbalance = UserBalance::find($id);
	    $user = User::pluck("id", "id")->prepend('Please select', null);

	    
		return view('admin.userbalance.edit', compact('userbalance', "user"));
	}

	/**
	 * Update the specified userbalance in storage.
     * @param UpdateUserBalanceRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateUserBalanceRequest $request)
	{
		$userbalance = UserBalance::findOrFail($id);

        

		$userbalance->update($request->all());

		return redirect()->route(config('quickadmin.route').'.userbalance.index');
	}

	/**
	 * Remove the specified userbalance from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		UserBalance::destroy($id);

		return redirect()->route(config('quickadmin.route').'.userbalance.index');
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
            UserBalance::destroy($toDelete);
        } else {
            UserBalance::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.userbalance.index');
    }

}
