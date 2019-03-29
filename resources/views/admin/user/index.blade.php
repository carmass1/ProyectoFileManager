@extends('admin.layouts.master')

@section('page','Lista de Usuarios')

@section('content')
<nav></nav>
<div class="container">
    <div class="row">
        <div class="col-md-10  offset-md-1 bg-white">
            <div class="card-header">
				<H2>LISTA DE USUARIOS</H2>
            </div>
            
            <div class="card-body">
				<div class="col-md-10 mb-3">
					<a class="btn btn-outline-success" href=" {{ route('admin.user.create') }} ">
						<i class="fa fa-plus-circle"></i>Agregar un Usuario
					</a>
				</div>
				<table class="table" id="datatable-users">
					<thead>
						<tr>
							<th scope="col">Nombre</th>
							<th scope="col">Correo</th>
							<th scope="col">Rol</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($users as $user)
						<tr>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->role }}</td>
							<td>
								<a class="btn btn-primary btn-sm" href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-edit"></i></a>
								<button class="btn btn-danger btn-sm delete" data-id="{{ $user->id }}"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">

	$('#datatable-users').on("click", ".delete", function (e) {

		var id = $(this).data("id");

		Swal.fire({
			title: 'Estas seguro?',
			text: "El cliente sera eliminado!",
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
					url: `user/${id}/delete`,
					data: {
						_method: 'POST',
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST'
				}).done(function (r){
					console.log(r)
					Swal.fire(
						'Eliminado!',
						'Cliente eliminado correctamente.',
						'success'
					).then( result => {
						window.location.href=""	
					})
				}).fail(function (xhr) {
					Swal.fire(
						'Ocurrio un error!',
						xhr.responseJSON,
						'error'
					).then( result => {
						window.location.href=""	
					})
				});
			}
		})
	});
</script>
@endsection
