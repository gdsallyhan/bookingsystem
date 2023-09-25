//global variable
var total_global = 0;
var pass_total_price = 0;
var p_carry_id;
var d_carry_id;


//function dropdown car_category with trip
$(document).ready(function() {

    $("#car-cat-dropdown").on('change', function() {

        $("#total_price").val('');
        $("#options")[0].selectedIndex = 0;
        $("#trip-dropdown").empty();
        $("#hidden-pickup").hide();
        $("#hidden-delivery").hide();
        // $("#hidden-ship").hide();


        var carCat_id = $(this).val();

        $.ajax({
        url:"/admin/booking/fetch_trip/" + carCat_id,
        type:"GET",
        
        success:function (data) {

            console.log(data);
            $("#trip-dropdown").empty();
            $("#ship-dropdown").empty();
            $("#pickup-dropdown").empty();
            $("#delivery-dropdown").empty()

            
            var trip_loc = data;
            var str = "<option value = '' disabled selected> PLEASE SELECT </option>";


                for(t=0; t<trip_loc.length; t++){
                      
                      str = str + "<option value='"+ trip_loc[t].trip_id + "'>" + trip_loc[t].trip_from +" - " + trip_loc[t].trip_to +" (RM" + trip_loc[t].price +") </option>" 
                } 

                $("#trip-dropdown").append(str);
         }})
        
    });
});


//function dropdown trip with shipment date
$(document).ready(function() {

    $("#trip-dropdown").on('change', function() {

        // $("#options")[0].selectedIndex = 0;
        $("#options").val(0);
        $("#ship-dropdown").empty();
        $("#hidden-pickup").hide();
        $("#hidden-delivery").hide();

        var trip_id = $(this).val();

        $.ajax({
        url:"/admin/booking/fetch_ship/" + trip_id,
        type:"GET",
        
        success:function (data) {

            console.log(data);
            $("#ship-dropdown").empty();
            $("#pickup-dropdown").empty();
            $("#delivery-dropdown").empty();

            
            var ship_date = data;
            var str = "<option value = '' disabled selected> PLEASE SELECT </option>";

            var str1 = "<option value = '' disabled selected> NO SELECTION AVAILABLE </option>";


        if(data.length > 1){

             for(s=1; s<ship_date.length; s++){

                    str = str + "<option value = '" + ship_date[s].ship_id + "'>" + ship_date[s].ship_date +" - " + ship_date[s].ship_name +" " + ship_date[s].ship_number +" (" + ship_date[s].ship_from +" - " + ship_date[s].ship_to  + ") </option>"
                      
                    category_price = ship_date[0].price;

                } 


        }else{

            str = str + "<option value = '' disabled selected>NO DATE AVAILABLE</option>";

            category_price = 0;

        }               
                $("#total_price").val('');
                $("#ship-dropdown").append(str);
                $("#pickup-dropdown").append(str1);
                $("#delivery-dropdown").append(str1);

         }})
        
    });
});


$("#pickup-carrier").on('change', function() {

    p_carry_id = $(this).val();

    triggerCustomEvent();

});


$("#delivery-carrier").on('change', function() {

    d_carry_id = $(this).val();

    triggerCustomEvent();

});


function triggerCustomEvent() {
  if (p_carry_id !== undefined || d_carry_id !== undefined) {
    $('#ship-dropdown').trigger('change', [p_carry_id, d_carry_id]);
  }
}
   

$(document).ready(function() {

    $("#ship-dropdown").on('change', function(event,p_carry_id, d_carry_id) {
        
        var ship_id = $(this).val();

        var pick_carry_id = p_carry_id;

        var deliver_carry_id = d_carry_id;

        let array_ship_carry = [ship_id,pick_carry_id,deliver_carry_id];
           
            $.ajax({
            url:"/admin/booking/fetch_dd/" + array_ship_carry,
            type:"GET",
            
            success:function (data) {

                console.log(data);
                $("#pickup-dropdown").empty();
                $("#delivery-dropdown").empty();

                var p_loc = data;
                var str_pickup = "<option value = '' disabled selected> PLEASE SELECT </option>";
                var str_delivery = "<option value = '' disabled selected> PLEASE SELECT </option>";



                    for(p=0; p<p_loc.pickup.length; p++){

                       str_pickup = str_pickup +"<option value= '"+ p_loc.pickup[p].pickup_id + "'>" + p_loc.pickup[p].pickup +"  (" + p_loc.pickup[p].pickup_state +") - RM" + p_loc.pickup[p].pickup_price +"</option>"
                        
                        pickup_price = p_loc.pickup[p].pickup_price;
                       
                    }

                     $("#pickup-dropdown").append(str_pickup);
                     
                        

                    for(d=0; d<p_loc.delivery.length; d++){

                        str_delivery = str_delivery + "<option value='"+ p_loc.delivery[d].delivery_id + "'>" + p_loc.delivery[d].delivery +"  (" + p_loc.delivery[d].delivery_state +") - RM" + p_loc.delivery[d].delivery_price +"</option>"
                        
                        delivery_price = p_loc.delivery[d].delivery_price;
                    }   

                    $("#delivery-dropdown").append(str_delivery);
                    
             }})

        });

        });
            
