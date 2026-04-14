@extends('views_frontend.layouts.app')

@section('title', 'Game Info')

@section('content')
	<div class="full-slider">
		<div id="carousel-example-generic" class="carousel slide">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<!-- First slide -->
				<div class="item active deepskyblue" data-ride="carousel" data-interval="5000">
					<div class="carousel-caption">
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<div class="slider-contant" data-animation="animated fadeInRight">
								<h3>If you Don't Practice<br>You <span class="color-yellow">Don't Derserve</span><br>to win!
								</h3>
								<p>If you use this site regularly and would like to help keep the site on the Internet,<br>
									please consider donating a small sum to help pay..
								</p>
								<button class="btn btn-primary btn-lg">Read More</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /.item -->
				<!-- Second slide -->
				<div class="item skyblue" data-ride="carousel" data-interval="5000">
					<div class="carousel-caption">
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<div class="slider-contant" data-animation="animated fadeInRight">
								<h3>If you Don't Practice<br>You <span class="color-yellow">Don't Derserve</span><br>to win!
								</h3>
								<p>You can make a case for several potential winners of<br>the expanded European
									Championships.</p>
								<button class="btn btn-primary btn-lg">Button</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /.item -->
				<!-- Third slide -->
				<div class="item darkerskyblue" data-ride="carousel" data-interval="5000">
					<div class="carousel-caption">
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
						<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
							<div class="slider-contant" data-animation="animated fadeInRight">
								<h3>If you Don't Practice<br>You <span class="color-yellow">Don't Derserve</span><br>to win!
								</h3>
								<p>You can make a case for several potential winners of<br>the expanded European
									Championships.</p>
								<button class="btn btn-primary btn-lg">Button</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /.item -->
			</div>
			<!-- /.carousel-inner -->
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		<!-- /.carousel -->
		{{-- <div class="news">
			<div class="container">
				<div class="heading-slider">
					<p class="headline"><i class="fa fa-star" aria-hidden="true"></i> Top Headlines :</p>
					<!--made by vipul mirajkar thevipulm.appspot.com-->
					<h1>
						<a href="" class="typewrite" data-period="2000"
							data-type='[ "Contrary to popular belief, Lorem Ipsum is not simply random text.", "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."]'>
							<span class="wrap"></span>
						</a>
					</h1 <span class="wrap"></span>
					</a>
				</div>
			</div>
		</div> --}}
	</div>

	<div class="matchs-info">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
				<div class="full">
					<div class="matchs-vs">
						<div class="vs-team">
							<div class="team-btw-match">
								<ul>
									<li>
										<img src="{{ asset('images/img-03.png') }}" alt="">
										<span>Footbal Team</span>
									</li>
									<li class="vs"><span>vs</span></li>
									<li>
										<img src="{{ asset('images/img-04.png') }}" alt="">
										<span>Super Team Club</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
				<div class="full">
					<div class="right-match-time">
						<h2>Next Match</h2>
						<ul id="countdown-1" class="countdown">
							<li><span class="days">10 </span>Day </li>
							<li><span class="hours">5 </span>Hours </li>
							<li><span class="minutes">25 </span>Minutes </li>
							<li><span class="seconds">10 </span>Seconds </li>
						</ul>
						<span>12/02/2017 /19:00pm</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section id="contant" class="contant">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-sm-4 col-xs-12">
					<aside id="sidebar" class="left-bar">
						<div class="banner-sidebar">
							<img class="img-responsive" src="{{ asset('images/img-05.jpg') }}" alt="#" />
							<h3>Lorem Ipsum is simply dummy text..</h3>
						</div>
					</aside>
					<h4>Match Fixture</h4>
					<aside id="sidebar" class="left-bar">
						<div class="feature-matchs">
							<div class="team-btw-match">
								<ul>
									<li>
										<img src="{{ asset('images/img-01_002.png') }}" alt="">
										<span>Portugal</span>
									</li>
									<li class="vs"><span>vs</span></li>
									<li>
										<img src="{{ asset('images/img-02.png') }}" alt="">
										<span>Germany</span>
									</li>
								</ul>
								<ul>
									<li>
										<img src="{{ asset('images/img-03_002.png') }}" alt="">
										<span>Portugal</span>
									</li>
									<li class="vs"><span>vs</span></li>
									<li>
										<img src="{{ asset('images/img-04_003.png') }}" alt="">
										<span>Germany</span>
									</li>
								</ul>
								<ul>
									<li>
										<img src="{{ asset('images/img-05_002.png') }}" alt="">
										<span>Portugal</span>
									</li>
									<li class="vs"><span>vs</span></li>
									<li>
										<img src="{{ asset('images/img-06.png') }}" alt="">
										<span>Germany</span>
									</li>
								</ul>
								<ul>
									<li>
										<img src="{{ asset('images/img-07_002.png') }}" alt="">
										<span>Portugal</span>
									</li>
									<li class="vs"><span>vs</span></li>
									<li>
										<img src="{{ asset('images/img-08.png') }}" alt="">
										<span>Germany</span>
									</li>
								</ul>
								<ul>
									<li>
										<img src="{{ asset('images/img-05_002.png') }}" alt="">
										<span>Portugal</span>
									</li>
									<li class="vs"><span>vs</span></li>
									<li>
										<img src="{{ asset('images/img-06.png') }}" alt="">
										<span>Germany</span>
									</li>
								</ul>
							</div>
						</div>
					</aside>
					<h4>Points Table</h4>
					<aside id="sidebar" class="left-bar">
						<div class="feature-matchs">
							<table class="table table-bordered table-hover" id="points-table">
								<thead>
									<tr>
										<th>#</th>
										<th>Team</th>
										<th>P</th>
										<th>W</th>
										<th>L</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</aside>
					<div class="content-widget top-story" style="background: url({{ asset('images/top-story-bg.jpg') }});">
						<div class="top-stroy-header">
							<h2>Top Soccer Headlines Story <a href="#" class="fa fa-fa fa-angle-right"></a></h2>
							<span class="date">July 05, 2017</span>
							<h2>Other Headlines</h2>
						</div>
						<ul class="other-stroies">
							<li><a href="#">Wenger Vardy won't start</a></li>
							<li><a href="#">Evans: Vardy just</a></li>
							<li><a href="#">Pires and Murray </a></li>
							<li><a href="#">Okazaki backing</a></li>
							<li><a href="#">Wolfsburg's Rodriguez</a></li>
							<li><a href="#">Jamie Vardy compared</a></li>
							<li><a href="#">Arsenal target Mkhitaryan</a></li>
							<li><a href="#">Messi wins libel case.</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-8 col-sm-8 col-xs-12">
					<div class="news-post-holder">
						<div class="news-post-widget">
							<img class="img-responsive" src="{{ asset('images/img-01_002.jpg') }}" alt="">
							<div class="news-post-detail">
								<span class="date">20 march 2016</span>
								<h2><a href="{{ route('blog') }}">At vero eos et accusamus et iusto odio dignissimos
										ducimus</a></h2>
								<p>Just hours after that his grandma had died, Angel Di Maria imagined how she might react
									if he didn't play</p>
							</div>
						</div>
						<div class="news-post-widget">
							<img class="img-responsive" src="{{ asset('images/img-02_003.jpg') }}" alt="">
							<div class="news-post-detail">
								<span class="date">20 march 2016</span>
								<h2><a href="{{ route('blog') }}">At vero eos et accusamus et iusto odio dignissimos
										ducimus</a></h2>
								<p>Just hours after that his grandma had died, Angel Di Maria imagined how she might react
									if he didn't play</p>
							</div>
						</div>
					</div>
					<div class="news-post-holder">
						<div class="news-post-widget">
							<img class="img-responsive" src="{{ asset('images/img-03_003.jpg') }}" alt="">
							<div class="news-post-detail">
								<span class="date">20 march 2016</span>
								<h2><a href="{{ route('blog') }}">At vero eos et accusamus et iusto odio dignissimos
										ducimus</a></h2>
								<p>Just hours after that his grandma had died, Angel Di Maria imagined how she might react
									if he didn't play</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- <section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="full">
						<div class="main-heading sytle-2">
							<h2>Video</h2>
							<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium<br>doloremque
								laudantium, totam rem aperiam</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}

	{{-- <section class="video_section_main theme-padding middle-bg vedio">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="full">
						<div class="match_vedio">
							<img class="img-responsive" src="{{ asset('images/img-07.jpg') }}" alt="#" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}

	<div class="team-holder theme-padding">
		<div class="container">
			<div class="main-heading-holder">
				<div class="main-heading sytle-2">
					<h2>Our Sponsors</h2>
					<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium<br>doloremque laudantium,
						totam rem aperiam</p>
				</div>
			</div>
			<div id="team-slider">
				<div class="container">
					<div class="col-md-3">
						<div class="team-column style-2">
							<img src="{{ asset('images/img-1-1.jpg') }}" alt="">
							<div class="player-name">
								<div class="desination-2">Defender</div>
								<h5>Charles Wheeler</h5>
								<span class="player-number">12</span>
							</div>
							<div class="overlay">
								<div class="team-detail-hover position-center-x">
									<p>Lacus vulputate torquent mollis venenatis quisque suspendisse fermentum primis,</p>
									<ul class="social-icons style-4 style-5">
										<li><a class="facebook" href="#" tabindex="0"><i class="fa fa-facebook"></i></a>
										</li>
										<li><a class="twitter" href="#" tabindex="0"><i class="fa fa-twitter"></i></a></li>
										<li><a class="youtube" href="#" tabindex="0"><i class="fa fa-youtube-play"></i></a>
										</li>
										<li><a class="pinterest" href="#" tabindex="0"><i class="fa fa-pinterest-p"></i></a>
										</li>
									</ul>
									<a class="btn blue-btn" href="{{ route('team') }}" tabindex="0">View Detail</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="team-column style-2">
							<img src="{{ asset('images/img-1-2.jpg') }}" alt="">
							<div class="player-name">
								<div class="desination-2">Defender</div>
								<h5>Charles Wheeler</h5>
								<span class="player-number">12</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="team-column style-2">
							<img src="{{ asset('images/img-1-3.jpg') }}" alt="">
							<div class="player-name">
								<div class="desination-2">Defender</div>
								<h5>Charles Wheeler</h5>
								<span class="player-number">12</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="team-column style-2">
							<img src="{{ asset('images/img-1-4.jpg') }}" alt="">
							<div class="player-name">
								<div class="desination-2">Defender</div>
								<h5>Charles Wheeler</h5>
								<span class="player-number">12</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		// 1. Tunggu sampai struktur HTML selesai dimuat
		document.addEventListener('DOMContentLoaded', () => {

			fetchPoints();

		});

		// 2. Buat fungsi async untuk melakukan fetch
		async function fetchPoints() {
			try {
				// Ganti URL ini dengan URL endpoint/route Laravel Anda
				const url = '{{ route("api.points-frontend") }}';

				// Memulai proses fetch
				const response = await fetch(url, {
					method: 'GET',
					headers: {
						'Accept': 'application/json',
					}
				});

				// Cek apakah HTTP status nya sukses (200-299)
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}

				// Ubah response dari server menjadi format JSON (Object JavaScript)
				const data = await response.json();

				const pointsTable = document.getElementById("points-table");
				var i = 1;
				data.teams.forEach((team) => {
					const newRow = `
					<tr>
						<td>${i}</td>
						<td><img  class="align-baseline mx-1" style="width: 2em; height: 2em;" src="{{ asset('${team.image}') }}" alt="">${team.name}</td>
						<td>${team.points.p}</td>
						<td>${team.points.win}</td>
						<td>${team.points.lose}</td>
					</tr>
					`;

					pointsTable.insertAdjacentHTML('beforeend', newRow);
					i++;
				});

			} catch (error) {
				// Tangkap dan tampilkan error jika fetch gagal (misal: jaringan putus, server mati)
				console.error("An error occured when fetching team points:", error);
			}
		}
	</script>
@endsection