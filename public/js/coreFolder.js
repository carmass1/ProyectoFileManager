
function newFolder() {
	Swal.fire({
		title: 'Crear Carpeta',
		input: 'text',
		inputPlaceholder: 'Nombre de carpeta',
		confirmButtonColor: '#3085d6',
		showCancelButton: true,
		confirmButtonText: 'Crear'
	}).then( result => {
		if (result.value!="" && !result.dismiss) {
			$.ajax({
				url: `newfolder/${result.value}/${CURRENT_FOLDER}`,
				data: {
					_method: 'POST',
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST'
			}).done(function (resp) {
				
				// const Toast = Swal.mixin({
				// 	toast: true,
				// 	position: 'top',
				// 	showConfirmButton: false,
				// 	timer: 3000
				// });
				
				// Toast.fire({
				// 	type: 'success',
				// 	title: 'Carpeta creada'
				// })
				// console.log(Toast)
				// addFolderToTree(resp)
				// displayFolderToDropzone()

				Swal.fire(
					'Carpeta creada',
					'',
					'success'
				).then( result => {
					addFolderToTree(resp)
					displayFolderToDropzone()
				})
				
			}).fail(function (err) {

				Swal.fire(
					'Ocurrio un error!',
					err.responseJSON,
					'error'
				)
			});
		}
	})
}

function deleteFolder(folder_id){

	Swal.fire({
		title: 'Estas seguro?',
		text: "La carpeta y todo su contenido serán eliminados!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, borralo!'
	}).then((result) => {
		if (result.value) 
		{
			$.ajax(
			{
				url: `deletefolder/${folder_id}`,
				data: {
					_method: 'POST',
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST'
			}).done(function (r){
				Swal.fire(
					'Eliminado!',
					'Carpeta y todo su contenido se han eliminado',
					'success'
				).then( result => {
					// window.location.href=""	
					$("#" + folder_id).remove()
					$("#folder_" + folder_id).remove()
				})
			}).fail(function (xhr) {
				console.log(xhr)
				Swal.fire(
					'Ocurrio un error!',
					'Error al intentar borrar la carpeta.',
					'error'
				).then( result => {
					// window.location.href=""	
				})
			});
		}
	})
}

function renameFolder(currentName, folder_id) {
	Swal.fire({
		title: 'Renombrar Carpeta',
		input: 'text',
		inputValue: currentName,
		inputPlaceholder: 'Nombre de carpeta',
		confirmButtonColor: '#3085d6',
		showCancelButton: true,
		confirmButtonText: 'Renombrar'
	}).then( result => {
		if (result.value!="" && !result.dismiss) {
			$.ajax({
				url: `renamefolder/${result.value}/${folder_id}`,
				data: {
					_method: 'POST',
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST'
			}).done(function (resp) {
				resp = JSON.parse(resp)
				Swal.fire(
					'Carpeta renombrada',
					'',
					'success'
				).then( result => {
					displayToDropzone(CURRENT_FOLDER)
					$(`#folder_` + resp.id).find("a").text(resp.name)
				})
				
			}).fail(function (err) {
				Swal.fire(
					'Ocurrio un error!',
					err.responseJSON,
					'error'
				)
			});
		}
	})
}


// FILES

function deleteFile(file_id){
	Swal.fire({
		title: 'No se podrá revertir',
		text: "Esta seguro de eliminar el archivo?",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, borralo!'
	}).then((result) => {
		if (result.value) 
		{
			$.ajax({
				url: `deletefile/${file_id}`,
				data: {
					_method: 'POST',
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST'
			}).done(function (resp) {
				Swal.fire(
					'Eliminado correctamente!',
					'',
					'success'
				).then( result => {
					displayToDropzone(CURRENT_FOLDER);
				})
			}).fail(function (err) {
				Swal.fire(
					'Ocurrio un error!',
					'',
					'error'
				).then( result => {
					window.location.href=""	
				})
			});
		}
	})
}

function renameFile(currentName, folder_id) {
	Swal.fire({
		title: 'Renombrar Archivo',
		input: 'text',
		inputValue: currentName,
		inputPlaceholder: 'Nombre de Archivo',
		confirmButtonColor: '#3085d6',
		showCancelButton: true,
		confirmButtonText: 'Renombrar'
	}).then( result => {
		if (result.value!="" && !result.dismiss) {
			$.ajax({
				url: `renamefile/${result.value}/${folder_id}`,
				data: {
					_method: 'POST',
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				type:'POST'
			}).done(function (resp) {
				Swal.fire(
					'Archivo renombrado',
					'',
					'success'
				).then( result => {
					displayToDropzone(CURRENT_FOLDER)
				})
				
			}).fail(function (err) {
				Swal.fire(
					'Ocurrio un error!' + err,
					err.responseJSON,
					'error'
				)
			});
		}
	})
}