
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(load_chart_data);

             
      function load_chart_data(){
             $.ajax({
                type: 'GET',
                url: 'chart-book',
                dataType:'json',
                success: function(chart_values){

                    console.log(chart_values);
                    draw_chart(chart_values);

                }
            });

         }


         function draw_chart(chart_values){

                // var arr = [];
           
                // var arr1 =  ['Date', 'Books In', 'Cancel'];
                // arr.push(arr1);

                // var arr = [chart_values];
                

                // document.getElementById("chart_div").innerHTML = chart_values;

                 var data = new google.visualization.DataTable();
                     data.addColumn('string', 'Date');
                     data.addColumn('number', 'Book In');
                     data.addColumn('number', 'Cancel');
                     data.addRows(chart_values);


                 var options = {
                      title: 'Monthly Booking',
                      hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
                      vAxis: {minValue: 0},
                      chartArea: {
                              width: '74%',
                              height: '70%'
                            },
                      animation: {
                             startup: true,
                             duration: 2
                             }
                    }; 

                 var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                 chart.draw(data, options); 

         }

       // setInterval(updateChartData, 10000);

  //       window.addEventListener('resize', function() {
  //       chart.draw(data, options);
  // });
    


      

