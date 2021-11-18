@extends('layouts.template')

@section('content')

<!-- ======= Header ======= -->
@include('layouts.partials.nav')
<!-- End Header -->

<style>

#login img {
  margin: 10px 0;
}
#login .center {
  text-align: center;
}

#login .login {
  max-width: 400px;
  margin: 35px auto;
}

#login .login-form {
  padding: 0px 25px;
}

</style>
<br><br><br><br>
<div id="login" class="container">
  <div class="row-fluid">
    <div class="span12">
      <div class="login well well-small">
        <div class="center">
          <img src="{{asset('img/logos/Beenet-logo.png')}}" alt="logo" width="150px">
        </div>  
        <form  method="POST" action="{{route('loginPortal')}}" class="login-form" id="UserLoginForm" accept-charset="utf-8">
          {{ csrf_field() }}
          <div class="control-group">
            <div class="input-prepend">
              <span class="add-on"><i class="icon-user"></i></span>
              <input class="form-control" type="text" name="username" id="username" placeholder="Usuario" required="required" id="username" name="username">

            </div>
          </div>
          <br>
          <div class="control-group">
            <div class="input-prepend">
              <span class="add-on"><i class="icon-lock"></i></span>
              <input class="form-control" type="text"name="password" id="password" placeholder="Contraseña" required="required" id="password" name="password">
            </div>
          </div>
          <br>
          
          <div class="control-group">
              <center>
                <input class="btn btn-primary btn-large btn-block" type="submit" value="Iniciar Sesion">
              </center>
            </div>
        </form><br>
        <center>
        <form  method="POST" action="{{route('internet')}}" class="login-form" id="UserLoginForm" accept-charset="utf-8">
          {{ csrf_field() }}
          <input type="hidden" class="form-control"  name="tariffId" id="tariffId" value="{{$incoming['tariffId']}}">
          <input type="hidden" class="form-control"  name="tariffName" id="tariffName" value="{{$incoming['tariffName']}}">
          <input type="hidden" class="form-control"  name="tariffPrice" id="tariffPrice" value="{{$incoming['tariffPrice']}}">
          <input class="btn btn-primary btn-large btn-block" type="submit" value="Crear Cuenta">
        </form>
        </center>
      </div>
      <!--/.login-->
    </div>
    <!--/.span12-->
  </div>
  <!--/.row-fluid-->
</div>
<!--/.container-->
<br><br><br><br><br><br>
@endsection
