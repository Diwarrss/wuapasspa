<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            Iniciar sesión con
        </div>
        <div class="card-body">
            <a href="{{ route('social_auth', ['driver'=> 'facebook']) }}" class="btn btn-primary">
                Facebook <i class="fab fa-facebook-square"></i>
            </a>
            <a href="{{ route('social_auth', ['driver'=> 'google']) }}" class="btn btn-danger">
                Google <i class="fab fa-google"></i>
            </a>
        </div>
    </div>
</div>
