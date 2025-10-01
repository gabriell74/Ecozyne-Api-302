<div class="col-md-6 d-flex align-items-center mb-3">
    <img src="hadiah-{{ strtolower($name) }}.png" alt="{{ $name }}" style="width: 50px; height: 50px;" class="me-3">
    <div>
        <p class="mb-0"><strong>{{ $name }}</strong></p>
        <small class="text-primary">{{ $points }} Poin</small>
    </div>
    <div class="ms-auto">
        <i class="fas fa-trash-alt text-secondary"></i>
    </div>
</div>