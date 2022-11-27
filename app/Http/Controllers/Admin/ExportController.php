<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\Transaction;

class ExportController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware('permission:user-list', ['only' => ['index','store']]);
		$this->middleware('permission:user-create', ['only' => ['create','store']]);
		$this->middleware('permission:user-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:user-delete', ['only' => ['destroy']]);
		$this->middleware('permission:profile-index', ['only' => ['profile','profile_update']]);

        $user_list = Permission::get()->filter(function($item) {
            return $item->name == 'user-list';
        })->first();
        $user_create = Permission::get()->filter(function($item) {
            return $item->name == 'user-create';
        })->first();
        $user_edit = Permission::get()->filter(function($item) {
            return $item->name == 'user-edit';
        })->first();
        $user_delete = Permission::get()->filter(function($item) {
            return $item->name == 'user-delete';
        })->first();
        $profile_index = Permission::get()->filter(function($item) {
            return $item->name == 'profile-index';
        })->first();


        if ($user_list == null) {
            Permission::create(['name'=>'user-list']);
        }
        if ($user_create == null) {
            Permission::create(['name'=>'user-create']);
        }
        if ($user_edit == null) {
            Permission::create(['name'=>'user-edit']);
        }
        if ($user_delete == null) {
            Permission::create(['name'=>'user-delete']);
        }
        if ($profile_index == null) {
            Permission::create(['name'=>'profile-index']);
        }
	}

		
	public function exportUsers(Request $request){
   
   $fileName = 'users.csv';
   $tasks = User::join('countries', 'users.country', '=', 'countries.id')
   ->orderBy('users.created_at', 'DESC')->get(['users.*', 'countries.country_name']);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Email', 'Name', 'Country', 'Status');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['Email']  = $task->email;
                $row['Name']    = $task->name;
                $row['Country']    = $task->country_name;
                $row['Status']  = $task->status;
                

                fputcsv($file, array($row['Email'], $row['Name'], $row['Country'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function exportWithdrawRequest(Request $request){

        $fileName = 'withdrawrequest_list.csv';
        $tasks = UserTransaction::join('users', 'user_transaction.user_id', '=', 'users.id')->where('user_transaction.status','Pending')->orderBy('user_transaction.created_at', 'DESC')->get(['user_transaction.*', 'users.name','users.email','users.wallet_address']);
        
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('Date', 'Promotor Name', 'Promotor Email','Transaction Amount', 'Wallet Address','Status');
     
             $callback = function() use($tasks, $columns) {
                 $file = fopen('php://output', 'w');
                 fputcsv($file, $columns);
     
                 foreach ($tasks as $task) {
                     $row['Date']  = $task->created_at;
                     $row['Promotor Name']    = $task->name;
                     $row['Promotor Email']    = $task->email;
                     $row['Transaction Amount']  = $task->transaction_amount;
                     $row['Wallet Address']  = $task->wallet_address;
                     $row['Status']  = $task->status;
                     
     
                     fputcsv($file, array($row['Date'], $row['Promotor Name'], $row['Promotor Email'], $row['Transaction Amount'], $row['Wallet Address'], $row['Status']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
         }

         public function exportCancelWithdraw(Request $request){

            $fileName = 'cancelwithdraw_list.csv';
            $tasks = UserTransaction::join('users', 'user_transaction.user_id', '=', 'users.id')->where('user_transaction.status','Cancelled')->orderBy('user_transaction.created_at', 'DESC')->get(['user_transaction.*', 'users.name','users.email','users.wallet_address']);
            
                 $headers = array(
                     "Content-type"        => "text/csv",
                     "Content-Disposition" => "attachment; filename=$fileName",
                     "Pragma"              => "no-cache",
                     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                     "Expires"             => "0"
                 );
         
                 $columns = array('Date', 'Promotor Name', 'Promotor Email','Transaction Amount', 'Wallet Address','Status');
         
                 $callback = function() use($tasks, $columns) {
                     $file = fopen('php://output', 'w');
                     fputcsv($file, $columns);
         
                     foreach ($tasks as $task) {
                         $row['Date']  = $task->created_at;
                         $row['Promotor Name']    = $task->name;
                         $row['Promotor Email']    = $task->email;
                         $row['Transaction Amount']  = '$'.round($task->transaction_amount,2);
                         $row['Wallet Address']  = $task->wallet_address;
                         $row['Status']  = $task->status;
                         
         
                         fputcsv($file, array($row['Date'], $row['Promotor Name'], $row['Promotor Email'], $row['Transaction Amount'], $row['Wallet Address'], $row['Status']));
                     }
         
                     fclose($file);
                 };
         
                 return response()->stream($callback, 200, $headers);
             }

             public function exportConfirmWithdraw(Request $request){

                $fileName = 'confirmwithdraw_list.csv';
                $tasks = UserTransaction::join('users', 'user_transaction.user_id', '=', 'users.id')->where('user_transaction.status','Confirmed')->orderBy('user_transaction.created_at', 'DESC')->get(['user_transaction.*', 'users.name','users.email','users.wallet_address']);
                
                     $headers = array(
                         "Content-type"        => "text/csv",
                         "Content-Disposition" => "attachment; filename=$fileName",
                         "Pragma"              => "no-cache",
                         "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                         "Expires"             => "0"
                     );
             
                     $columns = array('Date', 'Promotor Name', 'Promotor Email','Transaction Amount', 'Wallet Address','Status');
             
                     $callback = function() use($tasks, $columns) {
                         $file = fopen('php://output', 'w');
                         fputcsv($file, $columns);
             
                         foreach ($tasks as $task) {
                             $row['Date']  = $task->created_at;
                             $row['Promotor Name']    = $task->name;
                             $row['Promotor Email']    = $task->email;
                             $row['Transaction Amount']  = '$'.round($task->transaction_amount,2);
                             $row['Wallet Address']  = $task->wallet_address;
                             $row['Status']  = $task->status;
                             
             
                             fputcsv($file, array($row['Date'], $row['Promotor Name'], $row['Promotor Email'], $row['Transaction Amount'], $row['Wallet Address'], $row['Status']));
                         }
             
                         fclose($file);
                     };
             
                     return response()->stream($callback, 200, $headers);
                 }

                 public function exportTransactionHistory(Request $request){

                    $fileName = 'transactionhistory_list.csv';
                    $tasks = Transaction::join('users', 'transactions_log.user_id', '=', 'users.id')->orderBy('transactions_log.created_at', 'DESC')->get(['transactions_log.*', 'users.name','users.email','users.wallet_address']);
                    
                    
                         $headers = array(
                             "Content-type"        => "text/csv",
                             "Content-Disposition" => "attachment; filename=$fileName",
                             "Pragma"              => "no-cache",
                             "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                             "Expires"             => "0"
                         );
                 
                         $columns = array('Date', 'User Name', 'User Email', 'Wallet Address','Transaction Amount','Transaction Type');
             
                         $callback = function() use($tasks, $columns) {
                             $file = fopen('php://output', 'w');
                             fputcsv($file, $columns);
                 
                             foreach ($tasks as $task) {
                                $row['Date']  = date("d-M-Y", strtotime($task->created_at));
                                 $row['Promotor Name']    = $task->name;
                                 $row['Promotor Email']    = $task->email;
                                 $row['Wallet Address']  = $task->wallet_address;
                                 $row['Transaction Amount']  = '$'.round($task->approved_amount,2);
                                 $row['Transaction Type']  = $task->transaction_type;
                                 
                 
                                 fputcsv($file, array($row['Date'], $row['Promotor Name'], $row['Promotor Email'], $row['Wallet Address'], $row['Transaction Amount'], $row['Transaction Type']));
                             }
                 
                             fclose($file);
                         };
                 
                         return response()->stream($callback, 200, $headers);
                     }
}
