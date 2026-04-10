@extends('views_frontend.layouts.app')

@section('title', 'Our Team - Game Info')

@section('content')
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
    <!-- Container untuk List Tim & Member -->
	<div class="container" id="team-container">
        <div class="text-center" style="padding: 50px 0;">
            <h3><i class="fa fa-spinner fa-spin"></i> Loading Teams Data...</h3>
        </div>
	</div>

    <!-- Container untuk Pagination -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center" id="pagination-container" style="margin-top: 20px;">
                <!-- Tombol Pagination akan di-generate JS di sini -->
            </div>
        </div>
    </div>
</section>

<!-- TEMPATKAN JAVASCRIPT DI SINI -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Konfigurasi
    const API_URL = "{{ route('team_datas') }}";;
    
    // Sesuaikan Base URL Image dengan konfigurasi folder public Laravel Anda
    // Biasanya gambar tersimpan di '/storage/'
    const IMAGE_BASE_URL = 'http://localhost:8000/storage/app/public/members/'; 
    const DEFAULT_IMAGE = '{{ asset("images/client.png") }}'; // Fallback Image

    // 2. Variabel State
    let allTeams = [];
    let currentPage = 1;
    const itemsPerPage = 10; // Limit 10 Tim per page

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

        // Hitung Index untuk Slice Array (Logika Paginasi JS)
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        // Ambil maksimal 10 tim untuk halaman ini
        const teamsToRender = allTeams.slice(startIndex, endIndex);

        if (teamsToRender.length === 0) {
            container.innerHTML = '<h3 class="text-center" style="margin-top:50px;">No teams found.</h3>';
            document.getElementById('pagination-container').innerHTML = '';
            return;
        }

        // Looping Data Tim
        teamsToRender.forEach(team => {
            // Buat Wrapper Header Tim
            let html = `
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="team-header" style="background: #f8f9fa; padding: 15px 25px; border-left: 5px solid #e32124; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <h2 style="margin: 0; color: #333; font-weight: bold; text-transform: uppercase;">
                                ${team.name}
                            </h2>
                            <small class="text-muted">Total Members: ${team.members.length}</small>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 40px;">
            `;

            // Looping Member di Dalam Tim
            if (team.members.length === 0) {
                html += `<div class="col-md-12"><p class="text-muted" style="font-style: italic;">No active members registered in this team yet.</p></div>`;
            } else {
                team.members.forEach(member => {
                    // Penanganan Variabel Null dari JSON
                    const imagePath = member.image ? (IMAGE_BASE_URL + member.image) : DEFAULT_IMAGE;
                    const positionName = member.position ? member.position.name : 'No Position';
                    const memberTypeName = member.member_type ? member.member_type.name : 'Member';
                    const ageCategoryName = member.age_category ? member.age_category.name : 'Umum';

                    // Tambahkan Card HTML Member
                    html += `
                        <div class="col-md-3 column" style="margin-bottom: 20px;">
                            <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); text-align: center; height: 100%;">
                                <!-- onerror digunakan agar jika gambar dari URL tidak ada, diganti gambar default otomatis -->
                                <img class="img-responsive" src="${imagePath}" alt="${member.full_name}" style="width:100%; height: 250px; object-fit: cover; background:#eee;" onerror="this.src='${DEFAULT_IMAGE}'">
                                <div style="padding: 15px;">
                                    <h4 style="margin-bottom: 5px; font-weight: bold; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;" title="${member.full_name}">
                                        ${member.full_name}
                                    </h4>
                                    <p class="title" style="color: grey; margin-bottom: 5px;">${positionName}</p>
                                    <p style="font-size: 12px; margin-bottom: 15px;">
                                        ${memberTypeName} <br>
                                        <span style="color:#e32124;">(${ageCategoryName})</span>
                                    </p>
                                    <div class="center">
                                        <a href="mailto:${member.email}" class="button" style="border: none; outline: 0; display: inline-block; padding: 8px; color: white; background-color: #000; text-align: center; cursor: pointer; width: 100%;">Contact</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            // Tutup Tag Row Member dan tambah garis pemisah antar tim
            html += `</div><hr style="border-top: 2px dashed #ddd; margin-bottom: 40px;">`;
            
            // Suntikkan ke container utama
            container.innerHTML += html;
        });

        // Jalankan fungsi pembuatan tombol paginasi
        renderPaginationControls();
    }

    // 5. Fungsi Pembuat Tombol Pagination (Bawaan Bootstrap UI)
    function renderPaginationControls() {
        const totalPages = Math.ceil(allTeams.length / itemsPerPage);
        const paginationContainer = document.getElementById('pagination-container');
        
        if (totalPages <= 1) {
            paginationContainer.innerHTML = ''; // Jangan tampilkan jika cuma 1 halaman
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
            // Scroll otomatis ke atas (kembali ke tulisan Our Team)
            document.getElementById('contant').scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Fungsi Pembantu Jika Error
    function showError(message) {
        document.getElementById('team-container').innerHTML = `<h4 class="text-center text-danger" style="margin-top:50px;">${message}</h4>`;
    }

    // TRIGGER MULAI FETCH SAAT HALAMAN DIMUAT
    fetchTeams();
});
</script>
@endsection