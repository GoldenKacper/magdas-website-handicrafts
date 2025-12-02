<section id="authSection" class="auth-section" aria-label="{{ __('admin/messages.section_auth_bg_alt') }}"
    style="background-image: url('{{ Vite::asset('resources/images/magdas_website_admin_auth_bg_02_12_2025.jpg') }}');">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- here will be the content passed from views --}}
                {{ $slot ?? '' }}

            </div>
        </div>
    </div>
</section>
