<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Auth;
use App\File;
use App\Folder;

class FileController extends Controller
{
	public function listFiles($id)
    {

		$files = DB::table('files')
			->join('folders', 'folders.id', '=', 'files.folder_id')
			->select('files.*', 'folders.path')
			->addSelect(DB::raw(' (select name from users as u where u.id = files.inserted_by ) as user_name '))
			->where('files.folder_id', $id)
			->get();

		if(Auth::user()->role == 'cliente'){
			$files = DB::table('files')
			->join('folders', 'folders.id', '=', 'files.folder_id')
			->select('files.*', 'folders.path')
			->where('files.folder_id', $id)
			->where('files.client_id', Auth::user()->id)
			->get();
		}

		return $files->toJson();
	}
	
	public function getDetailsFile($id){

		$files = DB::table('files')
			->join('folders', 'folders.id', '=', 'files.folder_id')
			->select('files.*', 'folders.path as location')
			->addSelect(DB::raw(' (select name from users as u where u.id = files.inserted_by ) as user_name '))
			->addSelect(DB::raw(' (select name from users as u where u.id = files.client_id ) as client_name '))
			->where('files.id', $id)
			->get();

		return $files->toJson();
	}

	public function renameFile($name, $file_id){
		try {
			$name = trim($name);
			$current_path = '';
			$file = File::find($file_id);

			$oldNameFile = $file->name;
			$oldFullNameFile = $file->fullname;

			if(!$file){
				return response()->json("Error al tratar de acceder al archivo a renombrar", 401);
			}

			$folder = Folder::find($file->folder_id);
			if(!$folder){
				return response()->json("Error al acceder a la ruta del archivo", 401);
			}

			$folder_parent_path = $folder->path;

			$duplicatedFile = Storage::disk('public')->exists($folder_parent_path . $name . $file->extension);

			if($duplicatedFile){
				return response()->json("Hay un archivo con el mismo nombre en el actual directorio", 401);
			}

			$oldName = $folder_parent_path . $oldFullNameFile. '/';
			$newName = $folder_parent_path . $name . '.' . $file->extension . '/';

			$oldName = public_path("storage/" . $oldName);
			$newName = public_path("storage/" . $newName);

			$file->name = $name;
			$file->fullname = $name . '.' . $file->extension;
			$renamedFile = $file->save();

			if($renamedFile){
				if( rename($oldName, $newName) ){
					return json_encode($file);
				}
			}
			$file->name = $oldNameFile;
			$file->fullname = $oldFullNameFile;
			$file->save();
			return response()->json("Error al tratar de renombrar el archivo", 401);
		}
		catch (\Exception $err) {
			$file->name = $oldNameFile;
			$file->fullname = $oldFullNameFile;
			$file->save();
			return response()->json($err, 401);
		}
	}
}
