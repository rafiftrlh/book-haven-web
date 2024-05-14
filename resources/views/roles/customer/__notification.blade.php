<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<div class="container-fluid py-4">
   <h4>Notification</h4>

  
   <div class="bgnotif rounded shadow py-4">
      @for ($i = 0; $i < 5; $i++)
         <div class="notif bg-gray w-90 ms-5 mt-4 rounded-1 border border-2 border-dark" style="height: 85px">
            <div class="rounded-circle bg-primary" style="width: 20px; height: 20px; top: -11px; left: -8px; position:relative;"></div>
            <img src="assets/img/user.png" class="w-10" style="height:40px;" alt="">
            <span class="ms-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</span>
         </div>
      @endfor
    </div>
  </div>
</div>
