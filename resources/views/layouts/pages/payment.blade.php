@extends('layouts.template')

@section('content')

<!-- ======= Header ======= -->
@include('layouts.partials.nav')
<!-- End Header -->

<br><br>
<main id="main">

   <!-- ======= Pricing Section ======= -->
   <section id="" class="">
    
    <div class="container mb-4">
        <form action="#">
            <div class="row pt-2 pb-4">
                
                <div class="col-lg-8">
                    
                        <div class="row pt-4">

                            <!--Columna 1-->
                            <div class="col-lg-6 pl-0">
                                <div class="form-group">

                                    <input type="text" class="form-control" placeholder="Nombre Completo" required>
                                    <br>
                                    <input type="email" class="form-control" placeholder="Correo electronico" required>
                                    <br>
                                    <input type="email" class="form-control" placeholder="Celular" required>
                                    <br>
                                    <input type="text" class="form-control" placeholder="Enter city" required>
                                    <br>
                        
                                    <div class="row">
                                        <div class="col-lg-6 pl-0">
                                            <div class="form-group">
        
                                                <input type="text" class="form-control" placeholder="Enter State" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pr-0 mob-pl-0">
                                            <div class="form-group">
        
                                                <input type="number" class="form-control" placeholder="Enter Zip" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Columna 2-->
                            <div class="col-lg-6 mob-pl-0">

                                <div class="form-group">

                                    <input type="number" class="form-control" placeholder="0000 0000 0000" required>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-6 pl-0">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="MM/YY" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pr-0 mob-pl-0">
                                            <div class="form-group">
        
                                                <input type="number" class="form-control" placeholder="CVC" irequired>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <br>
                                    <input type="number" class="form-control" placeholder="$" required>

                                    <div class="col-md-12 p-0 text-center">
                                        <br>
                                        <p class="mb-1 pb-2">Tarjetas que se aceptan</p>
                                        <img src="{{asset( 'img/payment.jpg ')}}" style="width: 200px; height: 75px;" >
                                    </div>
                                </div>
       
                            </div>
                        </div>
                </div>

                <div class="col-lg-4 pt-1">
                    <div class="row pt-4">
                        <div class="col-8">
                            <h3 class="mb-0 pb-2">Detalle compra</h3>
                        </div>
                    
                    </div>
                    <div class="row  pt-2">
                        <div class="col-8">

                            <h5 class="pb-2">Plan</h5>
                            <h5 class="pb-2">Precio</h5>
                            <h5 class="pb-2">IVA 13% </h5>

                        </div>
                        <div class="col-4">

                            <h5 class="pb-2">Internet 10MB</h5>
                            <h5 class="pb-2">$1000</h5>
                            <h5 class="pb-2">$1820</h5>
                        </div>
                    </div>
                    <div class="row border-top  border-dark">
                        <div class="col-8">
                            <h5 class="pt-2">Total</h5>
                        </div>
                        <div class="col-4">
                            <h5 class="pt-2">$4020</h5>
                        </div>
                    </div>
                    <div class="row pb-5 pt-4">
                        <div class="col-12">
                        
                            <button type="submit" class="btn btn-primary w-100">Realizar Pago</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </section><!-- End Pricing Section -->

@endsection