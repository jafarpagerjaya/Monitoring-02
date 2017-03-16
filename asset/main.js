// iCheck
$(function () {
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
});

// Modal
$(document).ready(function(){
  // Show the Modal on load
  $("#myModal").modal("show");

  // Show the Modal on Click
  $("#lupaPassword").click(function(){
    $("#myModalLupaPassword").modal("show");
  });
  $("#ketentuan").click(function(){
    $("#myModalKetentuan").modal("show");
  });

  // Check Retype password
  var password = document.getElementById("password")
    , retype_password = document.getElementById("retype_password");
  function validatePassword(){
    if(password.value != retype_password.value) {
      retype_password.setCustomValidity("Password Tidak Cocok");
    } else {
      retype_password.setCustomValidity('');
    }
  }
  password.onchange = validatePassword;
  retype_password.onkeyup = validatePassword;
});

// Preloader
$(window).load(function() { $(".preload-wrapper").fadeOut("slow"); })

