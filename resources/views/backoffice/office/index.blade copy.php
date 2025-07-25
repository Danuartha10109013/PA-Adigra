@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Kantor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Kantor</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <div class="card">
                <div class="card-header text-center">
                    <img src="{{ asset('images/office-default.jpg') }}" class="card-img-top" style="width: 80%; height:
            200px" alt="...">
            <p><b>Kantor</b></p>
        </div>
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                additional content. This content is a little bit longer.</p>
        </div>
    </div> --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Kantor</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add"
                    title="Tambah">
                    <i class="fa fa-add"></i> Tambah
                </button>
                @include('backoffice.office.modal.add')
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" office="alert">
                <strong>Berhasil </strong>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                @foreach ($offices as $office)
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">{{ $office->name }}</h3>
                            <div class="card-tools">
                                {{-- <a href="/backoffice/news/{{ $news->id }}/detail" class="btn btn-tool btn-sm"
                                title="Detail">
                                <i class="fa fa-eye"></i>
                                </a>
                                <a href="/backoffice/news/{{ $news->id }}/edit" class="btn btn-tool btn-sm"
                                    title="Detail">
                                    <i class="fa fa-edit"></i>
                                </a> --}}
                                {{-- <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                                data-target="#detail-{{ $office->id }}" title="Detail">
                                <span><i class="fa fa-eye"></i></span>
                                </button> --}}
                                <a href="/backoffice/office/{{ $office->id }}/detail" class="btn btn-tool btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                    data-target="#edit-{{ $office->id }}" title="Ubah">
                                    <span><i class="fa fa-edit"></i></span>
                                </button>
                                @if ($office->users->count() == 0)
                                <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                    data-target="#delete-{{ $office->id }}" title="Hapus">
                                    <span><i class="fa fa-trash"></i></span>
                                </button>
                                @endif
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                @if ($office->image)
                                <img src="{{ asset('storage/' . $office->image) }}" class="card-img-top"
                                    style="width: 80%; height: 200px" alt="...">
                                @else
                                <img src="{{ asset('images/office-default.jpg') }}" class="card-img-top"
                                    style="width: 80%; height: 200px" alt="...">
                                @endif
                                <p>{{ $office->address }}</p>
                            </div>
                            <ul>
                                <li>Koordinat: {{ $office->latitude }}, {{ $office->longitude }}</li>
                                <li>Radius(meter): {{ $office->radius }}</li>
                                {{-- <li>Koordinat: -6.25669089852724, 106.79641151260287</li>
                                            <li>Radius(meter): 20</li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- modal --}}
            @foreach ($offices as $office)
            @include('backoffice.office.modal.edit')
            @include('backoffice.office.modal.delete')
            @endforeach

        </div>

    </div>
    </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <div class="card">
                <div class="card-header text-center">
                    <img src="{{ asset('images/office-default.jpg') }}" class="card-img-top" style="width: 80%; height:
            200px" alt="...">
            <p><b>Kantor / QR Code</b></p>
        </div>
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                additional content. This content is a little bit longer.</p>
        </div>
    </div> --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Kantor / QR Code</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#edit-{{ $office->id }}" title="Ubah">
                    <span><i class="fa fa-edit"></i></span>
                </button>
                {{-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#add" title="Tambah">
                            <i class="fa fa-add"></i> Tambah
                        </button>
                        @include('backoffice.office.modal.add') --}}

            </div>
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" office="alert">
                <strong class="ml-2 mr-2">Berhasil </strong> | {{ session('success') }}
                <button type="button" class="close" style="margin-top: -17px" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="text-center">
                                @if ($office->image)
                                <img src="{{ asset('storage/' . $office->image) }}" class="card-img-top"
                                    style="width: 80%; height: 300px" alt="...">
                                @else
                                <img src="{{ asset('images/office-default.jpg') }}" class="card-img-top"
                                    style="width: 80%; height: 300px" alt="...">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="text-center">
                                <div id="map" style="height: 300px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detail Kantor</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Nama Kantor</b></p>
                                    <p>{{ $office->name }}</p>
                                    <p><b>Alamat Kantor</b></p>
                                    <p>{{ $office->address }}</p>
                                    <p><b>Koordinat Kantor</b></p>
                                    <p>{{ $office->latitude }}, {{ $office->longitude }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Jam Masuk</b></p>
                                    <p>{{ $shift->start }}</p>
                                    <p><b>Jam Pulang</b></p>
                                    <p>{{ $shift->end }}</p>
                                    <p><b>Radius</b></p>
                                    <p>{{ $office->radius }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @foreach ($offices as $office)
                            <div class="col-md-4">
                                <div class="card card-outline card-primary">
                                    <div class="card-header text-center">
                                        <h3 class="card-title">{{ $office->name }}</h3>
                <div class="card-tools">
                    <a href="/backoffice/office/{{ $office->id }}/detail" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#edit-{{ $office->id }}" title="Ubah">
                        <span><i class="fa fa-edit"></i></span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    {!! QrCode::size(300)->generate($office->qrcode) !!}
                    <hr>
                    <p>{{ $office->address }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach --}}
    </div>

    @include('backoffice.office.modal.edit')
    {{-- modal --}}
    {{-- @foreach ($offices as $office)
                        @include('backoffice.office.modal.edit')
                        @include('backoffice.office.modal.delete')
                    @endforeach --}}

    </div>

    </div>
    </div>
    </div>

    <div class="row justify-content-center">
        {{-- <div class="col-md-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Kantor</h3>

                    <div class="card-tools">
                        <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#tambah">
                            <span class="fa fa-plus"></span> Tambah
                        </button>

                        @if ($errors->any())
                        <script>
                            jQuery(function() {
                                        $('#tambah').modal('show');
                                    });
                        </script>
                        @endif

                        @include('backoffice.master-data.Kantor.modal.add')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" Kantor="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <table class="table table-bordered table-hover text-center" id="example1">
        <thead>
            <tr>
                <th>#</th>
                <th>Kantor</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            @foreach($offices as $key => $office)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $office->name }}</td>
                <td>{{ $office->start }}</td>
                <td>{{ $office->end }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-{{ $office->id }}"
                        title="Ubah">
                        <i class="fa fa-edit"></i> Ubah
                    </button>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $office->id }}"
                        title="Hapus">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($offices as $office)
    @include('backoffice.master-data.Kantor.modal.edit')
    @include('backoffice.master-data.Kantor.modal.delete')
    @endforeach

    </div>

    </div>

    </div> --}}
    {{-- <div class="col-md-12">
            <div id="map" style="height: 400px"></div>
        </div> --}}
    </div>

