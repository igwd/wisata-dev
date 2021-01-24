<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use DataTables;
use DB;
use Validator;

class AccountController extends Controller
{
    public function index(){
    	return view('admin.account.index');
    }

    public function listData(){
    	$data = User::all();
    	$datatables = DataTables::of($data);
		return $datatables
		->addcolumn('aksi',function($data){
		                $url_edit = url('/')."/admin/account/{$data->id}/edit";
		                return "<a href='javascript:void(0)' onclick='edit({$data->id})' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>
		                <a href='javascript:void(0)' onclick='resetPassword({$data->id})' class='btn btn-sm btn-warning'><i class='fa fa-key'></i></a>
		                <a onclick='deleteData(\"{$data->id}\")' id='btn-delete{$data->id}' class='btn btn-sm btn-danger btn-delete' data-id='{$data->id}' data-name='{$data->name}'><i class='fa fa-trash'></i></a>";
		            })->rawColumns(['name','email','aksi'])
		            ->make(true);
    }

    public function create(Request $request){
    	$user = null;
        $method = 'POST';
        $action = url('/')."/admin/account/store";
        $tipe = 'create';
        return view('admin.account.form',compact('user','method','action','tipe'));
    }

    public function store(Request $request){
		$data = array('name'=>$request->name,'email'=>$request->email,'password'=>$request->password);
        $msg = array();
        // setting up rules
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ); 

        $messages = [
            'required' => '<i class="fa fa-times-circle"></i> :attribute tidak diperkenankan Kosong</br>',
            'min' => '<i class="fa fa-times-circle"></i> :attribute tidak diperkenankan kurang dari :min karakter</br>',
            'max' => '<i class="fa fa-times-circle"></i> Kolom :attribute tidak diperkenankan lebih dari :max karakter</br>',
            'without_spaces' => '<i class="fa fa-times-circle"></i>  Kolom :attribute kidak diperkenankan ada spasi</br>',
            'unique' => '<i class="fa fa-times-circle"></i> :attribute sudah terdaftar</br>',
            'email' => '<i class="fa fa-times-circle"></i> Alamat email tidak valid.</br>',
            'confirmed' => '<i class="fa fa-times-circle"></i> Kolom :attribute tidak sesuai dengan konfirmasi password</br>',
        ];
        
        $v = Validator::make($data, $rules, $messages);
        $errors = array();
        foreach ($v->messages()->toArray() as $err => $errvalue) {
            $errors = array_merge($errors, $errvalue);
        }