// });

// });

       


$(document).ready(function(e) {


    $("#options").off('change').on('change', function() {

        var opt_id = $(this).val();
             
        $("#pickup-dropdown")[0].selectedIndex = 0;
        $("#delivery-dropdown")[0].selectedIndex = 0;
     
         if (opt_id == '1'){ //port to port

         $("#hidden-pickup").hide();
         $("#hidden-delivery").hide();
        
             pickup_price = 0;
             delivery_price = 0;

             price_calculation(category_price,pickup_price,delivery_price);

       

        }else if (opt_id == '2') //port to door

         {
            $('#pickup-dropdown').attr("disabled","disabled");
            $('#delivery-dropdown').removeAttr('disabled');
            $("#hidden-pickup").hide();
            $("#hidden-delivery").show();
            $("#delivery-dropdown")[0].selectedIndex = 0;

            price_calculation(category_price,0,0,0);


            // $("#pickup-carrier").on('change', function() {

            //     var p_carry_id = $(this).val();
            //     $('#value_pickup_carrier').trigger('val',[p_carry_id]);

            //  });


            $("#delivery-dropdown").on('change', function(){

                    var delprice_id = $(this).val();

                    pickup_price = 0;

                     $.ajax({
                        url:"/admin/booking/deliveryPrice/" + delprice_id,
                        type:"GET",
        
                        success:function (data) {

                              console.log(data)

                              delivery_price = data.price;
                              price_calculation(category_price,pickup_price,delivery_price);

                        }});

                }); 


         }else if (opt_id == '3') //door to port

         {
            $('#pickup-dropdown').removeAttr('disabled');
            $('#delivery-dropdown').attr("disabled","disabled");
            $("#hidden-pickup").show();
            $("#hidden-delivery").hide();

            price_calculation(category_price,0,0,0); 

            // $("#delivery-carrier").on('change', function() {

            //     var p_carry_id = $(this).val();
            //     $('#value_delivery_carrier').trigger('val',[d_carry_id]);

            //  });


            $("#pickup-dropdown").on('change', function(){

                     var pickprice_id = $(this).val();

                     delivery_price = 0;


                     $.ajax({
                        url:"/admin/booking/pickupPrice/" + pickprice_id,
                        type:"GET",
        
                        success:function (data) {

                            console.log(data)

                            pickup_price = data.price;
                            price_calculation(category_price,pickup_price,delivery_price);

                        }});

                });

         } else if (opt_id == '4') //door to door

         {
            $('#pickup-dropdown').removeAttr('disabled');
            $('#delivery-dropdown').attr("disabled","disabled");
            $("#hidden-pickup").show();
            $("#hidden-delivery").show();
            price_calculation(category_price,0,0,0); 

              //if user select option 4    
              
                $("#pickup-dropdown").on('change', function(){
               
                     var pick_price_id = $(this).val();

                     $.ajax({
                        url:"/admin/booking/pickupPrice/" + pick_price_id,
                        type:"GET",
        
                        success:function (data) {

                             $("#delivery-dropdown")[0].selectedIndex = 0;

                            ppickup_price = data.price;

                             price_calculation(category_price,ppickup_price,0);

                        }});

                    $('#delivery-dropdown').removeAttr('disabled');

                     
                });


                $("#delivery-dropdown").on('change', function(){

                    var del_price_id = $(this).val();


                     $.ajax({
                        url:"/admin/booking/deliveryPrice/" + del_price_id,
                        type:"GET",
        
                        success:function (data) {

                              ddelivery_price = data.price;

                              price_calculation(category_price,ppickup_price,ddelivery_price);

                        }});
                });
         } 


        $('#customSwitches').prop('checked',false);
        $("#marine-dropdown").hide();
        $("#market_value")[0].selectedIndex = 0;
        price_calculation(category_price,0,0,0); 
        e.preventDefault();  
            
    });
     
});


