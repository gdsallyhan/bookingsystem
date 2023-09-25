@extends('layouts.master')

@section('content')

<div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show">
@if(!empty($successMsg))
 <div class="alert alert-success"> {{ $successMsg }}</div>
@else
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{  $error }}
    </div>
    @endforeach
@endif
</div>


<?php

$action = $staff->id ? route('staff.update', $staff->id) : route('staff.store');

$method = $staff->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 

<div class="row">

        <div class="col-xl-5 col-lg-4">
            
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Staff Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                        <div class="form-group">
                            @if($staff->avatar != "")
                            <img class="image rounded-circle" src="{{ asset('/'.$staff->avatar) }}" style=" width:150px; height: 150px, padding: 10px; margin: 0px; border-radius: 50%;" alt="" >
                            @else
                            <img class="image rounded-circle" src="{{ asset('/icon/default-avatar.png') }}" style=" width:150px; height: 150px, padding: 10px; margin: 0px; border-radius: 50%;" alt="" >
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ old('name', $staff->name )}}" class="form-control">
                         </div>

                        <div class="form-group">
                            <label>Email </label>
                            <input type="text" name="email" value="{{ old('email', $staff->email )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" value="" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Upload Image</label>
                            <input type="file" class="form-control" name="avatar" >
                        </div>

                </div>
            </div>

            <div class="form-group">
                  <a href="{{route('staff.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
            </div>

        </div>
    </div>

</form>

@endsection


<!-- <div class="form-group">
                        <img class=" "image rounded-circle src="{{ asset('/icon/'.$staff->avatar) }}" style=" width:200px; height: 200px, padding: 10px; margin: 0px; border-radius: 50%;" alt="" >
                        <br>
                        <label style="text-align:center;">Profile Picture</label>
                    </div>


                    <!-- <div class="row">
                        <div class="col-md-4">

                        <form method="POST" action="route('staff.upload')">
                        <input type="hidden" name="_method" value="POST" enctype="multipart/form-data">
                        @csrf 

                            <div class="form-group">
                                <input type="file" class="form-control" name="avatar" >
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="icon-upload"></i>&nbsp; Upload</a></button>
                            </div>
                        </form>
                        </div>

                       
                        </form> -->