        if(!empty($errors)){
            return response()->json([
                'class' => 'alert-danger',
                'text' => $errors,
            ]);
        }else{
        	$user = new User;
	        $user->name = $request->name;
	        $user->email = $request->email;
	        $password = Hash::make($request->password);
	        $user->password = $password;
	        if($user->save()){
	            return response()->json([
	                'class' => 'alert-success',
	                'text' => 'Tambah data User '.$request->name.' berhasil.',
	            ]);
	        }else{
	            return response()->json([
	                'class' => 'alert-danger',
	                'text' => 'Tambah data User '.$request->name.' gagal.',
	            ]);
	        }
	    }
    }

    public function edit($id){
    	$user = User::where('id',$id)->first();
        $method = 'PUT';
        $tipe = 'edit';
        $action = url('/')."/admin/account/{$id}/update";
        return view('admin.account.form',compact('user','method','action','tipe'));
    }

    public function update(Request $request, $id){
    	$data = array('name'=>$request->name,'email'=>$request->email,'password'=>$request->password);
        $msg = array();
        // setting up rules
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ); 

        $messages = [
            'required' => '<i class="fa fa-times-circle"></i> :attribute tidak diperkenankan Kosong</br>',
            'min' => '<i class="fa fa-times-circle"></i> :attribute tidak diperkenankan kurang dari :min karakter</br>',
            'max' => '<i class="fa fa-times-circle"></i> Kolom :attribute tidak diperkenankan lebih dari :max karakter</br>',
            'without_spaces' => '<i class="fa fa-times-circle"></i>  Kolom :attribute kidak diperkenankan ada spasi</br>',
            'unique' => '<i class="fa fa-times-circle"></i> :attribute sudah terdaftar</br>',
            'email' => '<i class="fa fa-times-circle"></i> Alamat email tidak valid.</br>',
            'confirmed' => '<i class="fa fa-times-circle"></i> Kolom :attribute tidak sesuai dengan konfirmasi password</br>',
        ];
        
        $v = Validator::make($data, $rules, $messages);
        $errors = array();
        foreach ($v->messages()->toArray() as $err => $errvalue) {
            $errors = array_merge($errors, $errvalue);
        }

        if(!empty($errors)){
            return response()->json([
                'class' => 'alert-danger',
                'text' => $errors,
            ]);
        }else{
	    	$user = User::find($id);
	    	$user->name = $request->name;
	    	$user->email = $request->email;

	        if($user->save()){
	            return response()->json([
	                'class' => 'alert-success',
	                'text' => 'Update data User '.$request->name.' berhasil.',
	            ]);
	        }else{
	            return response()->json([
	                'class' => 'alert-danger',
	                'text' => 'Update data User '.$request->name.' gagal.',
	            ]);
	        }
	    }
    }

    public function resetPassword($id){
    	$user = User::where('id',$id)->first();
        $method = 'PUT';
        $tipe = 'resetpassword';
        $action = url('/')."/admin/account/{$id}/updatepassword";
        return view('admin.account.form',compact('user','method','action','tipe'));
    }

    public function updatePassword(Request $request, $id){
    	$data = array('name'=>$request->name,'email'=>$request->email,'password'=>$request->password);
        $msg = array();
        // setting up rules
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|min:6',
        ); 

        $messages = [
            'required' => '<i class="fa fa-times-circle"></i> :attribute tidak diperkenankan Kosong</br>',
            'min' => '<i class="fa fa-times-circle"></i> :attribute tidak diperkenankan kurang dari :min karakter</br>',
            'max' => '<i class="fa fa-times-circle"></i> Kolom :attribute tidak diperkenankan lebih dari :max karakter</br>',
            'without_spaces' => '<i class="fa fa-times-circle"></i>  Kolom :attribute kidak diperkenankan ada spasi</br>',
            'unique' => '<i class="fa fa-times-circle"></i> :attribute sudah terdaftar</br>',
            'email' => '<i class="fa fa-times-circle"></i> Alamat email tidak valid.</br>',
            'confirmed' => '<i class="fa fa-times-circle"></i> Kolom :attribute tidak sesuai dengan konfirmasi password</br>',
        ];
        
        $v = Validator::make($data, $rules, $messages);
        $errors = array();
        foreach ($v->messages()->toArray() as $err => $errvalue) {
            $errors = array_merge($errors, $errvalue);
        }

        if(!empty($errors)){
            return response()->json([
                'class' => 'alert-danger',
                'text' => $errors,
            ]);
        }else{
	    	$user = User::find($id);
	    	$user->name = $request->name;
	    	$user->email = $request->email;
	    	if(!empty($request->password)){
		    	$password = Hash::make($request->password);
		        $user->password = $password;
		    }

	        if($user->save()){
	            return response()->json([
	                'class' => 'alert-success',
	                'text' => 'Update password User '.$request->name.' berhasil.',
	            ]);
	        }else{
	            return response()->json([
	                'class' => 'alert-danger',
	                'text' => 'Update password User '.$request->name.' gagal.',
	            ]);
	        }
	    }
    }	

    public function destroy(Request $request, $id){
    	$del = User::where('id',$id)->delete();
        //$del = true;
        if($del){
            //@unlink($request->file);
            $msg = array('class'=>'alert-success','text'=>'Berhasil hapus data User #'.$request->name);
        }else{
            $msg = array('class'=>'alert-danger','text'=>'Gagal hapus data User #'.$request->name);
        }
        return response()->json($msg);
    }
}
