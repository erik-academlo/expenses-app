@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Registro</h5>
                    <hr>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="/api/v1/register">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password-confirmation" class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                        </div>
                        <div class="text-center">
                            <span>
                                ¿Ya tienes cuenta? <a href="/auth/login">Inicia sesión</a>
                            </span>
                            <button type="submit" class="btn btn-primary d-block w-100 mt-2">Regístrarme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
