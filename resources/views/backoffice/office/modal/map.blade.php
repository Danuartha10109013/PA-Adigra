<div class="modal fade" id="map-">
    <div class="modal-dialog">
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
                        .bindPopup('Lokasi Kantor Cabang A')
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