@if (session()->has('message'))
    <div class="alert alert-dark border-0 bg-dark alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="font-35 text-white"><i class='bx bx-bell'></i>
            </div>
            <div class="ms-3">
                <h6 class="mb-0 text-white">{{ session('message') }}</h6>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
