<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/booking.js') }}"></script>
    <script src="{{ asset('js/currency.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

   <!--  <link href="{{ asset('bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet"> -->

    <!-- <link href="{{ asset('bootstrap-3.3.7-dist/css/bootstrap.min.js') }}" rel="stylesheet"> -->



    <!-- font awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

</head>




<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

            <div class="container">
                <div class="row">

                    <div class="col-md-2">

                        <div class="card text-center">
                            <img src="{{ asset('/icon/logo.png')}}" width="70%" style="margin:auto;"  >
                        </div>

                        <br>

                
                    <!-- <div class="d-grid gap-2"> -->
                        <a href="{{ route('home') }}" class="btn @if(Request::is('admin/home*')) btn-warning @else btn-primary @endif btn-block" >Dashboard</a>

                        <a href="{{ route('booking.index') }}" class="btn @if(Request::is('admin/booking*')) btn-warning @else btn-primary @endif btn-block">Booking</a>


                        <a href="Payment" class="btn btn-primary btn-block">Payment</a>

                        <a href="{{ route('customer.index') }}" class="btn @if(Request::is('admin/customer*')) btn-warning @else btn-primary @endif btn-block">Customer</a>

                       <!--  <a href="{{ route('location.index') }}" class="btn @if(Request::is('admin/location*')) btn-warning @else btn-primary @endif btn-block">Location</a>

                        <a href="{{ route('shipment.index') }}" class="btn @if(Request::is('admin/shipment*')) btn-warning @else btn-primary @endif btn-block">Shipment</a>

                        <a href="{{ route('package.index') }}" class="btn @if(Request::is('admin/package*')) btn-warning @else btn-primary @endif btn-block">Package</a>

                        <a href="{{ route('insurance.index') }}" class="btn @if(Request::is('admin/insurance*')) btn-warning @else btn-primary @endif btn-block">Insurance</a> -->

                       <!--  <a href="{{ route('staff.index') }}" class="btn @if(Request::is('admin/staff*')) btn-warning @else btn-primary @endif btn-block">Staff</a> -->

                        <a href="{{ route('vehicle.index') }}" class="btn @if(Request::is('admin/vehicle*')) btn-warning @else btn-primary @endif btn-block">Vehicle</a>

                          <a class="btn btn-primary btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Setting
                          </a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item " href="{{ route('location.index') }}">Location</a>
                            <a class="dropdown-item" href="{{ route('shipment.index') }}">Shipment</a>
                            <a class="dropdown-item" href="{{ route('package.index') }}">Package</a>
                            <a class="dropdown-item" href="{{ route('insurance.index') }}">Insurance</a>
                            <a class="dropdown-item" href="{{ route('staff.index') }}">Staff</a>
                          </div> 

                   <!--  </div> -->

                            <br><br>
                    </div>

                      <div class="col-md-10">
                        @yield('content')
                    </div>
                </div>
            </div>

        </main>
    </div>
    
</body>
</html>
