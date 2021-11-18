@extends('layouts.template')

@section('content')

<!-- ======= Header ======= -->
@include('layouts.partials.nav')
<!-- End Header -->

<br><br><br><br><br><br>

<div class="container-fluid">
    <div class="row" style= "background: blue;">
        <form role="form" method="POST" action="{{ route('payment') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-4 pl-0" style= "background: red;">
                    <div class="form-group">
                        <label>CARD NUMBER</label>
                        <div class="input-group">
                            <input type="tel" class="form-control" placeholder="Valid Card Number" id="creditcard" name="creditcard" required/>
                            <span class="input-group-addon"><span class="fa fa-credit-card"></span></span>
                        
                            <input type="tel" class="form-control" placeholder="Valid Card Number" id="creditckard" name="creditckard" required/>
                            <span class="input-group-addon"><span class="fa fa-credit-card"></span></span>
                        
                            
                        </div>

                        

                       
                                   
                    </div>
                </div>  

                <div class="col-lg-4 pl-0" style= "background: green;">
                <p>ww</p>
                </div>

                <div class="col-lg-4 pl-0" style= "background: blue;">
                <p>ww</p>
                </div>
            </div> 

            <input type="submit" value="Payment"/>
        </form>
    </div>
</div>



@endsection