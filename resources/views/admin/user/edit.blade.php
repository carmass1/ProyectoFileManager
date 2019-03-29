@extends('admin.layouts.master')
@section('page','Editar Usuario')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					{{ __('Editar Usuario') }}
					<a href="{{ route('admin.user.index') }}" class="float-right btn btn-primary btn-xs">Atras</a>
				</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.user.update', $user->id) }}" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name')??$user->name }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email')??$user->email }}" required>
                            </div>
						</div>
						
						<div class="form-group row">
							<label for="role" class="col-md-4 col-form-label text-md-right">Rol</label>
							<!-- <input type="text" name="role" value="admin"> -->
							<div class="col-md-6">
								<select name="role" class="form-control">
									<option value="super" {{ $user->role=='super'?'selected':'' }}>Super</option>
									<option value="admin" {{ $user->role=='admin'?'selected':'' }}>Administrador</option>
								</select> 
							</div>
						</div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Actualizar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection