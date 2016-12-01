<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Transactions;
use App\Http\Requests\CreateTransactionsRequest;
use App\Http\Requests\UpdateTransactionsRequest;
use Illuminate\Http\Request;

use App\User;


class TransactionsController extends Controller {

	/**
	 * Display a listing of transactions
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $transactions = Transactions::with("user")->get();

		return view('admin.transactions.index', compact('transactions'));
	}

	/**
	 * Show the form for creating a new transactions
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::pluck("id", "id")->prepend('Please select', null);


	    return view('admin.transactions.create', compact("user"));
	}

	/**
	 * Store a newly created transactions in storage.
	 *
     * @param CreateTransactionsRequest|Request $request
	 */
	public function store(CreateTransactionsRequest $request)
	{

		Transactions::create($request->all());

		return redirect()->route(config('quickadmin.route').'.transactions.index');
	}

	/**
	 * Show the form for editing the specified transactions.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$transactions = Transactions::find($id);
	    $user = User::pluck("id", "id")->prepend('Please select', null);


		return view('admin.transactions.edit', compact('transactions', "user"));
	}

	/**
	 * Update the specified transactions in storage.
     * @param UpdateTransactionsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTransactionsRequest $request)
	{
		$transactions = Transactions::findOrFail($id);



		$transactions->update($request->all());

		return redirect()->route(config('quickadmin.route').'.transactions.index');
	}

	/**
	 * Remove the specified transactions from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Transactions::destroy($id);

		return redirect()->route(config('quickadmin.route').'.transactions.index');
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
            Transactions::destroy($toDelete);
        } else {
            Transactions::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.transactions.index');
    }

}
