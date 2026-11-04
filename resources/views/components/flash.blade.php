{{-- Messages flash (session success / error / message) affichés sous forme de toasts animés --}}
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
    @foreach (['success' => 'success', 'message' => 'success', 'error' => 'danger'] as $key => $type)
        @if (session($key) && !(session('openModal') && $key === 'success'))
            <div class="toast app-toast align-items-center text-bg-{{ $type }} border-0" role="alert" data-autoshow>
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas {{ $type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' }} me-2"></i>
                        {{ session($key) }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    @endforeach
</div>
