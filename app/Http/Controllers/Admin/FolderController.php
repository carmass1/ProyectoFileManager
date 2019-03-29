<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Folder;
use App\File;
use Storage;
use Carbon\Carbon;
use DB;

class FolderController extends Controller
{
	// $parent = id folder parent
    public function createFolder($name, $parent){
		DB::beginTransaction();
		try {
			$name = trim($name);

			$parent_path = '';
			$path = $name . '/';

			if ($parent != 0) {
				$parent_path = Folder::find($parent)->path;
				$path = $parent_path . $name . '/';
			}

			$duplicatedFolder = Storage::disk('public')->exists($path);

			if($duplicatedFolder){
				return response()->json("La carpeta ya existe en el actual directorio", 401);
			}

			$createdFolder = Folder::create([
				'name' => $name,
				'parent_id' => $parent,
				'path' => $path,
				'last_update' => Carbon::now()->toDateTimeString()
			]);

			if( $createdFolder ){
				Storage::makeDirectory('public/' . $createdFolder->id . '__foobar__' . $path);

				if($createdFolder->parent_id == "0"){
					$createdFolder->name = $createdFolder->id . '__foobar__' . $createdFolder->name;
					$createdFolder->tree_id = $createdFolder->id;
					$createdFolder->save();
				}
				else{
					$parentFolder = Folder::find($createdFolder->parent_id);
					$createdFolder->name = $createdFolder->id . '__foobar__' . $createdFolder->name;
					$createdFolder->tree_id = $parentFolder->tree_id . ',' . $createdFolder->id;
					$createdFolder->save();
				}
			}

			$keys = $createdFolder->tree_id;
			$keys = explode(',', $keys);

			$list = array();

			foreach ($keys as $key) {
				$obj = new \stdClass;

				$folder = Folder::find($key);
				$obj->id = $key;
				$obj->value = $folder->name;
				array_push($list, $obj);
			}

			$json = $createdFolder->toJson();
			$json = json_decode($json);
			$json->parentNodes = json_encode($list);

			DB::commit();
			return response()->json($json);
		} catch (\Exception $err) {
			DB::rollBack();
			return response()->json($err, 401);
		}
	}

	public function renameFolder($name, $folder_id){
		DB::beginTransaction();
		try {
			$name = trim($name);
			$current_path = '';
			$folder = Folder::find($folder_id);

			$oldNameFolder = $folder->name;

			if(!$folder){
				return response()->json("Error al tratar de acceder a la carpeta a renombrar", 401);
			}

			if($folder->parent_id != 0){
				$parentFolder = Folder::find($folder->parent_id);
				$current_path = $parentFolder->path;
			}

			$duplicatedFolder = Storage::disk('public')->exists($current_path . $name);

			if($duplicatedFolder){
				return response()->json("La carpeta ya existe en el actual directorio" . $current_path, 401);
			}

			$oldName = $current_path . $folder->name . '/';
			$newName = $current_path . $name . '/';

			$oldName = public_path("storage/" . $oldName);
			$newName = public_path("storage/" . $newName);

			$folder->name = $name;
			
			$renamedFolder = $folder->save();

			if($renamedFolder){
				if( rename($oldName, $newNamea) ){
					DB::commit();
					return json_encode($folder);
				}
			}
			DB::rollBack();
			return response()->json("Error al tratar de renombrar la carpeta", 401);
		}
		catch (\Exception $err) {
			DB::rollBack();
			// return response()->json($err, 401);
			return response()->json("Error al renombrar carpeta", 401);
		}
	}

	public function deleteFolder($id){
		try {
			$folder = Folder::find($id);
	
			if( !$folder ){
				return response()->json("Error al tratar de acceder a la carpeta a eliminar", 401);
			}
			$path = public_path("storage/" . $folder->path);

			if ( self::deleteDir($path) == 'ok' ) {
				$folder->delete();
				return response()->json("Carpeta eliminada");
			}
			else{
				return response()->json(self::deleteDir($path), 401);
			}
		} catch (\Exception $err) {
			return response()->json("t/c Error al eliminar carpeta" . $err, 401);
		}
	}

	public static function deleteDir($dirPath) {
		try {
			if ( !is_dir($dirPath) ) {
				return "error isdir path";
			}
			if ( substr($dirPath, strlen($dirPath) - 1, 1) != '/' ) {
				$dirPath .= '/';
			}
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if ( is_dir($file) ) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($dirPath);
			return "ok";
		} catch (\Exception $err) {
			return $err;
		}
	}

	public static function renameFoldersPaths(){
		try {
			if ( !is_dir($dirPath) ) {
				return "error isdir path";
			}
			if ( substr($dirPath, strlen($dirPath) - 1, 1) != '/' ) {
				$dirPath .= '/';
			}
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($dirPath);
			return "ok";
		} catch (\Exception $err) {
			return $err;
		}
	}

	public function listFolders($id)
    {
		$data = Folder::where('parent_id', $id)->get();
		
		$data->map(function ($item, $key) {

			$keys = $item->tree_id;
			$keys = explode(',', $keys);

			$list = array();

			foreach ($keys as $key) {
				$obj = new \stdClass;

				$folder = Folder::find($key);
				$obj->id = $key;
				$obj->value = $folder->name;
				array_push($list, $obj);
			}
			return $item->parentNodes = json_encode($list);
		});

		return $data->toJson();
    }
}