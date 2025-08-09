@php
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    // Fetch active notifications from database
    $activeNotifications = DB::table('notifications')
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->get();

    // Default notification if none are active
    $defaultNotification = (object) [
        'title'      => 'Welcome Back!',
        'content'    => 'Check here for important updates and announcements.',
        'image'      => null,
        'is_default' => true,
    ];

    // User name for personalization
    $userName = Auth::user()->first_name . ' ' . (Auth::user()->last_name ?? 'User');
@endphp

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title" id="notificationModalLabel">
                    <i class="bi bi-megaphone-fill me-2"></i>
                    {{ $activeNotifications->isNotEmpty() ? 'Latest Notifications' : $defaultNotification->title }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                @if($activeNotifications->isNotEmpty())
                    <!-- Carousel for multiple notifications -->
                    <div id="notificationCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-3">
                            @foreach($activeNotifications as $index => $notification)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="container-fluid px-0">
                                        <div class="card border-0">
                                            <div class="blog-box blog-list row g-0">
                                                
                                                <!-- Notification Image -->
                                                @if($notification->image)
                                                <div class="col-md-5">
                                                    <img class="img-fluid w-100 h-100 object-fit-cover" 
                                                         src="{{ asset('storage/'.$notification->image) }}" 
                                                         alt="{{ $notification->title }}">
                                                </div>
                                                @else
                                                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-megaphone text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                                @endif

                                                <!-- Notification Details -->
                                                <div class="col-md-7">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-primary">
                                                                {{ Carbon::parse($notification->created_at)->format('d F Y') }}
                                                            </span>
                                                            <small class="text-muted">
                                                                {{ Carbon::parse($notification->created_at)->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                        
                                                        <h3 class="card-title mb-3">{{ $notification->title }}</h3>
                                                        <div class="card-text mb-4">{{ $notification->content }}</div>
                                                        
                                                        @if($notification->link)
                                                            <a href="{{ $notification->link }}" 
                                                               class="btn btn-primary" 
                                                               target="_blank">
                                                                Learn More <i class="bi bi-arrow-right ms-1"></i>
                                                            </a>
                                                        @endif
                                                        
                                                        <div class="mt-3 pt-2 border-top">
                                                            <small class="text-muted">
                                                                <i class="bi bi-person-fill me-1"></i>
                                                                Don't miss it, {{ $userName }}!
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Carousel Controls -->
                        @if($activeNotifications->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#notificationCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#notificationCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    <!-- Default message -->
                    <div class="alert alert-info mb-0 rounded-0 rounded-bottom-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                            <div>{{ $defaultNotification->content }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
                </button>
                @if($activeNotifications->isNotEmpty())
                    <button type="button" class="btn btn-outline-primary" id="markAllAsRead">
                        <i class="bi bi-check2-all me-1"></i> Mark All as Read
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript to show modal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if we should show the notification
        function shouldShowNotification() {
            // Only show on dashboard
            if (!window.location.pathname.includes('dashboard')) {
                return false;
            }
            
            // Check if user has dismissed it
            const lastDismissed = localStorage.getItem('notificationLastDismissed');
            if (lastDismissed) {
                const dismissedDate = new Date(parseInt(lastDismissed));
                const now = new Date();
                // Only show again after 24 hours
                return (now - dismissedDate) > (1 * 60 * 60 * 1000);
            }
            
            return true;
        }

        if (shouldShowNotification()) {
            setTimeout(() => {
                const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
                notificationModal.show();
                
                // Remember when user dismisses the modal
                document.getElementById('notificationModal').addEventListener('hidden.bs.modal', function() {
                    localStorage.setItem('notificationLastDismissed', Date.now().toString());
                });
            }, 3000); // Show after 3 seconds
        }
        
        // Mark all as read functionality
        document.getElementById('markAllAsRead')?.addEventListener('click', function() {
            fetch('', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('notificationModal'));
                    modal.hide();
                    // Optional: Show success message
                    alert('All notifications marked as read!');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>