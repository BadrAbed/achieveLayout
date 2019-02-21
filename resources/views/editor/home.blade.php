



@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                            <div id="piechart"></div>

                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                            <script type="text/javascript">
                                // Load google charts
                                google.charts.load('current', {'packages':['corechart']});
                                google.charts.setOnLoadCallback(drawChart);

                                // Draw the chart and set the chart values
                                function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Task', 'Hours per Day'],
                                        ['تحت الانشاء', {{$underCreate}}],
                                        ['تم الرفض', {{$refused}}],
                                        ['تم النشر', {{$published}}],
                                        ['تحت المراجعه', {{$underReview}}],

                                    ]);

                                    // Optional; add a title and set the width and height of the chart
                                    var options = {'title':'حاله الدروس', 'width':900, 'height':600};

                                    // Display the chart inside the <div> element with id="piechart"
                                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                    chart.draw(data, options);
                                }
                            </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
