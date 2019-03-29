
@extends('admin.layouts.master')

@section('combo')
	<label for="">Selec. Estación</label>
	<Select class="custom-select col-md-5" id="select-client">
		<option disabled selected value="nul">Selecciona</option>
		@foreach($clients as $client)
			<option value="{{ $client->name }}|{{ $client->id }}">{{ $client->name }}</option>
		@endforeach
	</Select>
@endsection

@section('page','Documentos')

@section('content')

	{{-- Click derecho --}}
	<ul class="contextMenu right-click-file-menu" style="display: none;">
		@if(Auth::user()->role == 'super')
			<li><a href="#" class="rename_file"><i class="fa fa-edit text-primary"></i> Renombrar</a></li>
		@endif
		<li><a href="#" class="view" target="_blank"><i class="fa fa-eye text-success"></i> Ver</a></li>
		<li><a href="#" download class="download"><i class="fa fa-download text-primary"></i> Descargar</a></li>
		@if(Auth::user()->role == 'super')
			<li><a href="#" class="delete_file"><i class="fa fa-trash text-danger"></i> Eiminar</a></li>
		@endif
	</ul>

	<ul class="contextMenu right-click-folder-menu" style="display: none;">
		<li><a href="#" class="rename"><i class="fa fa-edit text-primary"></i> Renombrar</a></li>
		@if(Auth::user()->role == 'super')
			<li><a href="#" class="delete"><i class="fa fa-trash text-danger"></i> Eiminar</a></li>
		@endif
	</ul>
	{{-- //Click derecho --}}

	<div class="container">
		<div class="row">
			<div class="col-md-12  ">
				<h1 id="estac_selected">NOMBRE ESTACION SELECCIONADA</h1>
				<div class="nav-container" style="position:relative;">
					{{-- Ruta de carpetas que se deben mostrar --}}
					<ol class="breadcrumb" id="folders_nodes">
						<li class="breadcrumb-item active" onclick="goToRootDirectory()">
							<a href="#"><b>Categorías / </b></a>
						</li>
						<!-- <li class="breadcrumb-item">
							<a href="#"><b>GESTION AMBIENTAL</b></a>
						</li>
						<li class="breadcrumb-item active">Informe de Monitoreo</li> -->
					</ol>
				</div>

				<style>
					.dropzone .dz-preview .dz-image img {
						margin: auto;   /* center the image inside the thumbnail */
					}
					.dropzone .dz-preview .dz-error-message {
						top: 150px;     /* move the tooltip below the "Remove" link */
					}
					.dropzone .dz-preview .dz-error-message:after {
						left: 30px;     /* move the tooltip's arrow to the left of the "Remove" link */
						top: -18px;
						border-bottom-width: 18px;
					}
					.dropzone .dz-preview .dz-remove {
						margin-top: 4px;
						font-size: 11px;
						text-transform: uppercase;
					}

					.btn-group-xs > .btn, .btn-xs {
						padding: .25rem .4rem;
						font-size: .875rem;
						line-height: .5;
						border-radius: .2rem;
					}

					.dropzone .dz-preview .dz-remove{
						position: absolute;
						width: 70px;
						z-index: 50;
						left: 30px;
						margin-top: 0;
					}
				</style>

				{{-- FOLDERES --}}
				<main>
					<form action="{{ route('admin.uploadfile') }}" class="dropzone" id='dropzone' method="POST"
						enctype="multipart/form-data" class="form-control">
						@csrf
						<input type="hidden" id="input_estacion" name="client_id" value="0">
						<input type="hidden" id="folder_id" name="folder_id" value="0">

						<h4 style="margin-left: 40px; font-weight:bold">Carpetas</h4>
						<div class="grid-container container-draggables" ondrop="drop(event)" ondragover="allowDrop(event)" style="margin-bottom: 26px" id="grid_containter_folder"></div>

						<h4 style="margin-left: 40px; font-weight:bold">Archivos</h4>
						<div class="grid-container container-draggables" ondrop="drop(event)" ondragover="allowDrop(event)" style="margin-bottom: 26px" id="grid_containter_file"></div>
					</form>
					<div id="here"></div>
				</main>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>


		function allowDrop(ev) {
			ev.preventDefault();
		}
		function drag(ev) {
			ev.dataTransfer.setData("text", ev.target.id);
		}
		function drop(ev) {
			ev.preventDefault()
			if($(ev.target).attr("class").includes("container-draggables")){
				var data = ev.dataTransfer.getData("text");
				ev.target.appendChild(document.getElementById(data));
			}
		}
	</script>

	<script src="{{ asset('js/contextmenu.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {

			displayToDropzone(CURRENT_FOLDER)

			//  SCRIPT PARA SUBIR ARCHIVOS
			const opts = {
				dictDefaultMessage: " ",
				maxFilesize: 2500000,
				addRemoveLinks: true,
				// clickable: false,
				dictRemoveFile : "Limpiar",
				timeout : 0,
				// autoQueue: false,
				// acceptedFiles: ".jpg",
				init: function () {
					this.on("complete", file => {

						var _this = this;

						if (file.status == "success") {
							_this.removeFile(file);

							Swal.fire(
								'Agregado!',
								'Se ha subido el archivo.',
								'success'
							).then( result => {
								displayToDropzone(CURRENT_FOLDER);
							})
						}
					});

					this.on('addedfile', function (file) {
						if ($("#input_estacion").val() == "0") {
							Swal.fire(
								'Advertencia!',
								'Seleccionar una estación antes de subir un archivo.',
								'warning'
							)
							this.removeFile(file);
						}
						if ( CURRENT_FOLDER == 0) {
							Swal.fire(
								'Advertencia!',
								'Crear una carpeta o ingresar a una',
								'warning'
							)
							this.removeFile(file);
						}
					});

					this.on('error', function (file, response) {

						if (response == "Upload canceled.") return

						// $(file.previewElement).find('.dz-filename')

						$(file.previewElement).find('.dz-remove').addClass("btn btn-danger mx-auto")

						// $(file.previewElement).find('.dz-success-mark').remove()
						// $(file.previewElement).find('.dz-error-mark').remove()
						$(file.previewElement).find('.dz-filename').attr("style", "white-space:inherit; word-break: break-all;")

						Swal.fire(
							'error!',
							'No Se ha subido el archivo. ' + response,
							'error'
						)
						// this.removeFile(file);
					})
				},
			}

			var myDropzone = new Dropzone("#dropzone", opts);
			// $(".dz-hidden-input").prop("disabled",true); //diabled all functions
		});

		
	</script>
@endsection