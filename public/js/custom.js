$(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready
console.log("document is ready");
  

  $( ".card" ).hover(
  function() {
    $(this).addClass('shadow-lg').css('cursor', 'pointer'); 
  }, function() {
    $(this).removeClass('shadow-lg');
  }
);
  
// document ready  
});

 $("#postsCarousel").carousel({ interval: 2000, pause: "hover" });



setInterval(function(){ $('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    }); }, 3000);









$(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    


    $(".file-upload").on('change', function(){
        readURL(this);
    });
});





$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});






/*$(document).ready(function(){
  $("button").click(function(){
    alert("Value: " + $("#test").val());
  });
}); */




/* $(document).ready(function(){
    
    $('.edit-qual').click(function(){
        $(this).hide();
        $(this).prev().hide();
        $(this).next().show();
        $(this).next().select();
    });
    
    
    $('input[type="text"]').blur(function() {  
         if ($.trim(this.value) == ''){  
             this.value = (this.defaultValue ? this.defaultValue : '');  
         }
         else{
             $(this).prev().prev().html(this.value);
         }
         
         $(this).hide();
         $(this).prev().show();
         $(this).prev().prev().show();
     });
      
      $('input[type="text"]').keypress(function(event) {
          if (event.keyCode == '13') {
              if ($.trim(this.value) == ''){  
                 this.value = (this.defaultValue ? this.defaultValue : '');  
             }
             else
             {
                 $(this).prev().prev().html(this.value);
             }
             
             $(this).hide();
             $(this).prev().show();
             $(this).prev().prev().show();
          }
      });
          
}); */


/*$(document).ready(function(){
  $("#qual").click(function(){
    $("#mainqual").();
    
  });
});*/

$('#qual').on('click', function() {
  if ($(this).hasClass('save')) {
    alert("Saved!!!");
    $(this).text("Edit").removeClass('save');
    $('#mainqual').attr('contenteditable', 'false').css({
      'border': 'none',
      'outline': 'none'
    });
  } else {
    $(this).text("Save").addClass('save');
    $('#mainqual').attr('contenteditable', 'true').css({
      'border': 'black solid 1px',
      'outline': 'none'
    }).focus();
  }
});



$('#work').on('click', function() {
  if ($(this).hasClass('save')) {
    alert("Saved!!!");
    $(this).text("Edit").removeClass('save');
    $('#mainwork').attr('contenteditable', 'false').css({
      'border': 'none',
      'outline': 'none'
    });
  } else {
    $(this).text("Save").addClass('save');
    $('#mainwork').attr('contenteditable', 'true').css({
      'border': 'black solid 1px',
      'outline': 'none'
    }).focus();
  }
});



/******************************************leaderboard slider*****************/


/******************************************leaderboard slider*****************/