</section>

{{-- <script>
    const map = L.map('map').setView([51.505, -0.09], 13);
    
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    
        const marker = L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('<b>Hello world!</b><br />I am a popup.').openPopup();
    
        const circle = L.circle([51.508, -0.11], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(map).bindPopup('I am a circle.');
    
        const polygon = L.polygon([
            [51.509, -0.08],
            [51.503, -0.06],
            [51.51, -0.047]
        ]).addTo(map).bindPopup('I am a polygon.');
    
    
        const popup = L.popup()
            .setLatLng([51.513, -0.09])
            .setContent('I am a standalone popup.')
            .openOn(map);
    
        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent(`You clicked the map at ${e.latlng.toString()}`)
                .openOn(map);
        }
    
        map.on('click', onMapClick);
    
</script> --}}

{{-- <script>
    const map = L.map('map').setView([-6.239028847049527, 106.79918337392736], 13);
    
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // start marker
        var marker = L.marker([-6.239028847049527, 106.79918337392736])
                        .bindPopup('Tampilan pesan disini')
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
        .bindPopup('homebase')
        .addTo(map);
        // end marker

        // start circle
        var circle = L.circle([-6.239028847049527, 106.79918337392736], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(map).bindPopup('I am a circle.');
        // end circle
    
</script> --}}

<script>
    const map = L.map('map').setView([{{ $office->latitude }}, {{ $office->longitude }}], 13);
    
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // start marker
        var marker = L.marker([{{ $office->latitude }}, {{ $office->longitude }}])
                        .bindPopup('Tampilan pesan disini')
                        .addTo(map);
        // end marker

        // start circle
        var circle = L.circle([{{ $office->latitude }}, {{ $office->longitude }}], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: {{ $office->radius * 2 }}
        }).addTo(map).bindPopup('I am a circle.');
        // end circle
    
</script>

@endsection
