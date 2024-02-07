<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ตั้งค่ารหัสผ่านใหม่</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
        }
        .header {
            background-color: #5558AF; /* Dark blue color */
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .footer {
            background-color: #f55d5d; /* Dark blue color */
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .button {
            background-color: #5558AF; /* Dark blue color */
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #40447a; /* A slightly darker blue */
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            คุณได้ขอรีเซ็ตรหัสผ่านของคุณจากระบบ VBIS
        </div>
        <div class="content">
            <h2>สวัสดี!! คุณ {{$users->name_th}} </h2>
            <h4>หากคุณต้องการรีเซ็ตรหัสผ่าน โปรดคลิ๊กลิงค์ด้านล่างเพื่อตั้งค่ารหัสผ่านใหม่</h4>
            <h3><a href="{{$resetLink}}" >ตั้งรหัสผ่านใหม่</a></h3>
        </div>

    </div>
</body>
</html>
