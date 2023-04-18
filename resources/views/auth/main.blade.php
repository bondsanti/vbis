<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Main Menu</title>
  <link rel="icon" type="image/x-icon" href="{{ url('uploads/vbeicon.ico') }}">


  <script src="https://cdn.tailwindcss.com"></script>


  <style>
    .my-event {
    cursor: pointer;
    }
  </style>
  <script language=JavaScript>


//   function clickIE() {if (document.all) {alert(message);return false;}}
//   function clickNS(e) {if
//   (document.layers||(document.getElementById&&!document.all)) {
//   if (e.which==2||e.which==3) {alert(message);return false;}}}
//   if (document.layers)
//   {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
//   else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
//   document.oncontextmenu=new Function("return false")


  </script>
</head>

<body>

  @include('sweetalert::alert')


  <div class="row gutters-sm">

    <!-- component -->
    <div class="relative max-w-md mx-auto
      md:max-w-2xl
      min-w-0
      break-words
      bg-white
      w-full
      mb-6
      shadow-lg
      rounded-xl
      mt-16
    ">
    @php
    $remoteFile = "https://hr.vbeyond.co.th/imageUser/employee/{$data->img_check}";

    // Initialize cURL
    $ch = curl_init($remoteFile);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check the response code
    // if($responseCode == 200){
    // echo 'File exists';
    // }else{
    // echo 'File not found';
    // }
    @endphp
      <div class="flex flex-col items-center pb-5">
        @if($responseCode != 200)
        {{-- @php echo file_exists(`https://hr.vbeyond.co.th/imageUser/employee/{{$data->img_check}}`) @endphp --}}
        <img class="mb-3 w-24 h-24 rounded-full shadow-lg mt-8" src="https://hr.vbeyond.co.th/imageUser/noImage.jpg"
          alt="" />
        @else
        <div class="mb-3 rounded-full shadow-lg mt-8" style="background-image: url('https://hr.vbeyond.co.th/imageUser/employee/{{$data->img_check}}'); background-size: cover; width: 150px; height: 150px;"></div>

            {{-- <img class="mb-3 w-24 h-24 rounded-full shadow-lg mt-8" src="https://hr.vbeyond.co.th/imageUser/employee/{{$data->img_check}}"> --}}
        @endif
        <h5 class="mb-1 text-base font-semibold text-gray-900 lg:text-xl dark:text-white">{{$data->name_th}}</h5>


        {{-- <span class="text-sm text-gray-500 dark:text-gray-400 mt-2">แผนก {{$data->department_ref->name}}</span>
        --}}
        <span class="text-sm text-gray-500 dark:text-gray-400">{{($data->position_ref->name)? $data->position_ref->name:""}}</span>
        {{-- <span
          class="font-medium bg-blue-100 text-blue-800 mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{$data->position_ref->name}}</span>
        --}}
        <div class="flex mt-4 space-x-3 lg:mt-6">
          {{-- <button
            class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ข้อมูลส่วนตัว</button> --}}
          <a href="{{route('logoutUser')}}"
            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">ออกจากระบบ</a>
        </div>
      </div>

      <div class="p-6">
        <h5 class="mb-2 text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
            สิทธิ์เข้าใช้งานระบบ<span
            class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-gray-900 bg-green-200 rounded dark:bg-green-700 dark:text-gray-400">มีสิทธิ์เข้าระบบได้</span>
          <span
            class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-gray-900 bg-red-200 rounded dark:bg-red-700 dark:text-gray-400">ไม่มีสิทธิ์เข้าระบบ</span>
        </h5>
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">ติดต่อแผนก IT หากต้องการเข้าใช้งานระบบ
            <b class="text-red-500">โหลดฟอร์ม : </b>
          <a href="{{ url('uploads/form-it-02-email.pdf') }}" target="_blank"
            class="inline-flex items-center justify-center px-2 py-0.5 ml-1 text-xs font-medium text-gray-900 bg-orange-200 rounded dark:bg-orange-700 dark:text-gray-400">
            ฟอร์มขอสิทธิ์/Email</a>
            <a href="{{ url('uploads/form-it-05-Internet.pdf') }}" target="_blank"
            class="inline-flex items-center justify-center px-2 py-0.5 ml-1 text-xs font-medium text-gray-900 bg-orange-200 rounded dark:bg-orange-700 dark:text-gray-400">
            ฟอร์มขอใช้งาน Internet</a>
        </p>
        <ul class="my-4 space-y-3">
          <li onclick="window.open(`{{config('app.url2')}}?token={{$data->token}}&aOpmIGGnsdhj_R88qlFJMn_ajam9977ADmndMLKjgs&id={{session()->get('loginId')}}`, '_blank')" class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
          hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ HR</span>
            {{-- <span
              class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-emerald-900 bg-emerald-500 rounded dark:bg-emerald-900 dark:text-emerald-900">Connected</span> --}}
          </li>

          @if($data->active_report==1)
          <li onclick="window.open(`{{config('app.url3')}}?WAdk_ask7821djYYsadcqqpdf_)atooyjnnZ5654xzA&user={{$data->code}}&token={{$data->token}}&act=loginconect&r=1`, '_blank')"
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
          hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Report</span>
            {{-- <span
              class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-emerald-900 bg-emerald-500 rounded dark:bg-emerald-900 dark:text-emerald-900">Connected</span> --}}
          </li>
          @else

          <li
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-600 group hover:shadow dark:bg-green-red dark:hover:bg-red-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Report</span>

          </li>
          @endif


          @if($dataProject)
          <li onclick="window.open(`{{config('app.url4')}}/_997744Isfnj)asdjknjZqwnmPOdfk_HHHGsfbp7AscaYjsn_asj20Ssdszf96GH645G1as41s_sdfnjozz/{{$data->code}}&{{$data->token}}`, '_blank')"
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ โครงการ (Stock)</span>
            {{-- <span
              class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-emerald-900 bg-emerald-500 rounded dark:bg-emerald-900 dark:text-emerald-900">Connected</span> --}}
          </li>
          @else
          <li
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-600 group hover:shadow dark:bg-red-600 dark:hover:bg-red-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ โครงการ (Stock)</span>
          </li>
          @endif

          @if($data->active_vbasset==1)
          <li onclick="window.open(`{{config('app.url5')}}/44Ad852asdbp7AscaYjsn_asj2041Otyko_s_Asdklolkl98741pwrja0a1zz/{{$data->code}}&{{$data->token}}`, '_blank')" class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
          hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ สินทรัพย์ (Asset) </span>
          </li>
          @else
          <li
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-600 group hover:shadow dark:bg-red-600 dark:hover:bg-red-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ สินทรัพย์ (Asset) </span>
          </li>
          @endif

         @if($dataVconex==1)
          <li onclick="window.open(`{{config('app.url6')}}/992PowrmkfrK45lksmdjdl_rruins878Dasddlfjk792sj_sadAkZXQQew/{{$data->code}}`, '_blank')"
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
            hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ VBLead (Call Center)</span>
          </li>
          @else
          <li class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-600 group hover:shadow dark:bg-red-600 dark:hover:bg-red-500 dark:text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                      </svg>
                      <span class="flex-1 ml-3 whitespace-nowrap">ระบบ VBLead (Call Center)</span>
           </li>
           @endif



          @if($data->active_agent==1)
                {{-- @if($data->auth_password_agent==0) --}}

                {{-- <a href="{{route('Reagent')}}"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
                    hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Sale/Agent</span>
                </a> --}}
                {{-- @else --}}
                <li onclick="window.open(`{{config('app.url7')}}/Zx00faff00048s2zxwormRqvBNsddsf098r/{{$data->code}}&{{$data->token}}`, '_blank')"
                    class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
                    hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Sale/Agent</span>
                </li>
                {{-- @endif --}}
          @else
          <li
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-600 group hover:shadow dark:bg-red-600 dark:hover:bg-red-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ Sale/Agent</span>
          </li>
          @endif

          {{-- @if($data->active_vproject==1)
          <li onclick="window.open(`{{config('app.url10')}}/PY0A3A9$G55KlasS90xxQwA9FvvLkiIQdZxpO09s1A/{{$data->code}}&{{$data->token}}`, '_blank')"
            class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
            hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">ระบบ นัดชมโครงการ</span>
          </li>
          @else --}}
          <li class="flex items-center p-3 text-base font-bold text-gray-900 bg-red-200 rounded-lg hover:bg-red-600 group hover:shadow dark:bg-red-600 dark:hover:bg-red-500 dark:text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                      <span class="flex-1 ml-3 whitespace-nowrap">ระบบ นัดชมโครงการ</span>
                      <span class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">Coming soon</span>
           </li>
           {{-- @endif --}}


          <li onclick="window.open(`{{config('app.url8')}}`, '_blank')" class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
          hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">Email (Login Required)</span>
          </li>

          <li onclick="window.open(`{{config('app.url9')}}`, '_blank')" class="flex items-center p-3 text-base font-bold text-gray-900 bg-green-200 rounded-lg hover:bg-green-600 group
          hover:shadow dark:bg-green-600 dark:hover:bg-green-500 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">Nass Server (Login Required)</span>
          </li>



        </ul>
      </div>


    </div>
    {{-- <h6 class="text-center">Version {{config('app.appver')}}</h6> --}}
    <h6 class="text-center">Version 1.0.2</h6>
    <div class="mb-5">
    </div>
  </div>
  {{-- <div class="fixed bottom-0 w-full flex justify-end mb-4 mr-4 pr-2 my-event">
    <div class="relative w-20 h-20 rounded-full border-4 border-white bottom-0 right-0 z-10">
      <div class="absolute inset-0 w-full h-full rounded-full bg-gradient-to-br from-yellow-400 to-red-500"></div>
      <div class="absolute inset-0 w-2/3 h-2/3 rounded-full bg-white flex justify-center items-center">
        <span>Exam</span>
      </div>
    </div>
  </div> --}}

</body>

</html>

<style>
  body {
    background: linear-gradient(to right, #312e81, #4ade80);
    background: -webkit-linear-gradient(to right, #312e81, #4ade80); /* Chrome 10-25, Safari 5.1-6 */
  }

  li {
    cursor: pointer;
  }

  btn-logout {

    background: #ec008c; /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #fc6767, #ec008c); /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #fc6767, #ec008c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,
    Safari 7+ */
    color: #fff;
    /* border: 3px solid #eee; */
  }

  /* .main-body {
    padding: 15px;
  }

  .card {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
  }

  .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0, 0, 0, .125);
    border-radius: .25rem;
  }

  .card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
  }

  .gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
  }

  .gutters-sm>.col,
  .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
  }

  .mb-3,
  .my-3 {
    margin-bottom: 1rem !important;
  }

  .bg-gray-300 {
    background-color: #e2e8f0;
  }

  .h-100 {
    height: 100% !important;
  }

  .shadow-none {
    box-shadow: none !important;
  } */
</style>
