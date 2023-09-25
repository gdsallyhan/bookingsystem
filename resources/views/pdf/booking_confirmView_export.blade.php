<html>
<head>
<style> 
    table, th, td {
        border: 0px solid;
        border-collapse: collapse;
    }
    th, td {
        padding: 4px;
        text-align: left;
    }
    p {
        padding: 0px;
        text-align: left;
        font-size: 15px;
    }

    table#t01 td  {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid black;
    }
    table#t01a td  {
        border-collapse: collapse;
        border: 0px;
        padding: 7px;
    }
    table#t02  {
        border-collapse: collapse;
        width: 100%;
        border: 0;
    }
    table#t02 td {
            border: 0px solid black;
            text-align:left;
            padding: 0 6px 6px 6px;
    }
    table#t02 th {
            border: 1px solid black;
            text-align:center;
            padding: 10px;
    }
</style>
</head>


<div style="display:block; max-width: 21cm; margin: -1em ;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 40%; padding-left:13%;">
                <img src="{{ $logo }}" width="200" height="100">
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

    <div class="text-center">
        <div style="border-top: 2px solid black; margin: 0;"></div><br>  
    </div><br>
</div>

<div style="font-weight: bold; font-size: 20px; text-align: center;">CONFIRMATION BOOKING</div>
        
