
@extends('client.layouts.master')

@section('page','Documentos')

@section('content')

	{{-- Click derecho --}}
	<ul class="contextMenu" style="display: none;">
		<li><a href="#" class="view" target="_blank"><i class="fa fa-eye text-success"></i> Ver</a></li>
		<li><a href="#" download class="download"><i class="fa fa-download text-primary"></i> Descargar</a></li>
	</ul>
	{{-- //Click derecho --}}

	<div class="container">
		<div class="row">
			<div class="col-md-12  ">
				<h1 id="estac_selected">{{ Auth::User()->name }}</h1>
				<div class="nav-container" style="position:relative;">
					{{-- Ruta de carpetas que se deben mostrar --}}
					<ol class="breadcrumb" id="folders_nodes">
						<!-- <li class="breadcrumb-item">
							<a href="#"><b>GESTION AMBIENTAL</b></a>
						</li>
						<li class="breadcrumb-item active">Informe de Monitoreo</li> -->
					</ol>
				</div>

				{{-- FOLDERES --}}
				<main>
					<form action="{{ route('admin.uploadfile') }}" class="dropzone" id='dropzone' method="POST"
						enctype="multipart/form-data" class="form-control">
						@csrf
						<input type="hidden" id="input_estacion" name="client_id" value="0">
						<input type="hidden" id="folder_id" name="folder_id" value="0">

						<h4 style="margin-left: 40px; font-weight:bold">Carpetas</h4>
						<div class="grid-container" style="margin-bottom: 26px" id="grid_containter_folder"></div>

						<h4 style="margin-left: 40px; font-weight:bold">Archivos</h4>
						<div class="grid-container" style="margin-bottom: 26px" id="grid_containter_file"></div>
					</form>
				</main>
			</div>
		</div>
	</div>
@endsection


@section('scripts')
	<script src="{{ asset('js/contextmenu.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			displayToDropzone(CURRENT_FOLDER)
		});
	</script>
@endsection