@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Your trips:</div>
                    <div class="panel-body">
                        @if (session('message'))
                            <div class="alert alert-success">
                                <p>{{ session('message') }}</p>
                            </div>
                        @endif
                        @forelse($trips as $trip)
                            <a class="list-group-item" href="#"
                               data-toggle="modal" data-target="#gpxModal"
                               data-gpx="media/trips/{{ $trip->file }}">
                                {{ $trip->name }}
                                <span class="pull-right text-muted">{{ date('d-m-Y', strtotime($trip->created_at)) }}</span>
                            </a>
                        @empty
                            <p>Sorry, you have no trips yet.</p>
                            <p><a href="/trips/create">Create new trip</a></p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="gpxModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"></h4>

                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div id="map" style="max-width: 570px; height: 400px; "></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

        var map;

        $(function(){

            $("#gpxModal").on("shown.bs.modal", function (e) {
                var element = $(e.relatedTarget);
                $('.modal-title', '#gpxModal').text(element.text());
                initializeMap(element.data('gpx'));
            });

        });

        function initializeMap(gpxFile) {
            var mapOptions = {
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            google.maps.event.trigger(map, "resize");
            loadGPXFileIntoGoogleMap(gpxFile);
        };

        function loadGPXFileIntoGoogleMap(filename) {
            $.ajax({url: filename,
                dataType: "xml",
                success: function(data) {
                    var parser = new GPXParser(data, map);
                    parser.setTrackColour("#ff0000");
                    parser.setTrackWidth(5);
                    parser.setMinTrackPointDelta(0.001);
                    parser.centerAndZoom(data);
                    parser.addTrackpointsToMap();
                    parser.addWaypointsToMap();
                }
            });
        }

    </script>
@endsection