@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Absen</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Absen</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <!-- Default box -->
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

                    <div class="row">
                        <div class="col-md-4">
                            <form action="/backoffice/absent/store" method="POST">
                                @csrf
                                <div class="card bg-light">
                                    <div class="card-body">
                                        @if ($absentToday)
                                            <input type="text" name="shift_id" value="Shift {{ $absentToday->shift->name }} | {{ $absentToday->shift->start }} - {{ $absentToday->shift->end }}" disabled class="form-control">
                                        @else
                                            <select name="shift_id" class="form-control">
                                                @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}">Shift {{ $shift->name }} | {{ $shift->start
                                                    }} - {{ $shift->end }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="card bg-light" style="height: 475px">
                                    <div class="card-body">

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
                                    @endif
                                @else
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <span class="fa fa-sign-in"></span> Absen Masuk
                                    </button>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-8">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <b> Hari: {{ \Carbon\Carbon::parse(date('Y-m-d'))->locale('id')->isoFormat('dddd, D
                                        MMMM YYYY') }} <br>
                                        Koordinat Anda: -6.25669089852724, 106.79641151260287 </b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-success">
                                        <div class="card-body">
                                            <h3>Absen Masuk</h3>
                                            @if ($absentToday)
                                                {{ $absentToday->start }}
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
                                                    Belum Absen
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
                                            -6.239028847049527, 106.79918337392736
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
        const map = L.map('map').setView([-6.239028847049527, 106.79918337392736], 13);
        
            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
    
            // start marker
            var marker = L.marker([-6.239028847049527, 106.79918337392736])
                            .bindPopup('Kantor')
                            .addTo(map);
                    
            var iconMarker = L.icon({
                iconUrl: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png',
                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [25, 50], // point of the icon which will correspond to marker's location
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });

            var marker2 = L.marker([-6.25669089852724, 106.79641151260287], {
                icon: iconMarker,
                draggable: false
            })
            .bindPopup('Lokasi Anda')
            .addTo(map);
            // end marker

            // start circle
            var circle = L.circle([-6.239028847049527, 106.79918337392736], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 2000
            }).addTo(map).bindPopup('Radius Kantor');
            // end circle
        
    </script>

</section>

@endsection