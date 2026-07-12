@extends('layouts.navbar.main')

@section('content')
    <div class="bg-primary text-white py-5 mb-5">
        <div class="container text-center">
            <h1 class="fw-bold mb-3">Temui Tim Medis Kami</h1>
            <p class="lead mb-0">Dokter spesialis berpengalaman yang siap membantu menjaga kesehatan Anda dan keluarga.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-lg-6">
                <div class="input-group shadow-sm rounded-pill overflow-hidden">
                    <span class="input-group-text bg-white border-0 ps-4">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="search" class="form-control border-0 py-3" id="search-doctor"
                        placeholder="Cari nama dokter atau spesialisasi...">
                </div>
            </div>
        </div>

        <div id="loading-indicator" class="text-center py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
            <p class="text-muted mt-3">Memuat data dokter...</p>
        </div>

        <div class="row" id="doctors-container" style="display: none;"></div>
    </div>

    <style>
        .doctor-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 1rem;
        }

        .doctor-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
        }

        .doctor-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 4px solid #f8f9fa;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            fetchDoctors();

            function fetchDoctors() {
                $.ajax({
                    url: '/api/doctors/fetch',
                    method: 'GET',
                    success: function (response) {
                        if (response.success && response.data.length > 0) {
                            renderDoctors(response.data);
                        } else {
                            showEmptyState();
                        }
                    },
                    error: function () {
                        $('#loading-indicator').html('<div class="alert alert-danger mx-auto" style="max-width: 500px;">Gagal memuat data dokter. Silakan coba beberapa saat lagi.</div>');
                    }
                });
            }

            function renderDoctors(doctors) {
                let container = $('#doctors-container');
                container.empty();

                doctors.forEach(function (doc) {
                    let nameParts = [doc.prefix_name, doc.first_name, doc.middle_name, doc.last_name, doc.suffix_name];
                    let fullName = nameParts.filter(part => part !== null && part !== '').join(' ');

                    let specialtiesHtml = '';
                    if (doc.specialties && doc.specialties.length > 0) {
                        let specialtyNames = doc.specialties.map(s => s.specialty.name).join(', ');
                        specialtiesHtml = `<span class="badge bg-info text-dark mb-2 px-3 py-2 rounded-pill">${specialtyNames}</span>`;
                    } else {
                        specialtiesHtml = `<span class="badge bg-secondary mb-2 px-3 py-2 rounded-pill">Dokter Umum</span>`;
                    }

                    let cardHtml = `
                        <div class="col-md-6 col-lg-4 mb-4 doctor-item">
                            <div class="card h-100 border-0 shadow-sm doctor-card text-center p-3">
                                <div class="card-body d-flex flex-column align-items-center">

                                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm doctor-avatar mb-3" style="font-size: 2.5rem;">
                                        ${doc.first_name.charAt(0).toUpperCase()}
                                    </div>

                                    ${specialtiesHtml}

                                    <h5 class="card-title fw-bold text-dark mt-2 mb-1 doctor-name">${fullName}</h5>

                                    <div class="text-warning mb-3">
                                        <i class="bi bi-star-fill"></i>
                                        <span class="text-dark fw-bold ms-1">${doc.rating_avg !== null ? doc.rating_avg : '0.00'}</span>
                                        <span class="text-muted small">(${doc.rating_count} ulasan)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    container.append(cardHtml);
                });

                $('#loading-indicator').fadeOut(300, function () {
                    $('#doctors-container').fadeIn(500);
                });
            }

            function showEmptyState() {
                $('#loading-indicator').fadeOut(300, function () {
                    $('#doctors-container').html(`
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-person-x text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted">Belum ada data dokter yang tersedia.</h4>
                        </div>
                    `).fadeIn(500);
                });
            }

            $('#search-doctor').on('input', function () {
                let value = $(this).val().toLowerCase();

                $('.doctor-item').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection