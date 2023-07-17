<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ตั้งรหัสผ่านใหม่</title>
</head>
<body>
    <h2>สวัสดี คุณ{{$users->name_th}} </h2>
    <h4>คุณได้ขอรีเซ็ตรหัสผ่านของคุณจากระบบ Vbis</h4>
    <h4>หากคุณต้องการรีเซ็ตรหัสผ่าน โปรดคลิ๊กลิงค์ด้านล่างเพื่อตั้งค่ารหัสผ่านใหม่</h4>
    <h2><a href="{{$resetLink}}">ตั้งรหัสผ่านใหม่</a></h2>

</body>
</html>
