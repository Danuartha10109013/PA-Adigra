<div class="modal fade" id="adjust-{{ $submission->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Penyesuaian Pengajuan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="callout callout-info">
                            <b>Keterangan ditolak sebelumnya: </b> {{ $submission->status_description }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </div>
        </div>
    </div>
</div>
