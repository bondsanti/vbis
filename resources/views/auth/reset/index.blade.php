<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vBisConnect</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/vbeicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
      </svg>
  @include('sweetalert::alert')
    <div class="container">
      <br><br><br>
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">

            <div class="card border-0 shadow rounded-3 my-5">
              <div class="card-body p-4 p-sm-5">
                <img class="rounded mx-auto d-block" src="{{ url('uploads/vbe.png') }}" alt="" width="220">
                <h2 class="mt-6 mb-3 text-center font-extrabold text-danger">กรุณาสร้างรหัสผ่านใหม่</h2>
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                    รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร
                    </div>
                  </div>
                  <div class="alert alert-danger  d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                      รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก,พิมพ์ใหญ่,ตัวเลขและอักษรพิเศษอย่างละ 1 ตัว
                    </div>
                  </div>
                <form action="{{route('reset_create')}}" method="post">
                    @csrf
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" autocomplete="off"  value="{{old('password')}}">
                    <label for="password">รหัสผ่านใหม่*</label>
                    <small class="text-danger mt-1">@error('password'){{$message}} @enderror</small>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="confrimpassword" autocomplete="off"  value="{{old('confrimpassword')}}">
                    <label for="password">ยืนยันรหัสผ่านใหม่*</label>
                    <small class="text-danger mt-1">@error('confrimpassword'){{$message}} @enderror</small>
                  </div>


                  <div class="d-grid">
                    <button type="submit" class="btn btn-success mb-2">เปลี่ยนรหัสผ่าน</button>
                    <a href="{{url('/logout')}}" type="button" class="btn btn-warning">ยกเลิก</a>

                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
        <h6 class="text-center">Version {{config('app.appver')}}</h6>
      </div>
</body>
</html>

<style>
body {
  /* background: #007bff; */
  background: linear-gradient(to right,  #312e81, #4ade80);
}


.text-login{
  background-image: url('https://media.istockphoto.com/photos/technology-abstract-picture-id1148091793?k=20&m=1148091793&s=612x612&w=0&h=yunVTPC-vyrQ4VBCOrUYkYytQKtWM7zYj3KxsLwPHto=');
  background-repeat: repeat;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  /* margin-top: 200px; */
  /* font-size: 120px; */
  text-align: center;
  font-weight: bold;
  /* text-transform: uppercase; */
  font-family: 'Steelfish Rg', 'helvetica neue',
  helvetica, arial, sans-serif;
  font-weight: 800;
  -webkit-font-smoothing: antialiased;
}



</style>