<div class="row" style="margin-top: 1em">
    <div class="col-6">
        <table border="0" style="width:120%">
            <tr>
                <th style="text-align: left; width: 13%;">Book No</th>
                <td style="text-align: left; width: 40%;">: &nbsp;{{ $data->booking_no }}</td>
                <th style="text-align: right;">Date</th>
                <td style="text-align: left;">: &nbsp;{{ Carbon\Carbon::parse(now())->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th style="text-align: left;">To</th>
                <td style="text-align: left;">: &nbsp;{{ $data->customer()->name }}</td>
                <th style="text-align: right;">Phone No</th>
                <td style="text-align: left;">: &nbsp;{{ $data->customer()->phone }}</td> 
            </tr>

            <tr>
                <th style="text-align: left;">Customer No</th>
                <td style="text-align: left;">: &nbsp;{{ $data->customer()->id }}</td>
            </tr>   
        </table>
    </div>
</div>

<div style="margin-top: 1em"></div>
<div class="row">
        <div class="col-6">
            <table border="0" style="width:210%">
                <tr>
                    <th style="text-align: left;width: 30%; ">VECHICLE DETAILS</th>
                </tr>
            </table>
        </div>
    </div>
<div class="row">
    <div class="col-6">
        <table border="0" style="width:120%">
            <tr>
                <th style="text-align: left;width: 13%;">Model</th>
                <td style="text-align: left;width: 40%;">: &nbsp;{{ $model_vehicle->make }} {{ $model_vehicle->model }}</td>
                <th style="text-align: right;">Regist No</th>
                <td style="text-align: left;">: &nbsp;{{ $data->vehicle()->plate_no }}</td>
            </tr>
        </table>
    </div>
</div>

<div style="margin-top: 1em"></div>
    <div class="row">
        <div class="col-6">
            <table border="0" style="width:120%">
                <tr>
                    <th style="text-align: left;width: 30%; ">SHIPPING DETAILS</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <table border="0" style="width:120%">
                <tr>
                    <th style="text-align: left; width: 13%;">Shipping Date</th>
                    <td style="text-align: left; width: 17%;">: &nbsp;{{ Carbon\Carbon::parse($data->shipment()->date)->format('d/m/Y') }}</td>
                    <th style="text-align: right;"></th>
                    <td style="text-align: left;"></td>
                </tr>
                <tr>
                    <th style="text-align: left;">Vessel No</th>
                    <td style="text-align: left;">: &nbsp;{{ $data->shipment()->number }}</td>
                    <th style="text-align: right;"></th>
                    <td style="text-align: left;"></td>
                </tr>
                <tr>
                    <th style="text-align: left;">Vessel Name</th>
                    <td colspan="3" style="text-align: left;">: &nbsp;{{ $data->shipment()->name }}</td>
                </tr>
            </table>
        </div>
    </div>

<div  style="margin-top: 1em;">
        <div class="row">
            <div class="row">
                <table border="0" style="width:100%">
                    <tr>
                        <th style="text-align: center;width: 8%; background-color: rgb(6, 6, 155); color: white;">NO</th>
                        <th style="text-align: center;width: 40%; background-color: rgb(6, 6, 155); color:white;">&nbsp;&nbsp;&nbsp;CODE</th>
                        <th style="text-align: center; background-color: rgb(6, 6, 155); color:white;">DESCRIPTION</th>
                    </tr>
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: center;">SHIP</td>
                        <td style="text-align: center;">{{ $data->shipment()->port_from }} TO {{ $data->shipment()->port_to }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">2</td>
                        <td style="text-align: center;">DELIVERY</td>
                        <td style="text-align: center;">
                            @if ($data->location_id_delivery > 1)
                            {{ $data->locationDelivery()->name }} BY {{ $data->locationDelivery()->carry_by }}
                            @else
                            {{ $data->locationDelivery()->name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">3</td>
                        <td style="text-align: center;">COLLECTION</td>
                        <td style="text-align: center;">
                            @if ($data->location_id_pickup > 1)
                            {{ $data->locationPickup()->name }} BY {{ $data->locationPickup()->carry_by}}
                            @else
                            {{ $data->locationPickup()->name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">4</td>
                        <td style="text-align: center;">MARINE INSURANCE</td>
                        <td style="text-align: center;">
                            @if ($data->insurance_id > 0)
                            RM{{ number_format($data->insurance()->market_value,2,".",",") }}
                            @else
                            NO SELECTED
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
</div>

<div style="margin-top: 1em; ">
        <table style=" width: 60%;">
            <tr>
                <td colspan="3" style="background-color: rgb(68, 177, 235);">
                    <div style="padding: 5px;" ><strong>
                        <p style="color: white; font-weight: bold;">NOTE:</p>
                        <p style="color: white;">1. The vehicle already booking with us.</p>
                                <p style="color: white;">2. The vehicle must be send to our storage / port before the due date.</p>
                        </strong>
                    </div>
                </td>
            </tr>
        </table>
</div>
<div>
        <table style="width: 100%;">
            <tr>
                <td style="width:60%; padding-top: 1em; ">
                    <p style="color: rgb(23, 22, 22); font-weight: bold; margin: 5px 0;">*Bank directly to our company account:</p>
                    <p style="color: rgb(5, 5, 5); font-weight: bold; margin: 5px 0;"><b>Ventura Trans and Services (M) Sdn. Bhd.</b></p>
                    <p style="color: rgb(14, 13, 13); font-weight: bold; margin: 5px 0;">Account Number: 5580-9706-5178, Maybank Berhad</p>
                </td>
                <td style="text-align: center;padding-top: 1em; " rowspan="2">
                    <p style="color: rgb(23, 22, 22); font-weight: bold; margin: 5px 0;" >THANK YOU FOR YOUR BUSINESS!</p>
                    <img src="{{ $cop }}" width="120" height="120">
                </td>
            </tr>
            <tr>
                <td>
                    <p style="color: rgb(23, 22, 22); font-weight: bold; ">BEST REGARDS,<br><br>
                        SYAZWAN BIN AHMAD HELMI<br>
                        MANAGER<br>
                        VENTURA TRANS AND SERVICES (M) SDN. BHD.<br>
                    </p>
                </td>
            </tr>
        </table>
        <div><p>NOTE: THIS IS COMPUTER GENERATED PRINTOUT AND NO SIGNATURE IS REQUIRED<br></p></div>
</div>

</html>