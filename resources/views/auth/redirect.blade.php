<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VBNext Login {{ env('APP_VERSION') }} </title>

    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }

        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }



        .microsoft-gradient {
            background: linear-gradient(90deg, #0078D4 0%, #00397A 100%);
        }

        .my-event {
            cursor: pointer;
        }

        .click {
            cursor: pointer;
        }
    </style>
        <script language=JavaScript>
              function clickIE() {if (document.all) {alert(message);return false;}}
              function clickNS(e) {if
              (document.layers||(document.getElementById&&!document.all)) {
              if (e.which==2||e.which==3) {alert(message);return false;}}}
              if (document.layers)
              {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
              else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
              document.oncontextmenu=new Function("return false")
        </script>

</head>

<body class="gradient">

    @include('sweetalert::alert')
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-xl mx-auto mt-10">





        <!-- Repeat for other menu items -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Version {{ env('APP_VERSION') }}
        </p>
    </div>

    <br><br>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    window.onload = function() {
        window.open('{{ $url }}', '_blank', 'noopener,noreferrer');
        window.location.href = '{{ $url }}'; // Redirect current window as well
    }
</script>
