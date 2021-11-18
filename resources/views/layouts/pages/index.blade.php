@extends('layouts.template')

@section('content')

<!-- ======= Header ======= -->
@include('layouts.partials.transparentnav')
<!-- End Header -->
 <!-- ======= Hero Section ======= -->
 @include('layouts.partials.banner')
 <!-- End Hero -->

 
<main id="main">


    <!-- ======= Pricing Section ======= --> 
    <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title">
          <h2>Planes de internet</h2>
        </div>

        <div class="row">

          @foreach ($tariffs as $tariff)

            @if( $tariff ->partners_ids[0] == 2)

            <div class="col-lg-3 col-md-2 col-sm-3 ">
              <div class="box featured">
                <h3>{{$tariff->title}}</h3>
                <h4><sup>$</sup>{{number_format($tariff->price, 2)}}</h4>
                <div class="social-links text-center text-md-right pt-3 pt-md-0">
                  <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                  <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                  <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                  <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                  <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                </div>
                <div class="btn-wrap">

                  <!--form method="POST" action="{{route('internet')}}"-->
                  <form method="POST" action="{{route('showLogin')}}">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control"  name="tariffId" id="tariffId" value="{{$tariff->id}}">
                    <input type="hidden" class="form-control"  name="tariffName" id="tariffName" value="{{$tariff->title}}">
                    <input type="hidden" class="form-control"  name="tariffPrice" id="tariffPrice" value="{{number_format($tariff->price, 2)}}">
                    <input type="submit" class="btn-buy" value="Comprar">
                  </form>
                 
                </div>
              </div>
            </div>
            @endif
          @endforeach


          
      

        </div>

      </div>
    </section><!-- End Pricing Section -->


   


</main><!-- End #main -->
@endsection