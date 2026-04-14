@extends('views_frontend.layouts.app')

@section('title', 'Our Team - Game Info')

@section('content')
<style>
    .team-card {
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        border: 1px solid #f0f0f0;
    }
    
    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 24px rgba(227, 33, 36, 0.2); /* Bayangan dengan sedikit warna merah */
        border-color: #e32124; /* Warna border saat di-hover */
        cursor: pointer;
    }

    .team-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-bottom: 3px solid #e32124;
    }

    .team-card-body {
        padding: 20px;
        text-align: center;
    }

    .team-card-title {
        margin: 0 0 10px 0;
        color: #333;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 1.25rem;
    }

    /* Hilangkan garis bawah link default dari Bootstrap saat membungkus card */
    a.team-link {
        text-decoration: none !important;
        color: inherit;
        display: block;
        height: 100%;
    }
</style>

<div class="inner-page-banner">
    <div class="container">
    </div>
</div>
<div class="inner-information-text">
    <div class="container">
        <h3>Our Team</h3>
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="active">Our Team</li>
        </ul>
    </div>
</div>

<section id="contant" class="contant main-heading team">
    <div class="container">
        <div class="row" id="team-container">
            <div class="col-md-12 text-center" style="padding: 50px 0;">
                <h3><i class="fa fa-spinner fa-spin"></i> Loading Teams Data...</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center" id="pagination-container" style="margin-top: 30px;">
                </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Konfigurasi
    const API_URL = "{{ route('team_datas') }}";

    // 2. Variabel State
    let allTeams = [];
    let currentPage = 1;
    const itemsPerPage = 9; // Limit 9 Tim per page (agar pas dibagi 3 kolom)

    // 3. Fetch Data API
    async function fetchTeams() {
        try {
            const response = await fetch(API_URL);
            const data = await response.json();
            
            if (data.success && data.teams) {
                allTeams = data.teams;
                renderPage(currentPage);
            } else {
                showError("Invalid data format received from API.");
            }
        } catch (error) {
            console.error("Fetch error:", error);
            showError("Failed to connect to the server.");
        }
    }

    // 4. Render HTML per Halaman
    function renderPage(page) {
        const container = document.getElementById('team-container');
        container.innerHTML = ''; // Kosongkan container

        // Hitung Index untuk Slice Array
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        const teamsToRender = allTeams.slice(startIndex, endIndex);

        if (teamsToRender.length === 0) {
            container.innerHTML = '<div class="col-md-12"><h3 class="text-center" style="margin-top:50px;">No teams found.</h3></div>';
            document.getElementById('pagination-container').innerHTML = '';
            return;
        }

        // Looping Data Tim menjadi Card
        teamsToRender.forEach(team => {
            // Tentukan Gambar (gunakan image tim dari DB, atau fallback jika null)
            const teamImage = `{{ asset(Storage::url('${team.image}')) }}`;
            
            // Tentukan Link Detail Tim (Siapkan URL untuk layar baru nanti)
            // Asumsi rutenya nanti seperti /team/{id}
            const detailUrl = `{{ url('team') }}/${team.id}`; 
            
            // Hitung jumlah member hanya untuk label statistik
            const memberCount = team.members ? team.members.length : 0;

            let html = `
                <div class="col-md-4 col-sm-6" style="margin-bottom: 30px;">
                    <a href="${detailUrl}" class="team-link">
                        <div class="team-card">
                            <img src="${teamImage}" alt="${team.name}">
                            <div class="team-card-body">
                                <h3 class="team-card-title">${team.name}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            `;
            
            // Suntikkan ke container utama
            container.innerHTML += html;
        });

        // Jalankan fungsi pembuatan tombol paginasi
        renderPaginationControls();
    }

    // 5. Fungsi Pembuat Tombol Pagination
    function renderPaginationControls() {
        const totalPages = Math.ceil(allTeams.length / itemsPerPage);
        const paginationContainer = document.getElementById('pagination-container');
        
        if (totalPages <= 1) {
            paginationContainer.innerHTML = ''; 
            return;
        }

        let html = '<ul class="pagination" style="display: inline-flex; list-style: none; padding:0;">';
        
        // Tombol Prev
        const prevDisabled = currentPage === 1 ? 'pointer-events: none; opacity: 0.5;' : '';
        html += `<li style="margin: 0 5px;"><a href="javascript:void(0)" onclick="changePage(${currentPage - 1})" class="btn btn-default" style="${prevDisabled}">&laquo; Prev</a></li>`;

        // Angka Halaman
        for (let i = 1; i <= totalPages; i++) {
            const activeClass = currentPage === i ? 'btn-primary' : 'btn-default';
            html += `<li style="margin: 0 2px;"><a href="javascript:void(0)" onclick="changePage(${i})" class="btn ${activeClass}">${i}</a></li>`;
        }

        // Tombol Next
        const nextDisabled = currentPage === totalPages ? 'pointer-events: none; opacity: 0.5;' : '';
        html += `<li style="margin: 0 5px;"><a href="javascript:void(0)" onclick="changePage(${currentPage + 1})" class="btn btn-default" style="${nextDisabled}">Next &raquo;</a></li>`;
        
        html += '</ul>';
        paginationContainer.innerHTML = html;
    }

    // 6. Event Saat Tombol Pagination Diklik
    window.changePage = function(page) {
        const totalPages = Math.ceil(allTeams.length / itemsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            renderPage(currentPage);
            document.getElementById('contant').scrollIntoView({ behavior: 'smooth' });
        }
    }

    function showError(message) {
        document.getElementById('team-container').innerHTML = `<div class="col-md-12"><h4 class="text-center text-danger" style="margin-top:50px;">${message}</h4></div>`;
    }

    // Eksekusi fungsi utama
    fetchTeams();
});
</script>
@endsection