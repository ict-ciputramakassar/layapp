@extends('views_frontend.layouts.app')

@section('title', $team['name'] . ' - Game Info')

@section('content')
<style>
    /* ... (Biarkan CSS sama persis seperti kode sebelumnya) ... */
    .td-wrapper { background-color: #f4f7f6; padding-top: 30px; padding-bottom: 60px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .td-header-card { background: #ffffff; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 30px; border-top: 5px solid #e32124; }
    .td-logo-container { text-align: center; padding: 10px; }
    .td-logo-container img { width: 100%; max-width: 180px; border-radius: 10px; object-fit: contain; background: #f9f9f9; padding: 15px; border: 1px solid #eee; }
    .td-team-name { font-size: 28px; font-weight: 900; color: #111; margin-top: 0; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
    .td-verified { color: #1da1f2; font-size: 22px; vertical-align: middle; }
    .td-address { color: #555; font-size: 14px; line-height: 1.6; margin-bottom: 20px; word-wrap: break-word; }
    .td-tags { margin-bottom: 20px; }
    .td-tag { display: inline-block; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; margin-right: 10px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
    .td-tag-region { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .td-tag-type { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
    .td-socials a { display: inline-block; margin-right: 15px; font-weight: 600; color: #555; text-decoration: none; transition: color 0.2s; }
    .td-socials a:hover { color: #e32124; }
    .td-match-widget { background: #fafafa; border: 1px solid #eaeaea; border-radius: 10px; padding: 20px; height: 100%; }
    .td-match-title { font-size: 16px; font-weight: 800; color: #333; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
    .td-match-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed #e0e0e0; font-size: 13px; }
    .td-match-item:last-child { border-bottom: none; }
    .td-match-status { width: 25px; height: 25px; border-radius: 4px; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold; font-size: 12px; }
    .status-l { background-color: #ef5350; }
    .status-w { background-color: #66bb6a; }
    .td-match-ku { color: #777; font-weight: 600; width: 45px; }
    .td-match-score { font-weight: 800; color: #222; }
    .td-match-enemy { text-align: right; flex-grow: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-left: 10px; color: #555; }
    .td-tabs-container { background: #fff; border-radius: 10px; padding: 10px 20px 0 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-bottom: 25px; display: flex; flex-wrap: wrap; border-bottom: 2px solid #eee; }
    .td-tab { padding: 15px 25px; font-weight: 700; color: #888; cursor: pointer; border-bottom: 3px solid transparent; margin-bottom: -2px; transition: 0.3s; }
    .td-tab:hover { color: #333; }
    .td-tab.active { color: #e32124; border-bottom: 3px solid #e32124; }
    .td-filter-year { margin-bottom: 20px; }
    .td-btn-year { background: #fff; border: 1px solid #ddd; padding: 6px 18px; border-radius: 20px; color: #555; font-weight: 600; font-size: 13px; margin-right: 8px; margin-bottom: 8px; transition: 0.2s; }
    .td-btn-year.active { background: #333; color: #fff; border-color: #333; }
    .td-content-box { background: #fff; border-radius: 10px; padding: 40px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); min-height: 200px; transition: opacity 0.3s; border-left: 4px solid #ccc; }
    .mt-3 { margin-top: 20px; } .mb-3 { margin-bottom: 20px; }
    
    /* Tambahan CSS untuk List Member */
    .member-card-mini { display: flex; align-items: center; background: #f9f9f9; padding: 12px; border-radius: 8px; border: 1px solid #eee; height: 100%; transition: 0.2s; }
    .member-card-mini:hover { box-shadow: 0 4px 8px rgba(0,0,0,0.05); border-color: #ddd; }
    .member-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .member-info strong { display: block; color: #222; font-size: 15px; margin-bottom: 2px; }
    .member-info small { color: #888; font-size: 12px; font-weight: 600; text-transform: uppercase; }
</style>

<div class="inner-page-banner">
    <div class="container"></div>
</div>
<div class="inner-information-text">
    <div class="container">
        <h3>Team Detail</h3>
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('team_datas') }}">Our Team</a></li>
            <li class="active">{{ $team['name'] }}</li>
        </ul>
    </div>
</div>

<section class="td-wrapper">
    <div class="container">
        
        <div class="td-header-card">
            <div class="row">
                
                <div class="col-md-3 col-sm-4">
                    <div class="td-logo-container">
                        @php
                            $teamImage = asset($team['image']);
                        @endphp
                        <img src="{{ $teamImage }}" alt="{{ $team['name'] }} Logo" onerror="this.src='{{ asset('images/client.png') }}'">
                    </div>
                </div>
                
                <div class="col-md-5 col-sm-8 mb-3">
                    <h2 class="td-team-name">
                        {{ $team['name'] }} <i class="fa fa-check-circle td-verified" title="Verified Team"></i>
                    </h2>
                    
                    <div class="td-address">
                        <i class="fa fa-map-marker" style="color: #e32124; margin-right: 5px;"></i> 
                        Informasi alamat tim bisa Anda tambahkan ke database nanti.
                    </div>
                    
                    <div class="td-tags">
                        <span class="td-tag td-tag-region"><i class="fa fa-map"></i> Reg: UMUM</span>
                        <span class="td-tag td-tag-type"><i class="fa fa-shield"></i> Tipe: {{ $team['type'] }}</span>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-12 mt-3 mt-md-0">
                    <div class="td-match-widget">
                        <div class="td-match-title"><i class="fa fa-history"></i> Last Match Results</div>
                        <div class="td-match-item">
                            <div class="td-match-status status-l">L</div>
                            <div class="td-match-ku">KU-16</div>
                            <div class="td-match-score">18 - 48</div>
                            <div class="td-match-enemy">Junior Liga Bali</div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="td-tabs-container" id="td-tabs">
            <div class="td-tab active" data-target="team"><i class="fa fa-users"></i> Roster Tim</div>
            <div class="td-tab" data-target="achievement"><i class="fa fa-trophy"></i> Prestasi</div>
            <div class="td-tab" data-target="stats"><i class="fa fa-bar-chart"></i> Statistik</div>
            <div class="td-tab" data-target="atlet"><i class="fa fa-id-badge"></i> Daftar Atlet</div>
            <div class="td-tab" data-target="coach"><i class="fa fa-user-secret"></i> Pelatih</div>
            <div class="td-tab" data-target="official"><i class="fa fa-black-tie"></i> Official</div>
        </div>

        <div class="td-filter-year" id="td-years">
            <button class="td-btn-year active" data-year="all">Semua Tahun</button>
            {{-- <button class="td-btn-year" data-year="2026">Musim 2026</button>
            <button class="td-btn-year" data-year="2025">Musim 2025</button> --}}
        </div>

        <div class="td-content-box" id="td-content">
            </div>

        <div class="mt-3">
            <a href="{{ route('team_datas') }}" class="btn" style="background: #333; color: #fff; border-radius: 20px; padding: 8px 20px;">
                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Klub
            </a>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // TANGKAP DATA DARI BACKEND LARAVEL KE JAVASCRIPT
    const dbMembers = @json($members);

    // State Aplikasi
    let currentTab = 'team';

    // Data Dummy untuk tab yang belum ada di Database (Achievement, Stats)
    const dummyContent = {
        team: '<h4><i class="fa fa-info-circle"></i> Info Roster</h4><p>Silakan navigasi ke tab <b>Daftar Atlet</b>, <b>Pelatih</b>, atau <b>Official</b> untuk melihat anggota yang terdaftar di database.</p>',
        achievement: '<h4><i class="fa fa-trophy"></i> Prestasi</h4><p>Belum ada data prestasi yang dicatat di database untuk tim ini.</p>',
        stats: '<h4><i class="fa fa-line-chart"></i> Statistik Permainan</h4><p>Data statistik belum terhubung dengan sistem.</p>'
    };

    const tabs = document.querySelectorAll('.td-tab');
    const years = document.querySelectorAll('.td-btn-year');
    const contentBox = document.getElementById('td-content');

    // Fungsi Render HTML untuk Card Anggota
    function generateMemberCards(membersArray, title, iconClass) {
        if (!membersArray || membersArray.length === 0) {
            return null; // Return null agar menampilkan layout kosong
        }

        let html = `<h4 style="margin-bottom: 20px;"><i class="fa ${iconClass}"></i> ${title}</h4>`;
        html += `<div class="row">`;
        
        membersArray.forEach(member => {
            // Sesuaikan variabel di bawah (member.full_name, member.position.name) dengan field JSON/Tabel Anda
            let name = member.full_name;
            let position = member.type;
            let image = `{{ asset('${member.image}') }}`;

            html += `
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="member-card-mini">
                    <img src="${image}" class="member-img">
                    <div class="member-info">
                        <strong title="${name}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">${name}</strong>
                        <small>${position}</small>
                    </div>
                </div>
            </div>`;
        });
        
        html += `</div>`;
        return html;
    }

    // Fungsi Utama Render Konten ke Layar
    function renderData() {
        contentBox.style.opacity = 0; // Efek fade out
        
        setTimeout(() => {
            let htmlContent = null;

            // Cek Tab mana yang aktif dan mapping datanya
            if (currentTab === 'atlet') {
                htmlContent = generateMemberCards(dbMembers.athletes, "Daftar Atlet Terdaftar", "fa-users");
            } else if (currentTab === 'coach') {
                htmlContent = generateMemberCards(dbMembers.coaches, "Susunan Kepelatihan", "fa-user-secret");
            } else if (currentTab === 'official') {
                htmlContent = generateMemberCards(dbMembers.officials, "Susunan Official", "fa-black-tie");
            } else {
                // Untuk Tab Team, Prestasi, dan Stats (Ambil dari dummy sementara)
                htmlContent = dummyContent[currentTab];
            }
            
            // JIKA ADA DATA
            if (htmlContent) {
                contentBox.innerHTML = htmlContent;
                contentBox.style.borderLeftColor = "#2ecc71"; // Garis hijau
            } 
            // JIKA KOSONG (Array null/length 0)
            else {
                contentBox.innerHTML = `
                    <div style="text-align: center; color: #999; padding: 40px 0;">
                        <i class="fa fa-folder-open-o fa-4x" style="margin-bottom: 15px;"></i>
                        <h4>Data Belum Tersedia</h4>
                        <p>Belum ada data ${currentTab} yang dimasukkan ke dalam tim ini.</p>
                    </div>
                `;
                contentBox.style.borderLeftColor = "#e32124"; // Garis merah
            }
            
            contentBox.style.opacity = 1; // Efek fade in
        }, 200);
    }

    // Event Listener Tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentTab = this.getAttribute('data-target');
            renderData();
        });
    });

    // Event Listener Filter Tahun (Hanya efek UI, belum ngefilter DB)
    years.forEach(year => {
        year.addEventListener('click', function() {
            years.forEach(y => y.classList.remove('active'));
            this.classList.add('active');
            // Saat ini filter tahun sekadar ganti warna tombol, 
            // karena data members dari DB belum dikelompokkan per tahun.
            renderData(); 
        });
    });

    // Jalankan render saat halaman pertama dimuat
    renderData();
});
</script>
@endsection