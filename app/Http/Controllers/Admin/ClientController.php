<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

class ClientController extends Controller
{
    public function index()
    {
        // $clients = User::join("role_user","users.id","=","role_user.user_id")
		// ->where("role_id","=","4")->get(); // 4 client
		$clients = User::where('estado', '1')
		->where('role', 'cliente')
		->get();
        return view('admin.client.index')->with('clients', $clients);
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        try
        {
            $contactos = json_decode($request->get('jsonContacto'));
            $emailPrincipal = $contactos[0]->correo;

            $client = new User([
				'role' => 'cliente',
                'name' => $request->get('razonsocial'),
                'email' => $emailPrincipal,
                'ruc' => $request->get('ruc'),
                'flag' => $request->get('bandera'),
                'group' => $request->get('grupo'),
                'direction' => $request->get('direccion'),
                'contacts' => $request->get('jsonContacto'),
                'password' => bcrypt($request->get('ruc'))
			]);
			
			$client->save();
        }
        catch(\Exception $e)
        {
            // Log::error('Error save client/user:: ' . $e->getMessage());
            // return redirect()->route('clients.index')->withErrors( $e->getMessage() );
            return back()->withInput()->with('warning', 'Error al tratar de crear nuevo cliente.');
            // ->withInput();
        }
        return redirect()->route('admin.client.index')->with('success','Se ha creado el Cliente');  
    }

    public function show($id)
    {
        $client = User::find($id);
        return response()->json($client);
    }

    public function edit($id)
    {
        $client = User::find($id);
        $contactos = json_decode($client->contacts);
        return view('admin.client.edit', compact('client', 'contactos'));  
    }

    public function update(Request $request, $id)
    {

        try 
        {
            $contactos = json_decode($request->get('jsonContacto'));
            $emailPrincipal = $contactos[0]->correo;

            $client = User::findOrFail($id);  

            $currentPass = $client->password;

            if( trim($request->get('password'),' ') != '' )
            {
                $currentPass = bcrypt(trim($request->get('password')));
            }

			$client->email = $emailPrincipal;
			$client->password = $currentPass;
            $client->ruc = $request->get('ruc');
            $client->name = $request->get('razonsocial');
            $client->flag = $request->get('bandera');
            $client->group = $request->get('grupo');
            $client->direction = $request->get('direccion');
            $client->contacts=  $request->get('jsonContacto');
            $client->save();
        }
        catch(\Exception $e)
        {
            Log::error('Error update client/user: ' . $e->getMessage());
            return back()->with('warning','Error al actualizar cliente' . $e); 
            // ->withInput();
        }
        return redirect()->route('admin.client.index')->with('success','Se ha actualizado el Cliente'); 
    }

    public function destroy($id)
    {
		try {

			$deleted = User::destroy($id);

			if($deleted){
				return response()->json("ok");
			}
			else{
				return response()->json("Error al eliminar cliente", 401);
			}
		} catch (\Exception $err) {
			return response()->json("Error al eliminar cliente", 401);
		}

        // $client = User::findOrFail($id);
        // $client->estado = 0;
        // $client->save();
    }
}