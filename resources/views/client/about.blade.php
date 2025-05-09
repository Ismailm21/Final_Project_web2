@extends('layouts.template_client')
@section('content')
    <section class="w3l-about-ab" id="about">
        <div class="midd-w3 py-5">
            <div class="container py-lg-5 py-md-4 py-2">
                <div class="imgw3l-ab mb-md-5 mb-3">
                    <img src="{{asset("assets/images/banner2.jpg")}}" alt="" class="radius-image img-fluid">
                </div>
                <div class="row">
                    <div class="col-lg-5 left-wthree-img">
                        <h6 class="title-subhny">What We Do</h6>
                        <h3 class="title-w3l mb-4">Explore Our Main Goals For Fast Delivery</h3>
                    </div>
                    <div class="col-lg-7 pl-lg-5 align-self">
                        <p class="">Fast Delivery

                        </p>
                        <p class="mt-4">
                            Choose your own Driver auto or manually
                            Track order

                        </p>
                        <a href="{{asset("about.html")}}" class="btn btn-style btn-primary mt-lg-5 mt-4">Read More</a>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection
