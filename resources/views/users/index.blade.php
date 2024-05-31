<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VBNext Login 2.0 </title>

    <link rel="icon" type="image/x-icon" href="{{ url('uploads/logo/vbeicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Loopple/loopple-public-assets@main/riva-dashboard-tailwind/riva-dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
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

    </style>
</head>


<body class="gradient">

    @include('sweetalert::alert')

    <!-- component -->

<div class="flex flex-wrap -mx-3 mb-5">
  <div class="w-full max-w-full px-3 mb-6  mx-auto">
    <div class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
      <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
        <!-- card header -->
        <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
          <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
            <span class="mr-3 font-semibold text-dark">ผู้ใช้งานระบบ</span>
            <span class="mt-1 font-medium text-secondary-dark text-lg/normal">*ระบบไม่ได้เชื่อมต่อกับระบบ HR</span>
          </h3>
          <form method="GET" action="{{ route('users') }}">
          <div class="relative flex flex-wrap items-center my-2">
            <input type="text" name="code" id="code" class="mr-2" placeholder="code">
            <input type="text" name="email" id="email" class="mr-2" placeholder="email">
            <button class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-light focus:bg-light"> ค้นหา </button>
          </div>
        </form>
          <div class="relative flex flex-wrap items-center my-2">

            <a href="javascript:void(0)" class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-green focus:bg-light"> เพิ่มผู้ใช้งานระบบ </a>
          </div>
        </div>
        <!-- end card header -->
        <!-- card body  -->
        <div class="flex-auto block py-8 pt-6 px-9">
          <div class="overflow-x-auto">
            <table class="w-full my-0 align-middle text-dark border-neutral-200">
              <thead class="align-bottom">
                <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                  <th class="pb-3 text-start min-w-[175px]">Email</th>

                  <th class="pb-3 text-end min-w-[100px]">Report</th>
                  <th class="pb-3 text-end min-w-[100px]">Stock</th>
                  <th class="pb-3 text-end min-w-[100px]">Assets</th>
                  <th class="pb-3 text-end min-w-[100px]">VBLead</th>
                  <th class="pb-3 text-end min-w-[100px]">Agent</th>
                  <th class="pb-3 text-end min-w-[100px]">Project</th>
                  <th class="pb-3 text-end min-w-[100px]">Printer</th>
                  <th class="pb-3 text-end min-w-[100px]">BrokerCons.</th>
                  <th class="pb-3 text-end min-w-[100px]">Rental</th>
                  <th class="pb-3 text-end min-w-[100px]">AdminVbis</th>
                  <th class="pb-3 text-end min-w-[100px]">สถานะผู้ใช้งาน</th>
                  <th class="pb-3 text-end min-w-[50px]">DETAILS</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user )


                <tr class="border-b border-dashed last:border-b-0">
                  <td class="p-3 pl-0">
                    <div class="flex items-center">
                      <div class="relative inline-block shrink-0 rounded-2xl me-3">
                        <img src="{{ url('uploads/logo/logo_gold.png') }}" class="w-[50px] h-[50px] inline-block shrink-0 rounded-2xl" alt="">
                      </div>
                      <div class="flex flex-col justify-start">
                        <span class="text-center align-baseline inline-flex px-4 py-3 mr-auto items-center font-semibold text-[.95rem] leading-none text-primary bg-primary-light rounded-lg"> {{ $user->code}} </span>
                        <span  class="mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary"> {{ $user->email}} </span>
                      </div>
                    </div>
                  </td>
                  <td class="pb-3 pr-0  text-end">

                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_report == 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600"
                  >
                   User
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->low_rise == 1 || $user->high_rise == 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600"
                  >
                   SuperAdmin
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_vbasset == 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-yellow-50 px-2 py-1 text-xs font-semibold text-yellow-600"
                  >
                   Admin
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_vblead== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600"
                  >
                   Null
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_agent== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600"
                  >
                   Null
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_vproject== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600"
                  >
                   Null
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_printer== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600"
                  >
                   Null
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_broker== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600"
                  >
                   Null
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_rental== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                    <p
                    class=" items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600"
                  >
                   Null
                </p>
                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active_vbis== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>

                  </td>
                  <td class="pb-3 pr-0 text-end">
                    <label class="inline-flex items-center cursor-pointer mt-4">
                        <input type="checkbox" value="" class="sr-only peer" {{ $user->active== 1 ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>

                    </label>
                  </td>


                  <td class="pb-3 pr-0 text-end">
                    <button class="ml-auto relative text-secondary-dark bg-light-dark hover:text-primary flex items-center h-[25px] w-[25px] text-base font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-200 ease-in-out shadow-none border-0 justify-center">
                      <span class="flex items-center justify-center p-0 m-0 leading-none shrink-0 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                      </span>
                    </button>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
          <div class="mt-4">
            {{ $users->links() }}
        </div>
        </div>
      </div>
    </div>
  </div>
</div>


    <p class="text-center text-sm text-white-500 mt-6">
        VBNext Version 2.0
    </p>



</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
