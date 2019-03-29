<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

class UserController extends Controller
{
    public function index()
    {
		$users = User::where('estado', '1')
			->where('role', 'admin')
			->get();

		if(Auth::user()->role=='super'){
			$users = User::where('estado', '1')
			->whereIn('role', ['admin', 'super'])
			->get();
		}

        return view('admin.user.index')->with('users', $users);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function edit($id)
    {
		$user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        try 
        {
            $user = User::findOrFail($id);  

            $currentPass = $user->password;

            if( trim($request->get('password'),' ') != '' )
            {
                $currentPass = bcrypt(trim($request->get('password')));
            }

            $user->name = $request->get('name');
			$user->email = $request->get('email');
			$user->role = $request->get('role');
			$user->password = $currentPass;
            $user->save();
        }
        catch(\Exception $e)
        {
            Log::error('Error update user: ' . $e->getMessage());
            return back()->with('warning','Error al actualizar usuario')->withInput();
        }
        return redirect()->route('admin.user.index')->with('success','Se ha actualizado el Usuario'); 
    }

    public function destroy($id)
    {
		$user = User::find($id);
		if(Auth::user()->id == $user->id){
			return response()->json('No te puedes eliminar a ti mismo', 401);
		}else{
			$user = User::destroy($id);
			return back()->with('success','Usuario eliminado ' . $user->name); 
		}
    }
}
