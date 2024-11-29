<div class="modal fade" id="reject-{{ $submission->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/submission/cuti/{{ $submission->id }}/reject" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Tolak Pengajuan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <p>Apakah anda yakin tolak pengajuan?</p>
                            <div class="callout callout-info">
                                <textarea name="status_description" class="form-control" placeholder="Masukan alasan tolak pengajuan" required
                                oninvalid="this.setCustomValidity('Masukan alasan tolak pengajuan')" oninput="this.setCustomValidity('')"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
