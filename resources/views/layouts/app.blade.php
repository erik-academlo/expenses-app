<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>{{ env('APP_NAME') }}</title>
    <style>
        body {
            background-color: #eff6fe;
        }
    </style>
</head>
<body>
@auth()
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/expenses">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/expenses">Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/stats">Estadísticas</a>
                </li>
            </ul>
            <form action="/api/v1/logout" method="post">
                @csrf
                <button class="btn btn-outline-success" type="submit">Log out</button>
            </form>
        </div>
    </div>
</nav>
@endauth
<div class="container mt-5">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    axios.get('/sanctum/csrf-cookie')
        .then(response => {
            console.log(response.data);
        }).catch(() => {
            alert('No pudimos iniciar la sesión');
        });
</script>
@yield('script')
</body>
</html>
