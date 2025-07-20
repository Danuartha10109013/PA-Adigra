<div class="modal fade" id="description-{{ $submission->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alasan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="callout callout-info">
                <h5><strong>Description:</strong></h5>
                <p>{{ $submission->description }}</p>
            </div>
            
            <!-- Check if the file (bukti) exists -->
            @if($submission->bukti)
                <div class="mt-3">
                    <label for="surat-cuti"><strong>Surat Cuti:</strong></label>
                    
                    <!-- Check file type and display accordingly -->
                    @php
                        $fileExtension = pathinfo($submission->bukti, PATHINFO_EXTENSION);
                    @endphp
                    
                    @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                        <!-- Display image if it's an image file -->
                        <div class="text-center">
                            <img src="{{ Storage::url($submission->bukti) }}" alt="Surat Cuti" class="img-fluid rounded shadow" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    @else
                        <!-- Provide download link for other file types -->
                        <div class="mt-3">
                            <a href="{{ Storage::url($submission->bukti) }}" class="btn btn-primary" download>
                                <i class="fas fa-download"></i> Download Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="mt-3">
                    <p>No Surat Cuti uploaded.</p>
                </div>
            @endif
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
