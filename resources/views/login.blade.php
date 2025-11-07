<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-center mb-4">CLIENT-ORDER TEST</h1>
                        <form action="{{ route('login.do') }}" method="POST">
                            @csrf

                            <!-- Error Functionality -->
                             @if ($errors->all())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                             @endif

                             <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                             </div>

                             <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                             </div>

                             <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">Log In</button>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-5sAR7xN1Nv6TI+12dEhgnFywxRIoH7joUqS9eG6RhmgWcAuLwwj5gRJuzpOM7K5Z" crossorigin="anonymous"></script>
</body>
</html>