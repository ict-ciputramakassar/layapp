@extends('views_frontend.layouts.app')

@section('title', 'Game Info')

@section('content')
<div class="inner-page-banner">
	<div class="container">
	</div>
</div>
<div class="inner-information-text">
	<div class="container">
		<h3>Our Events</h3>
		<ul class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li class="active">Our Events</li>
		</ul>
	</div>
</div>

<section id="contant" class="contant main-heading team">
	<div class="row">
		<div class="container">
			<div id="events-container" class="row">
				<!-- Events will be loaded here dynamically -->
			</div>
		</div>
	</div>
</section>

<script>
	// Fetch and display events dynamically
	document.addEventListener('DOMContentLoaded', function() {
		fetch('{{ route("api.events-frontend") }}')
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok');
				}
				return response.json();
			})
			.then(data => {
				if (data.success && data.data.length > 0) {
					const container = document.getElementById('events-container');
					let html = '';

					data.data.forEach(event => {
						html += `
							<div class="col-md-3 column">
								<div class="card">
									<img class="img-responsive" src="${event.logo}" alt="${event.name}" style="width:100%; height: 23vh; object-fit: cover;">
									<div class="">
										<h4>${event.name}</h4>
										<p class="title">Mulai: ${event.start_date}</p>
										<p class="title">Berakhir: ${event.end_date}</p>
										<p>
										<div class="center"><button class="button" onclick="window.location.href='${event.id}'">Daftar</button></div>
										</p>
									</div>
								</div>
							</div>
						`;
					});

					container.innerHTML = html;
				} else {
					document.getElementById('events-container').innerHTML = '<p>No events available</p>';
				}
			})
			.catch(error => {
				console.error('Error loading events:', error);
				document.getElementById('events-container').innerHTML = '<p>Error loading events. Please try again later.</p>';
			});
	});
</script>
@endsection
