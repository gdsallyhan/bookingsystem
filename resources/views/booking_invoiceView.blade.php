@extends('layouts.displays')
@section('content')

<div style="display:block; max-width: 21cm; margin: 0 auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 40%;">
                <img src="{{ asset('/icon/logo.jpg')}}" width="200" height="100">
            </td>
            <td style="width: 60%;">
                <b> VENTURA TRANS AND SERVICE (M) SDN. BHD.<br></b>
                <p style="font-size: 12px;"><b>Company No. 201901043807(1353137-M)</b><br>
                4230-AA Persiaran Raja Muda Musa, Kg Raja Uda,<br>
                42000 Port Klang, Selangor <br>
                Email: venturamalaysia5@gmail.com<br>
                Tel: +60103851177</p>
            </td>
        </tr>
    </table>
</div>

<div class="text-center">
    <div style="border-top: 2px solid black; margin: 0;"></div>
    <div><p></p></div>
</div>
<div class="text-center">
    <div  style="background-color: transparent; font-weight: bold; font-size: 20px;">INVOICE</div>
    <div><p></p></div>
</div>


<div class="row">
    <div class="col-6">
        <table border="0" style="width:210%">
            <tr>
                <th style="text-align: left;width: 20%;">Invoice No</th>
                <td style="text-align: left;">: &nbsp;{{  $booking->booking_no  }}</td>
                <th style="text-align: right;">Date</th>
                <td style="text-align: left;">: &nbsp;{{ Carbon\Carbon::parse(now())->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th style="text-align: left;width: 20%;">To</th>
                <td style="text-align: left;">: &nbsp;{{ $booking->customer()->name }}</td>
                <th style="text-align: right;">Phone No</th>
                <td style="text-align: left;">: &nbsp;{{ $booking->customer()->phone}}</td>
            </tr>
            <tr>
                <th style="text-align: left;width: 20%;">Att</th>
                <td style="text-align: left;">: &nbsp;</td> 
            </tr>
        </table>
    </div>
</div>

           
<div style="margin: 30px 0;"></div>

    <div class="row">
        <div class="col-6">
            <table border="0" style="width:210%">
                <tr>
                    <th style="text-align: left;width: 30%; ">SHIPPING DETAILS</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <table border="0" style="width:215%">
                 <tr>
                    <th style="text-align: left;width: 10%;">Shipping Date</th>
                    <td style="text-align: left;width: 50%;">: &nbsp;{{ Carbon\Carbon::parse($booking->shipment()->date)->format('d/m/Y') }}</td>
                    <th style="text-align:left; ">Pol</th>
                    <td style="text-align: left;">: &nbsp;{{ $booking->shipment()->port_from }}</td>
                </tr>    

                <tr>
                    <th style="text-align: ">Vessel No</th>
                    <td style="text-align: left;">: &nbsp;{{ $booking->shipment()->number }}</td>
                    <th style="text-align: ">Pod</th>
                    <td style="text-align: left;">: &nbsp;{{ $booking->shipment()->port_to }}</td>
                </tr>

                <tr>
                    <th style="text-align: left;width: 20%;">Vessel Name</th>
                    <td style="text-align: left;">: &nbsp;{{ $booking->shipment()->name }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        
        <div class="row">
            <div class="col-6">
                <table border="0" style="width:220%">
                    <tr>
                        <th style="text-align: center;width: 8%; background-color: rgb(6, 6, 155); color: white;">NO</th>
                        <th style="text-align: left;width: 50%; background-color: rgb(6, 6, 155); color:white;">&nbsp;&nbsp;&nbsp;DESCRIPTION</th>
                        <th style="text-align: center; width: 29%;background-color: rgb(6, 6, 155); color:white;">UNIT</th>
                        <th style="text-align: left; background-color: rgb(6, 6, 155); color:white;">AMOUNT</th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <table border="0" style="width:220%">
                    <tr>
                        <td style="text-align: center;width: 8%;">1</td>
                        <td style="text-align: center;width: 25%;">OCEAN FREIGHT</td>
                        <td style="text-align: center;width: 35%;">{{ $booking->package()->car_category }}</td>
                        <td style="text-align: center;width:35%">{{ $booking->vehicle()->plate_no }}</td>
                        <td style="text-align: left;">
                            RM{{ number_format($booking->package()->price, 2, ".", ",") }}
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">2</td>
                        <td style="text-align: center;">DELIVERY</td>
                        <td style="text-align: center;">
                            @if ($booking->location_id_delivery > 1)
                            {{ $booking->locationDelivery()->name }} BY {{ $booking->locationDelivery()->carry_by }}
                            @else
                            {{ $booking->locationDelivery()->name }}
                            @endif
                        </td>
                        <td style="text-align: center;width: 40%;"></td>
                        <td style="text-align: left;">
                            @if ($booking->location_id_delivery > 1)
                            RM{{ number_format($booking->locationDelivery()->price, 2, ".", ",") }}
                            @else
                            {{ $booking->locationDelivery()->price }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">3</td>
                        <td style="text-align: center;">COLLECTION</td>
                        <td style="text-align: center;">
                            @if ($booking->location_id_pickup > 1)
                            {{ $booking->locationPickup()->name }} BY {{ $booking->locationPickup()->carry_by}}
                            @else
                            {{ $booking->locationPickup()->name }}
                            @endif
                        </td>
                        <td style="text-align: center;width: 40%;"></td>
                        <td style="text-align: left;">
                            @if ($booking->location_id_pickup > 1)
                            RM{{ number_format($booking->locationPickup()->price, 2, ".", ",") }}
                            @else
                            {{ $booking->locationPickup()->price }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">4</td>
                        <td style="text-align: center;">MARINE INSURANCE</td>
                        <td style="text-align: center;">
                            @if ($booking->insurance_id > 0)
                            RM{{ number_format($booking->insurance()->market_value,2,".",",") }}
                            @else
                            NO SELECTED
                            @endif
                        </td>
                        <td style="text-align: center;width: 40%;"></td>
                        <td style="text-align: left;">
                            @if ($booking->insurance_id > 0)
                            RM{{ number_format($booking->insurance()->insurance_price, 2, ".", ",") }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;"><br>Subtotal &nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="text-align: left; border-bottom: 1px solid black;"><br>
                            RM{{ number_format($booking->amount, 2, ".", ",") }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;"><b>Total &nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <th style="text-align: left; border-bottom: 3px double black;">
                            RM{{ number_format($booking->amount, 2, ".", ",") }}
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <table>
                    <tr>
                        <td colspan="3" style="background-color: rgb(68, 177, 235);">
                            <div style="padding: 10px; width: 500px;">
                                <p style="color: white; font-weight: bold;">NOTE:</p>
                                <p style="color: white;">1. The above ocean freight charges.</p>
                                <p style="color: white;">2. The above rates include of forwarding, port charges at both port.</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div> 
    </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-6">
                <table style="width: 100%; max-width: 100%;">
                    <tr>
                        <td >
                            <p style="color: rgb(23, 22, 22); font-weight: bold; margin: 5px 0;">*Bank directly to our company account:</p>
                            <p style="color: rgb(5, 5, 5); font-weight: bold; margin: 5px 0;">Ventura Trans and Services (M) Sdn. Bhd.</p>
                            <p style="color: rgb(14, 13, 13); font-weight: bold; margin: 5px 0;">Account Number: 5580-9706-5178, Maybank Berhad</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table style="width: 100%; max-width: 100%;">
                    <tr>
                        <td style="text-align: center;">
                            <p style="color: rgb(23, 22, 22); font-weight: bold;">THANK YOU FOR YOUR BUSINESS!</p>
                            <img src="{{ asset('/icon/cop-ventura.png')}}" width="120" height="120">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
            
    
    <div class="row" style="margin-top: 2px;">
            <p style="color: rgb(23, 22, 22); font-weight: bold; ">BEST REGARDS,<br><br>
                SYAZWAN BIN AHMAD HELMI<br>
                MANAGER<br>
                VENTURA TRANS AND SERVICES (M) SDN. BHD.<br>
            </p>
            <p style="color: rgb(23, 22, 22);"><br>NOTE: THIS IS COMPUTER GENERATED PRINTOUT AND NO SIGNATURE IS REQUIRED</p><br><br><br>
    </div>

    <div class="card">
        <div class="card-header">REQUIRED DOCUMENTS</div>
        <div class="card-body">
            <table>
                <tr>
                    <td>
                        @if($booking->vehicle()->file_geran != '')
                       <a href="{{route('booking.linkFileGrant', $booking->id)}}" target="_blank" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return true;" > <p> *Vehicle's Registration Card is uploaded</p></a>
                        @else
                        <p>No Vehicle's Registration Card uploaded</p>
                        @endif
                    </td>
                </tr>
                 <tr>
                    <td>
                       @if($booking->vehicle()->file_loan != '')
                         <a href="{{route('booking.linkFileLoan', $booking->id)}}" target="_blank" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return true;" > <p> *Bank Permission Letter / Insurance Policy is uploaded</p></a>
                        @else
                        <p> No Bank Permission Letter / Insurance Policy uploaded</p>
                        @endif
                    </td>
                </tr>
            </table>    
        </div>
    </div>
    <br>

    <div class="row">
        <table>
            <tr>
                <td>
                    <div>
                        @if($booking->user_id > 0)
                        Keyin by : {{ $booking->user()->name }}
                        @else
                        Book via : Online
                        @endif
                    </div> 
                </td>
                <td>
                    <div align="right" style="width:90%">
                        <b>Untuk Cetak Klik Sini --><b> &nbsp; <a href="{{route('booking.invoicePDF', $booking->id)}}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;"  >
                            <img src="{{ asset('/icon/printer.gif')}}" alt="Cetak" height="50" width="50"/></a>
                    </div>
                </td>
            </tr>
        </table>
    </div>









@endsection