<!-- jQuery library -->
  <script src="{{url('/')}}/public/site/assets/js/jquery.min.js"></script>  
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{url('/')}}/public/site/assets/js/bootstrap.js"></script>   
  <!-- Slick slider -->
  <script type="text/javascript" src="{{url('/')}}/public/site/assets/js/slick.js"></script>
  <!-- Counter -->
  <script type="text/javascript" src="{{url('/')}}/public/site/assets/js/waypoints.js"></script>

  <script type="text/javascript" src="{{url('/')}}/public/site/assets/js/jquery.counterup.js"></script>  
  <!-- Mixit slider -->
  <script type="text/javascript" src="{{url('/')}}/public/site/assets/js/jquery.mixitup.js"></script>
  <!-- Add fancyBox -->        
  <script type="text/javascript" src="{{url('/')}}/public/site/assets/js/jquery.fancybox.pack.js"></script>
  <!-- Youtube Player -->
  <script type="text/javascript" src="{{url('/')}}/public/site/assets/js/jquery.tubeplayer.min.js"></script>
  
  
  <!-- Custom js -->
  <script src="{{url('/')}}/public/site/assets/js/custom.js"></script> 

  <!-- video player-->
  <script type="text/javascript" src="{{url('/public/admin/vendor/jplayer-2.9.2')}}/dist/jplayer/jquery.jplayer.min.js"></script>
  <script type="text/javascript" src="{{url('/public/admin/vendor/jplayer-2.9.2')}}/dist/add-on/jplayer.playlist.min.js"></script>
  <!-- datepicker -->
  <script type="text/javascript" src="{{url('/public/site/assets')}}/datepicker/bootstrap-datepicker.js"></script>

  <!-- toaster -->
  <script type="text/javascript" src="{{url('/public/admin/vendor/jquery-toast')}}/jquery.toast.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      getCartItem();
    });

    function toast_success(title,msg){
      $.toast({ 
        heading:title,
        icon:'success',
        text : msg, 
        showHideTransition : 'plain',  // It can be plain, fade or slide
        bgColor : '#3cb057',              // Background color for toast
        textColor : '#fff',            // text color
        allowToastClose : true,       // Show the close button or not
        hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
        textAlign : 'left',            // Alignment of text i.e. left, right, center
        position : 'bottom-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
      });
    }
    function toast_error(title,msg){
      $.toast({ 
        heading:title,
        icon:'error',
        text : msg, 
        showHideTransition : 'plain',  // It can be plain, fade or slide
        bgColor : '#dd3848',              // Background color for toast
        textColor : '#fff',            // text color
        allowToastClose : true,       // Show the close button or not
        hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
        textAlign : 'left',            // Alignment of text i.e. left, right, center
        position : 'bottom-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
      });
    }
    function toast_warning(title,msg){
      $.toast({ 
        heading:title,
        icon:'warning',
        text : msg, 
        showHideTransition : 'plain',  // It can be plain, fade or slide
        bgColor : '#ffc71f',              // Background color for toast
        textColor : '#1f2d3d',            // text color
        allowToastClose : true,       // Show the close button or not
        hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
        textAlign : 'left',            // Alignment of text i.e. left, right, center
        position : 'bottom-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
      });
    }

  function bookingFasilitas(){
    $.ajax({
      url:"{{url('/')}}/book/addtocart",
      type:"POST",
      data: {
        "_method": "POST",
        "_token": "{{ csrf_token() }}",
        "cat":'{{@$segment}}',
        "keyid": $('#keyid').val(),
        "nama_fasilitas": $('#nama_fasilitas').val(),
        "harga_booking": $('#harga_booking').val()
      },
      success:function(data){
        if(data.success==1){
          toast_success('Berhasil',data.msg);
        }else{
          toast_error('Gagal',data.msg);
        }
        getCartItem();
      },error:function(error){
        toast_error('Error','Terjadi kesalahan sistem');
        console.log(error.XMLHttpRequest);
      }
    });
  }

  function getCartItem(){
    //getcartitem
    $.ajax({
      url:"{{url('/')}}/book/getcartitem",
      type:"GET",
      data: {
        "_method": "GET",
        "_token": "{{ csrf_token() }}"
      },
      success:function(data){
        //console.log(data);
        $('#cart-number').html(data.total);
      },error:function(error){
        //console.log(error.XMLHttpRequest);
      }
    });
  }

  </script>