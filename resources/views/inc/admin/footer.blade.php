@push('styles')
<style>
    /* Small Screens (mobile) */
    @media (max-width: 575.98px) {
        .navLink {
            font-size: 12px;
            padding: 15px 10px !important;
        }
    }

    /* Tablet Screens */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .navLink {
            font-size: 13px;
        }
    }

    /* Large Screens */
    @media (min-width: 992px) {
        .navLink {
            font-size: 14px;
        }
    }
</style>
@endpush

<footer class="container border-top p-3 text-center navLink mt-5">Abstore . 2026</footer>