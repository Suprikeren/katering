{{--
    Partial SweetAlert reusable untuk notifikasi flash/session.

    Cara pakai:
      - redirect()->with('success', 'Pesan berhasil')
      - redirect()->with('error', 'Pesan gagal')
      - redirect()->with('info', 'Pesan info')
      - redirect()->with('warning', 'Pesan warning')
      - redirect()->with('sweet_alert', ['icon' => 'success', 'title' => 'Judul', 'text' => 'Pesan'])

    Include di layout admin:
      @include('layouts.admins.partials.sweet-alert')
--}}

@php
    $alerts = [];

    foreach (['success', 'error', 'info', 'warning'] as $type) {
        if (session()->has($type)) {
            $alerts[] = [
                'icon' => $type,
                'title' => match ($type) {
                    'success' => 'Berhasil',
                    'error' => 'Gagal',
                    'warning' => 'Perhatian',
                    default => 'Informasi',
                },
                'text' => session($type),
            ];
        }
    }

    if ($custom = session('sweet_alert')) {
        $alerts[] = $custom;
    }
@endphp

@if ($alerts)
    <script>
        (function () {
            var alerts = @json($alerts);

            var fire = function () {
                if (typeof Swal === 'undefined') {
                    setTimeout(fire, 100);
                    return;
                }

                alerts.forEach(function (alert) {
                    Swal.fire({
                        icon: alert.icon || 'info',
                        title: alert.title || '',
                        text: alert.text || '',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#1570ef',
                        zIndex: 9999999,
                    });
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fire);
            } else {
                fire();
            }
        })();
    </script>
@endif
