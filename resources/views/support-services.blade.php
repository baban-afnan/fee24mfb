<x-app-layout>
    <x-slot name="title">Customer Care Support</x-slot>

    <div class="container-fluid p-0">

        <!-- Hero Section -->
        <div class="position-relative" style="height: 80vh; background: url('{{ asset('assets/images/knowledgebase/bg_2.png') }}') center/cover no-repeat;">
            <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3">

                <!-- Title -->
                <h2 class="text-primary fw-bold mb-4 shadow-text">How Can We Help You Today?</h2>

                <!-- Search Bar -->
                <form class="d-flex justify-content-center mb-4" action="#" method="get">
                    <div class="input-group shadow-sm" style="max-width: 600px; width: 100%;">
                        <span class="input-group-text bg-white border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input class="form-control border-0 py-2" type="text" placeholder="Type your question here..." />
                        <button class="btn btn-primary px-4" type="submit">Search</button>
                    </div>
                </form>

                <!-- Social Support Buttons -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                    <a href="{{ route('support') }}" class="btn text-white px-3 py-2" style="background-color: #25D366; border-radius: 8px;">
                        <i class="fab fa-whatsapp fa-lg me-2"></i> WhatsApp
                    </a>
                    <a href="#" target="_blank" class="btn text-white px-3 py-2" style="background-color: #0084FF; border-radius: 8px;">
                        <i class="fab fa-facebook-messenger fa-lg me-2"></i> Messenger
                    </a>
                    <a href="mailto:fee24mfb@gmail.com" class="btn text-white px-3 py-2" style="background-color: #35130fff; border-radius: 8px;">
                        <i class="fas fa-envelope me-2"></i> Email
                    </a>
                    <a href="tel:+2347088881690" class="btn text-white px-3 py-2" style="background-color: #c3d6ddff; border-radius: 8px;">
                        <i class="fas fa-phone-alt me-2"></i> Call
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .shadow-text {
            text-shadow: 0 2px 4px rgba(0,0,0,0.4);
        }

        @media (max-width: 576px) {
            .input-group {
                flex-direction: column;
            }
            .input-group .form-control {
                border-radius: 0;
            }
            .input-group .btn {
                width: 100%;
                border-radius: 0;
            }
        }
    </style>
</x-app-layout>
