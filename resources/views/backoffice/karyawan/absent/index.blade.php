@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Absen Hari Ini</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Absen Hari Ini</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Absen</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" absent="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" absent="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        
                        <div class="col-md-4 mb-3">
                            <form action="/backoffice/absent/store" method="POST">
                                @csrf
                                <div class="card card-outline card-primary bg-light">
                                    <div class="card-body">

                                        <input type="hidden" id="latitude" name="latitude" class="form-control">
                                        <input type="hidden" id="longitude" name="longitude" class="form-control">

                                        @if ($absentToday)
                                            @if ($absentToday->status != 'Absen')
                                                <select name="shift_id" class="form-control" disabled>
                                                    <option value="">-- Tidak ada shift --</option>
                                                </select>
                                            @elseif ($absentToday->start)
                                                <input type="text" name="shift_id" value="Shift {{ $absentToday->shift->name }} | {{ $absentToday->shift->start }} - {{ $absentToday->shift->end }}" disabled class="form-control">
                                            @endif
                                        @else
                                            <select name="shift_id" class="form-control" required id="shift"
                                                oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Pilihan shift harus diisi')">
                                                <option value="">-- Pilihan Shift --</option>
                                                @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}">Shift {{ $shift->name }} | {{ $shift->start }} - {{ $shift->end }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="card card-outline card-primary bg-light" style="height: 475px">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('images/tekmt.png') }}" class="img-fluid rounded" alt="">
                                        </div>
                                    </div>
                                </div>
                                @if ($absentToday)
                                    @if ($absentToday->start && !$absentToday->end)
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <span class="fa fa-sign-out"></span> Absen Pulang
                                        </button>
                                    @elseif ($absentToday->end)
                                        <button type="button" class="btn btn-success btn-block">
                                            <span class="fa fa-check"></span> Anda Sudah Absen
                                        </button>
                                    @elseif ($absentToday->status != 'Absen')
                                        <button type="button" class="btn btn-success btn-block">
                                            <span class="fa fa-check"></span> Anda sedang {{ $absentToday->status }}
                                        </button>
                                    @endif
                                @else
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <span class="fa fa-sign-in"></span> Absen Masuk
                                    </button>
                                @endif
                            </form>
                        </div>

                        <div class="col-md-8">
                            <div class="card card-outline card-primary bg-light">
                                <div class="card-body">
                                    <b> Hari: {{ \Carbon\Carbon::parse(date('Y-m-d'))->locale('id')->isoFormat('dddd, D
                                        MMMM YYYY') }} <br>
                                        Koordinat Anda: <span id="latitudeSpan"></span>, <span id="longitudeSpan"></span>
                                    </b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-success">
                                        <div class="card-body">
                                            <h3>Absen Masuk</h3>
                                            @if ($absentToday)
                                                @if ($absentToday->start == null)
                                                    @if ($absentToday->status != 'Absen')
                                                        Anda sedang {{ $absentToday->status }}
                                                    @else
                                                        Belum Absen
                                                    @endif
                                                @else
                                                    {{ $absentToday->start }}
                                                @endif
                                            @else
                                                Belum Absen
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning">
                                        <div class="card-body">
                                            <h3>Absen Pulang</h3>
                                            @if ($absentToday)
                                                @if ($absentToday->end == null)
                                                    @if ($absentToday->status != 'Absen')
                                                    Anda sedang {{ $absentToday->status }}
                                                @else
                                                    Belum Absen
                                                @endif
                                                @else
                                                    {{ $absentToday->end }}
                                                @endif
                                            @else
                                                Belum Absen
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info">
                                        <div class="card-body">
                                            <h3>Koordinat Absen</h3>
                                            {{ auth()->user()->office->latitude }}, {{ auth()->user()->office->longitude }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="map" style="height: 400px"></div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
            
            const map = L.map('map').setView([{{ auth()->user()->office->latitude }}, {{ auth()->user()->office->longitude }}], 13);
        
            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
    
            // start marker
            var marker = L.marker([ {{ auth()->user()->office->latitude }} , {{ auth()->user()->office->longitude }} ])
                            .bindPopup('Lokasi kantor')
                            .addTo(map);
                    
            var iconMarker = L.icon({
                iconUrl: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png',
                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [25, 50], // point of the icon which will correspond to marker's location
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });

            // var marker2 = L.marker([ -6.239028847049527 ,  106.79918337392736 ], {
            //     icon: iconMarker,
            //     draggable: false
            // })
            // .bindPopup('Lokasi Anda')
            // .addTo(map);


            // get location user
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log(latitude, longitude);
                document.getElementById('latitudeSpan').innerHTML = latitude;
                document.getElementById('longitudeSpan').innerHTML = longitude;
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;

                var marker2 = L.marker([latitude, longitude], {
                    icon: iconMarker,
                    draggable: false
                })
                .bindPopup('Lokasi Anda')
                .addTo(map);
            });


            // end marker

            // start circle
            var circle = L.circle([ {{ auth()->user()->office->latitude }} ,  {{ auth()->user()->office->longitude }} ], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {{ auth()->user()->office->radius * 2 }}
            }).addTo(map).bindPopup('Radius Kantor');
            // end circle
        
    </script>

</section>

@endsection