<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Auth;
use DB;
use Carbon\Carbon;
use App\Folder;
use App\File;
use App\User;

class AdminController extends Controller
{
    public function index()
    {

		$clients = User::where('estado', '1')
		->where('role', 'cliente')
		->get();

		// phpinfo(); exit;

		// $this->Export_Database('localhost', 'root', '', 'gestor_archivos', array('users'), false);

        return view('admin.index')->with('clients', $clients);
    }

	public function uploadFile(Request $request)
    {
		DB::beginTransaction();
        try {

			$file = $request->file('file');
			
			$file_fullName = $file->getClientOriginalName();

			$file_name = pathinfo($file_fullName, PATHINFO_FILENAME);
			$file_extension = pathinfo($file_fullName, PATHINFO_EXTENSION);

            $uploadFile = new File();

			$client_id = $request->get('client_id');
			$folder_id = $request->get('folder_id');

			$folder = Folder::find($folder_id);
			if(!$folder) $folder_parent_path = "";
			else $folder_parent_path = $folder->path;

			$duplicatedFile = Storage::disk('public')->exists($folder_parent_path . $file_fullName);

			if($duplicatedFile){
				return response()->json("Hay un archivo con el mismo nombre en el actual directorio", 401);
			}

            $insertedFileToBd = $uploadFile::create([
				'fullname' => $file_fullName,
				'name' => $file_name,
				'extension' => $file_extension,
				'folder_id' => $folder_id,
				'client_id' => $client_id,
				'inserted_by' => Auth::id()
			]);

            //verificamos si se registro a la base de datos
            if ( $insertedFileToBd )
            {
                if( $file->storeAs('public/' . $folder_parent_path, $file_fullName) ){
					DB::commit();
                    return response()->json("Archivo guardado, bd y físico"); 
                }
                else{
					DB::rollBack();
                    return response()->json("Error al guardar archivo físico", 401); 
                }
            }
            else
            {
				DB::rollBack();
                return response()->json("Error al guardar en bd", 401); 
            }
        } catch (\Exception $err) {
			DB::rollBack();
            // Log::error("Error al subir archivo." . $err->getMessage() );
            return response()->json("Error al subir archivo. Permiso al archivo denegado", 401); 
        }
	}

	public function deleteFile($id){
		try {
			$file = File::find($id);
			$folder = Folder::find($file->folder_id);

			if(!$file) return response()->json("Archivo no encontrado", 401); 

			$folder = Folder::find($file->folder_id);

			if(!$folder) return response()->json("Folder no encontrado", 401); 

			$fullpath = $folder->path . $file->fullname;
			$tempFilePath = public_path("storage/") . $fullpath;

			// unlink($tempFilePath);
			// Storage::delete("public/".$tempFilePath);
			Storage::disk('public')->delete($fullpath);
			
			File::destroy($id);

			return response()->json("ok-" . "-" . $tempFilePath); 
		} catch (\Exception $err) {
			return response()->json("Error al eliminar" .Storage::disk('public'), 401); 
		}
	}

    function Export_Database($host,$user,$pass,$name, $tables=false, $backup_name=false )
    {
        $mysqli = mysqli_connect($host,$user,$pass,$name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables = $mysqli->query('SHOW TABLES');
        while($row = $queryTables->fetch_row())
        {
            $target_tables[] = $row[0];
        }
        if($tables !== false)
        {
            $target_tables = array_intersect( $target_tables, $tables);
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);
            $fields_amount  =   $result->field_count;
            $rows_num=$mysqli->affected_rows;
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table);
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0)
            {
                while($row = $result->fetch_row())
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)
                    {
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ;
                        }
                        else
                        {
                            $content .= '""';
                        }
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num)
                    {
                        $content .= ";";
                    }
                    else
                    {
                        $content .= ",";
                    }
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        $date = date("Y-m-d");
        $backup_name = $backup_name ? $backup_name : $name.".$date.sql";
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");
        echo $content; exit;
    }
}
