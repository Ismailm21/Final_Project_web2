@extends('layouts.template_client')

@section('content')
    <!--/breadcrumb-bg-->
    <div class="breadcrumb-bg w3l-inner-page-breadcrumb py-5">
        <div class="container pt-lg-5 pt-md-3 p-lg-4 pb-md-3 my-lg-3">
            <ul class="breadcrumbs-custom-path mt-3 text-center pt-5">
                <li><a href="index.html">Home</a></li>
                <li class="active"><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span> 404 </li>
            </ul>
        </div>
    </div>
    <!--//breadcrumb-bg-->
    <!--/404-->
    <div class="w3l-error-grid py-5 text-center">
        <div class="container py-lg-5 py-md-4">
            <div class="errorhny-block">
                <div class="container-text">
                    404
                </div>

                <h3>Oops! That page can’t be found.</h3>
                <p class="mt-4">Sorry, we're offline right now to make our site even better. Please, comeback later and check what we've
                    been upto.</p>


                <a href="{{route('client_request_order')}}" class="btn btn-style btn-primary mt-5">Refill your Request</a>
            </div>
        </div>
    </div>
@endsection
