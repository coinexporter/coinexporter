<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\CampaignCategory;

class CampaignTypeController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware('permission:role-list', ['only' => ['index','store']]);
		$this->middleware('permission:role-create', ['only' => ['create','store']]);
		$this->middleware('permission:role-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $role_list = Permission::get()->filter(function($item) {
            return $item->name == 'role-list';
        })->first();
        $role_create = Permission::get()->filter(function($item) {
            return $item->name == 'role-create';
        })->first();
        $role_edit = Permission::get()->filter(function($item) {
            return $item->name == 'role-edit';
        })->first();
        $role_delete = Permission::get()->filter(function($item) {
            return $item->name == 'role-delete';
        })->first();


        if ($role_list == null) {
            Permission::create(['name'=>'role-list']);
        }
        if ($role_create == null) {
            Permission::create(['name'=>'role-create']);
        }
        if ($role_edit == null) {
            Permission::create(['name'=>'role-edit']);
        }
        if ($role_delete == null) {
            Permission::create(['name'=>'role-delete']);
        }
	}

	public function index(Request $request)
	{
		$campaigntypes = CampaignCategory::all();
		return view('admin.campaigntypes.index',compact('campaigntypes'));
	}

	public function create()
	{
		$campaigntypes = CampaignCategory::get();
		return view('admin.campaigntypes.create',compact('campaigntypes'));
	}

	public function store(Request $request)
	{
		$rules = [
            'campaign_category_name' 					=> 'required|unique:campaign_categories,campaign_category_name',
            'campaign_category_status' 					=> 'required',
        ];

        $messages = [
            'campaign_category_name.required'    		=> __('default.form.validation.campaign_category_name.required'),
            'campaign_category_name.unique'    		=> __('default.form.validation.campaign_category_name.unique'),
            'campaign_category_status.required'   => __('default.form.validation.campaign_category_status.required'),
        ];
        
        $this->validate($request, $rules, $messages);
       
		try {
            $role = CampaignCategory::create([
                'campaign_category_name' => $request->input('campaign_category_name'), 
                'campaign_category_status' => $request->input('campaign_category_status')
            ]);
			
			Toastr::success(__('campaigntype.message.store.success'));
		    return redirect()->route('campaigntypes.index');
		} catch (Exception $e) {
            Toastr::error(__('campaigntype.message.store.error'));
		    return redirect()->route('campaigntypes.index');
		} 
	}

	public function edit($id)
	{
        $campaigntypes = CampaignCategory::find($id);

		return view('admin.campaigntypes.edit',compact('campaigntypes'));
	}

	public function update(Request $request, $id)
	{
		$rules = [
            'campaign_category_name' 					=> 'required|unique:campaign_categories,campaign_category_name,' . $id,
			'campaign_category_status' 			=> 'required',
        ];

        $messages = [
            'campaign_category_name.required'    		=> __('default.form.validation.campaign_category_name.required'),
            'campaign_category_name.unique'    		=> __('default.form.validation.campaign_category_name.unique'),
            'campaign_category_status.required'    		=> __('default.form.validation.campaign_category_status.required'),
        ];
        
        $this->validate($request, $rules, $messages);

        try {
			$campaigntypes = CampaignCategory::find($id);
			$campaigntypes->campaign_category_name = $request->input('campaign_category_name');
			$campaigntypes->campaign_category_status = $request->input('campaign_category_status');
			$campaigntypes->save();

            Toastr::success(__('campaigntype.message.update.success'));
		    return redirect()->route('campaigntypes.index');
		} catch (Exception $e) {
            Toastr::error(__('campaigntype.message.update.error'));
		    return redirect()->route('campaigntypes.index');
		}
	}

	public function destroy()
	{
		$id = request()->input('id');
		try {
            CampaignCategory::find($id)->delete();
			return redirect()->route('campaigntypes.index')->with(Toastr::error(__('campaigntype.message.destroy.success')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('campaigntype.message.destroy.error'));
			return redirect()->route('campaigntypes.index')->with($error_msg);
		}
	}

}