$(document).ready(function(){
    $("#customSwitches").on("change", function(e) {
    const isOn = e.currentTarget.checked;
    
    if (isOn) {
        $("#marine-dropdown").show();

          $("#market_value").on('change', function(){

            var market_val_id =$(this).val();

            $.ajax({
                url:"/admin/booking/insurancePrice/" + market_val_id,
                type:"GET",

                success:function (data) {

                     console.log(data);

                     if(data == ""){
                        insuran_price = 0;

                     }else{
                        insuran_price = data.insurance_price;
                     }

                     includes_insurance(insuran_price,total_global);
                     
                }});

         });

    } else {

        $("#marine-dropdown").hide();
        // $("#market_value").val(0);
        $("#market_value")[0].selectedIndex = 0;
        insuran_price = 0;
        includes_insurance(insuran_price,total_global);

    }

  });
});


$(document).ready(function () {
       $("#discount").on("change",function()
            { 
                var discount = $(this).val();
                price_after_discount(discount,pass_total_price);
            });
            
});


function price_calculation(a,b,c){

    var total = parseFloat(a) + parseFloat(b) + parseFloat(c);
    var total_textbox = document.getElementById("total_price");
    total_textbox.value = currency(total, { symbol: 'RM', decimal: '.', separator: ',' }).format();
    total_global = total;

}


function  includes_insurance(a, b){

    var total_price =  parseFloat(a) + parseFloat(b)
    var total_textbox = document.getElementById("total_price");
    total_textbox.value = currency(total_price, { symbol: 'RM', decimal: '.', separator: ',' }).format();
    pass_total_price = total_price;

}


// function price_after_discount(a,b){

//     var after_discount = parseFloat(b) - parseFloat(a);

//     var price_after_textbox = document.getElementById("price_after");

//     price_after_textbox.value = after_discount;
// }


$(document).ready(function () {
       $('#butt_vGeran').on("click",function()
            { 
                $(this).text($(this).text() == 'View Grant' ? 'Hide Grant' : 'View Grant');
                $('#view_geran').toggle();
            });
            
});

$(document).ready(function () {
       $('#butt_vLoan').on("click",function()
            {  
                $(this).text($(this).text() == 'View Bank Letter' ? 'Hide Bank Letter' : 'View Bank Letter');
                $('#view_loan').toggle();
            });
            
});



$(document).ready(function(){
      $('butt_cID').click(function()
      {
        $('view_ID').toggle();
  });
});

$(document).ready(function() {

    $("#cust-dropdown").on('change', function() {

        var carCat_id = $(this).val();

        $.ajax({
        url:"/admin/booking/fetch_cust/" + carCat_id,
        type:"GET",
        
        success:function (data) {

            console.log(data);

            var id_textbox = document.getElementById("cust-id");
            var name_textbox = document.getElementById("cust-name");
            var phone_textbox = document.getElementById("cust-phone");
            var email_textbox = document.getElementById("cust-email");
            var ic_textbox = document.getElementById("cust-ic");
            
            if (data == ""){

                $("#custname").show();
                
                id_textbox.value = '';
                name_textbox.value = '';
                phone_textbox.value = '';
                email_textbox.value = '';
                ic_textbox.value = '';

            }else{

                $("#custname").hide();

                id_textbox.value = data.id;
                name_textbox.value = data.name;
                phone_textbox.value = data.phone;
                email_textbox.value = data.email;
                ic_textbox.value = data.ic;

            }
           
                
         }})
        
    });

});

//function dropdown model with trip
$(document).ready(function() {

    $("#make-dropdown").on('change', function() {

        var model_make = $(this).val();

        $.ajax({
        url:"/admin/booking/fetch_model/" + model_make,
        type:"GET",
        
        success:function (data) {

            console.log(data);

            if (data != ""){

                $("#insert-vehicle").hide();
                $("#model-dropdown").empty();

                var fetch_model = data;
                var str = "<option value = '' disabled selected> PLEASE SELECT </option>";
               
                    for(m=0; m<fetch_model.length; m++){
                          
                          str = str + "<option value='"+ fetch_model[m].id + "'>" + fetch_model[m].year +" - " + fetch_model[m].make +"&nbsp;" + fetch_model[m].model + "</option>" 
                    } 
    
                $("#model-dropdown").append(str);
                $('#model-dropdown').removeAttr('disabled');
           
            }else{

                $("#insert-vehicle").show();
                $("#model-dropdown")[0].selectedIndex = 0;
                $('#model-dropdown').attr('disabled', 'disabled');
                
            }   
            
            

                
         }})
        
    });
});









    




