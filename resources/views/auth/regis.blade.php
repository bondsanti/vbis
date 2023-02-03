<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
  @include('sweetalert::alert')
    <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card border-0 shadow rounded-3 my-5">
              <div class="card-body p-4 p-sm-5">

                <h2 class="mt-6 mb-3 text-center font-extrabold">Register</h2>
                <form action="{{route('insertRegister')}}" method="post">
                    @if (Session::has('สำเร็จ'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            {{Session::get('สำเร็จ')}}
                        </div>
                      </div>
                      @endif
                      @if (Session::has('ล้มเหลว'))
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                          {{Session::get('ล้มเหลว')}}
                        </div>
                      </div>
                    @endif
                    @csrf
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="code" autocomplete="off">
                    <label for="code">Code</label>
                    <small class="text-danger mt-1">@error('code'){{$message}} @enderror</small>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="fullname" autocomplete="off">
                    <label for="code">Full Name</label>
                    <small class="text-danger mt-1">@error('fullname'){{$message}} @enderror</small>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" autocomplete="off">
                    <label for="password">Password</label>
                    <small class="text-danger mt-1">@error('password'){{$message}} @enderror</small>

                  </div>


                  <div class="d-grid">
                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">สมัคร</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>

<style>
body {
  background: #007bff;
  background: linear-gradient(to right, #312e81, #4ade80);
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}

.btn-google {
  color: white !important;
  background-color: #ea4335;
}

.btn-facebook {
  color: white !important;
  background-color: #3b5998;
}

</style>
