@extends('layouts.displays')
@section('content')


<div style="display:block;">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">

                <div class="card text-center">
                    <div class="card-header">PLEASE READ VEHICLE INFORMATION</div>
                </div>

                <div class="card-body">

                    <div class="card">
                        <div class="card-header">VEHICLE DETAILS</div>

                        <div class="card-body">

                            <table>
                                <tr>
                                    <th>Booking No.</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->booking()->booking_no }}</td>
                                </tr>

                                <tr>
                                    <th>Owner Name</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->customer()->name }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Contact</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->customer()->phone }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Vehicle Registration No. </th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->plate_no }}</td>
                                    
                                </tr>

                                <tr>
                                    <th>Body Type</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->type }}</td>
                                </tr>

                                <tr>
                                    <th>Brand/Model</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->model }}</td>

                                </tr>

                                <tr>
                                    <th>Engine No.</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->engine }}</td>

                                </tr>

                                <tr>
                                    <th>Chassis No.</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->chasis }}</td>

                                </tr>

                                <tr>
                                    <th>Color</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->color }}</td>

                                </tr>

                                <tr>
                                    <th>Year Manufactured</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->year }}</td>

                                </tr>
                                <tr>
                                    <th>Personal Effect</th>
                                    <td>: &nbsp;</td>
                                    <td>{{ $vehicle->personal_effect }}</td>

                                </tr>

                            </table>


                            
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">REQUIRED DOCUMENTS</div>
                        <div class="card-body">
                            <table>
                            
                                <tr>
                                    <td>
                                        @if($vehicle->file_geran != '')
                                       <a href="{{route('vehicle.vLinkFileGrant', $vehicle->id)}}" target="_blank" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return true;" > <p> *Vehicle's Registration Card is uploaded</p></a>

                                        @else
                                        <p>No Vehicle's Registration Card uploaded</p>

                                        @endif
                                    
                                    </td>
                                    
                                </tr>

                                 <tr>
                                    <td>
                                       @if($vehicle->file_loan != '')
                                         <a href="{{route('vehicle.vLinkFileLoan', $vehicle->id)}}" target="_blank" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return true;" > <p> *Bank Permission Letter / Insurance Policy is uploaded</p></a>

                                        @else
                                        <p> No Bank Permission Letter / Insurance Policy uploaded</p> 

                                        @endif
                                    
                                    </td>
                                    
                                </tr>
                            </table>    
                        </div>
                    </div>


                </div>

           </div>             
        </div>
    </div>

</div>



@endsection

