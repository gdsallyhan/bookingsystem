@section('chart')
    
  <!-- <div id="chart_div" style="width: 100%; height: 500px;"></div>
    
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Books In', 'Cancel'],
            <?php //echo $data; ?>
        ]);

        var options = {
          title: 'Monthly Booking',
          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script> -->
  

@endsection

