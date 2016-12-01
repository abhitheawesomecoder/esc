<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Extensions;
use App\Http\Requests\CreateExtensionsRequest;
use App\Http\Requests\UpdateExtensionsRequest;
use Illuminate\Http\Request;



class ExtensionsController extends Controller {

	/**
	 * Display a listing of extensions
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $extensions = Extensions::all();

		return view('admin.extensions.index', compact('extensions'));
	}

	/**
	 * Show the form for creating a new extensions
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.extensions.create');
	}

	/**
	 * Store a newly created extensions in storage.
	 *
     * @param CreateExtensionsRequest|Request $request
	 */
	public function store(CreateExtensionsRequest $request)
	{
	    
		Extensions::create($request->all());

		return redirect()->route(config('quickadmin.route').'.extensions.index');
	}

	/**
	 * Show the form for editing the specified extensions.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$extensions = Extensions::find($id);
	    
	    
		return view('admin.extensions.edit', compact('extensions'));
	}

	/**
	 * Update the specified extensions in storage.
     * @param UpdateExtensionsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateExtensionsRequest $request)
	{
		$extensions = Extensions::findOrFail($id);

        

		$extensions->update($request->all());

		return redirect()->route(config('quickadmin.route').'.extensions.index');
	}

	/**
	 * Remove the specified extensions from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Extensions::destroy($id);

		return redirect()->route(config('quickadmin.route').'.extensions.index');
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
            Extensions::destroy($toDelete);
        } else {
            Extensions::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.extensions.index');
    }

}
