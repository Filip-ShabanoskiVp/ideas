@extends("leyout.leyout")
@section("title",'Login')

@section("content")
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6">
            <form class="form mt-5" action="{{route('login')}}" method="post">
                @csrf
                <h3 class="text-center text-dark">Login</h3>
                <div class="form-group">
                    <label for="email" class="text-dark">Email:</label><br>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                @error("email")
                    <span class="d-block fs-6 text-danger mt-2"> {{ $message }} </span>
                 @enderror
                <div class="form-group mt-3">
                    <label for="password" class="text-dark">Password:</label><br>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                @error("password")
                <span class="d-block fs-6 text-danger mt-2"> {{ $message }} </span>
                @enderror
                <div class="form-group">
                    <label for="remember-me" class="text-dark"></label><br>
                    <input type="submit" name="submit" class="btn btn-dark btn-md" value="submit">
                </div>
                <div class="text-right mt-2">
                    <a href="/register" class="text-dark">Register here</a>
                </div>
            </form>
            <form action="{{ route('login.github') }}" method="POST" class="text-center">
                @csrf
                <button class="btn btn-primary"><img style="width: 25px"
                    src="https://static-00.iconduck.com/assets.00/github-icon-2048x1988-jzvzcf2t.png" /> Login with Github</button>
           </form>
           <form action="{{ route('login.google') }}" method="POST" class="text-center mt-2">
            @csrf
            <button class="btn btn-secondary"><img style="width: 25px"
            src="https://w7.pngwing.com/pngs/249/19/png-transparent-google-logo-g-suite-google-guava-google-plus-company-text-logo.png" />
            Login with Google</button>
       </form>
        </div>
    </div>
@endsection
