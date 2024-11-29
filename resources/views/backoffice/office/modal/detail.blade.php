<div class="modal fade" id="detail-{{ $office->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lokasi Map</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div id="map" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
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
    
</script>