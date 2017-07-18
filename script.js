window.onload = function () {
  (function(){
    var msg_timeout_delay = 4;
    var login, register, login_section, register_section, login_or_register_section, logged_in_area;
    var msgs = document.getElementsByClassName('msg');
    var errors = document.getElementsByClassName('error');
    login = document.getElementById('login-btn');
    register = document.getElementById('register-btn');
    login_section = document.getElementById('login');
    register_section = document.getElementById('register');
    login_or_register_section = document.getElementById('login-or-register');
    //show logged in area
    if(document.getElementById('logged-in-area')){
      logged_in_area = document.getElementById('logged-in-area');
      logged_in_area.style.display = 'block';
    }
    //login and register buttons
    login.addEventListener('click', hideRegister);
    register.addEventListener('click', hideLogin);
    function hideLogin(){
      login_or_register_section.style.display = 'none';
      login_section.style.display = 'none';
      register_section.style.display = 'block';
    }
    function hideRegister(){
      login_or_register_section.style.display = 'none';
      register_section.style.display = 'none';
      login_section.style.display = 'block';
    }

    // Check for instances of the 'msg' or 'error' class and handle
    if(msgs[1]){
      (function () {
        document.getElementById('login-or-register').style.display = 'none';
        if(document.getElementById('logged-in-area')){
          document.getElementById('logged-in-area').style.display = 'none';
        }
        for(var i = 0; i < msgs.length; i++){
          TweenLite.set(msgs[i], {delay:msg_timeout_delay, display:'none'});
        }
        TweenLite.set('#login-or-register', {delay:msg_timeout_delay, display:'block'});
        if(document.getElementById('logged-in-area')){
          TweenLite.set('#logged-in-area', {delay:msg_timeout_delay, display:'block'});
        }
      }());
    }
    if(errors[1]){
      (function () {
        document.getElementById('login-or-register').style.display = 'none';
        if(document.getElementById('logged-in-area')){
          document.getElementById('logged-in-area').style.display = 'none';
        }
        for(var i = 0; i < errors.length; i++){
          TweenLite.set(errors[i], {delay:msg_timeout_delay, display:'none'});
        }
        TweenLite.set('#login-or-register', {delay:msg_timeout_delay, display:'block'});
        if(document.getElementById('logged-in-area')){
          TweenLite.set('#logged-in-area', {delay:msg_timeout_delay, display:'block'});
        }
      }());
    }

  }());
}
