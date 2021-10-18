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

          <div class="col-lg-3 col-md-6">
            <div class="box featured">
              <h3>Free</h3>
              <h4><sup>$</sup>0<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
               
              </ul>
              <div class="btn-wrap">
                <a href="inner-page.html" class="btn-buy">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
            <div class="box featured">
              <h3>Business</h3>
              <h4><sup>$</sup>19<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
              
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
            <div class="box featured">
              <h3>Developer</h3>
              <h4><sup>$</sup>29<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Comprar</a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
            <div class="box featured">
              <span class="advanced">Advanced</span>
              <h3>Ultimate</h3>
              <h4><sup>$</sup>49<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Comprar</a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Pricing Section -->


</main><!-- End #main -->
@endsection