<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vBisConnect</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/vbeicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</head>

<body>
    @include('sweetalert::alert')
    <div class="container">
        <div class="row">

            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <img class="rounded mx-auto d-block" src="{{ asset('/uploads/vbe.png') }}" alt=""
                            width="280">
                        <br>
                        <form action="{{ route('loginUser') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="code" autocomplete="off">
                                <label for="code">Code</label>
                                <small class="text-danger mt-1">
                                    @error('code')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" autocomplete="off">
                                <label for="password">Password</label>
                                <small class="text-danger mt-1">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </small>
                                @if ($errors->has('password'))
                                    <br>
                                @endif
                                <a href="{{ route('forget.form') }}" style="text-decoration: none;"><small
                                        class="text-info mt-1">ลืมรหัสผ่าน?</a></small>
                            </div>


                            <div class="d-grid">
                                <button class="btn btn-login btn-rounded fw-bold"
                                    type="submit">เข้าสู่ระบบ</button>
                                    {{-- <hr> --}}
                            </div>
                            {{-- <div class="d-grid">
                                <button class="btn btn-login btn-rounded fw-bold"
                                    type="submit">Login with Microsoft</button>
                            </div> --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h6 class="text-center mt-n3">Version 1.0.4</h6>
    </div>
</body>

</html>

<style>
    body {
        background: linear-gradient(to right, #00416A, #E4E5E6);
        background: -webkit-linear-gradient(to right, #00416A, #E4E5E6);
        /* Chrome 10-25, Safari 5.1-6 */
    }

    .btn-login {
        background: #00416A;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #00416A, #00416A);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #00416A, #00416A);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,
    Safari 7+ */
        color: #fff;
        /* border: 3px solid #eee; */
    }

    .btn-rounded {
        border-radius: 35px;
    }
</style>
