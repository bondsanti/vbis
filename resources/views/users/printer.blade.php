<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VBNext Login {{ env('APP_VERSION') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;600&display=swap" rel="stylesheet">
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }

        .inline-block {
            display: inline-block;
        }

        .gradient {
            background: linear-gradient(90deg, rgb(2, 182, 104) 0%, rgb(1, 111, 65) 100%);
        }

        .microsoft-gradient {
            background: linear-gradient(90deg, #0078D4 0%, #00397A 100%);
        }

        .sup-role {
            cursor: pointer;
        }

        .swal2-container .swal2-popup .swal2-html-container {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        .swal2-container .swal2-popup .swal2-html-container input,
        .swal2-container .swal2-popup .swal2-html-container select {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>


<body class="gradient">




    <div class="container mx-auto py-4">
        <button onclick="window.print()" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Print</button>
        <h1 class="text-2xl font-bold mb-4">User Data</h1>


        {{-- {{$groupedUsers}} --}}
        @foreach ($groupedUsers as $departmentId => $departmentData)
            <h2 class="text-xl font-bold mt-4">Department: {{ $departmentData['department_name'] }}</h2>
            <table class="min-w-full bg-white text-center">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Code</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Role</th>
                        <th class="py-2 px-4 border-b">Active</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                {{-- {{$departmentData['users']}} --}}
                <tbody>
                    @foreach ($departmentData['users'] as $user)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $user->code }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            {{-- <td class="py-2 px-4 border-b">{{ $user->role_report_ref->level }}</td> --}}
                            <td class="py-2 px-4 border-b"></td>
                            <td class="py-2 px-4 border-b">{{ $user->active }}</td>
                            <!-- Add more columns as needed -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach



    </div>







</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
