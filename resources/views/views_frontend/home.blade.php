@extends('views_frontend.layouts.app')

@section('title', 'Home - LayApp')

@section('extra-css')
    <style>
        .sponsor-container {
            display: flex;
            flex-direction: row !important;
            gap: 3rem;
            padding: 0;
            margin: 0;
            width: max-content;
            align-items: center;
            animation: slide-left 15s linear infinite;
			height: 200px;
        }

        .sponsor-container:hover {
            animation-play-state: paused;
        }

        .sponsor-holder {
            width: 100%;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        #sponsor-slider {
            width: 100%;
        }

        /* --- SPONSOR CARD --- */
        .sponsor-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
			transition: transform 0.3s ease-in-out;
            cursor: pointer;
        }

		.sponsor-card:hover {
            transform: scale(1.1);
        }

        .sponsor-image {
            height: 150px !important;
            width: auto !important;
            object-fit: contain;
            display: block;
        }

        .sponsor-name {
            font-size: 2rem;
            margin: 0;
            white-space: nowrap;
        }
        /* ------------------------------- */

        @keyframes slide-left {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-49%));
            }
        }

        /* --- OVERRIDE CUSTOM.CSS CAROUSEL ARROWS --- */
        #carousel-example-generic .carousel-control {
            top: 50% !important;
            bottom: auto !important;
            width: 50px !important;
            height: 50px !important;
            transform: translateY(-50%);
            opacity: 0.8;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }
        #carousel-example-generic .left.carousel-control {
            left: 20px !important;
            right: auto !important;
        }
        #carousel-example-generic .right.carousel-control {
            right: 20px !important;
            left: auto !important;
        }
        #carousel-example-generic .carousel-control i {
            font-size: 40px !important;
            color: #fff !important;
            background: transparent !important;
            line-height: 50px !important;
        }

        /* --- MATCHS INFO --- */
        .matchs-info {
            display: flex;
            flex-wrap: wrap;
        }

        .matchs-info > div[class*='col-'] {
            display: flex;
            padding: 0 !important;
        }

        .matchs-info > div > .row {
            width: 100%;
            display: flex;
            margin: 0 !important;
        }

        .matchs-vs, .right-match-time {
            height: 100%;
            min-height: 321px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .matchs-vs {
            width: 100%;
        }

        .right-match-time {
            width: 100%;
        }

        /* --- MATCHS VS --- */
        .matchs-vs .team-btw-match ul {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            padding: 0;
            margin: 0;
        }

        .matchs-vs .team-btw-match ul li {
            float: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .matchs-vs .team-btw-match ul li.vs {
            margin: 0;
        }

        .matchs-vs .team-btw-match ul li span {
            float: none;
            text-align: center;
        }
        /* ------------------------------------------- */
    </style>
@endsection

@section('content')
    <div class="full-slider">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-pause="hover">
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active deepskyblue">
                    <div class="carousel-caption">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="slider-contant" data-animation="animated fadeInRight" data-interval="5000">
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
                <div class="item skyblue">
                    <div class="carousel-caption">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="slider-contant" data-animation="animated fadeInRight" data-interval="5000">
                                <h3>If you Don't Practice<br>You <span class="color-yellow">Don't Derserve</span><br>to win!
                                </h3>
                                <p>You can make a case for several potential winners of<br>the expanded European
                                    Championships.</p>
                                <button class="btn btn-primary btn-lg">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item darkerskyblue">
                    <div class="carousel-caption">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="slider-contant" data-animation="animated fadeInRight" data-interval="5000">
                                <h3>If you Don't Practice<br>You <span class="color-yellow">Don't Derserve</span><br>to win!
                                </h3>
                                <p>You can make a case for several potential winners of<br>the expanded European
                                    Championships.</p>
                                <button class="btn btn-primary btn-lg">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="matchs-info">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="full">
                    <div class="matchs-vs">
                        <div class="vs-team">
                            <div class="team-btw-match">
                                <ul>
                                    @if($nextMatch)
                                        <li>
                                            <img width="98px" height="98px" src="{{ asset($nextMatch->teamH->image) }}" alt="{{ $nextMatch->teamH->name }}">
                                            <span>{{ $nextMatch->teamH->name }}</span>
                                        </li>
                                        <li class="vs"><span>vs</span></li>
                                        <li>
                                            <img width="98px" height="98px" src="{{ asset($nextMatch->teamA->image) }}" alt="{{ $nextMatch->teamA->name }}">
                                            <span>{{ $nextMatch->teamA->name }}</span>
                                        </li>
                                    @else
                                        <li>
                                            <span>TBA</span>
                                        </li>
                                        <li class="vs"><span>vs</span></li>
                                        <li>
                                            <span>TBA</span>
                                        </li>
                                    @endif
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
                            <li><span>{{ $nextMatch ? $nextMatch->play_date->format('d/m/Y H:i') : 'TBA' }}</span></li>
                            {{-- <li><span class="days">10 </span>Day </li>
                            <li><span class="hours">5 </span>Hours </li>
                            <li><span class="minutes">25 </span>Minutes </li>
                            <li><span class="seconds">10 </span>Seconds </li> --}}
                        </ul>
                        {{-- <span>12/02/2017 /19:00pm</span> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="contant" class="contant">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-12">
                    {{-- <aside id="sidebar" class="left-bar">
                        <div class="banner-sidebar">
                            <img class="img-responsive" src="{{ asset('images/img-05.jpg') }}" alt="#" />
                            <h3>Lorem Ipsum is simply dummy text..</h3>
                        </div>
                    </aside> --}}
                    <h4>Match Fixture</h4>
                    <aside id="sidebar" class="left-bar">
                        <div class="feature-matchs">
                            <div class="team-btw-match">
                                @forelse($fixtures as $fixture)
                                    <ul style="display: flex; align-items: center;">
                                        <li>
                                            <img style="width: 34px; height: 34px;" src="{{ asset($fixture->teamH->image) }}" alt="{{ $fixture->teamH->name }}">
                                            <span class="text-muted">{{ $fixture->teamH->name }}</span>
                                        </li>
                                        <li class="vs" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 0 15px;">
                                            <span style="font-weight: bold; line-height: 1; margin-bottom: 2px;">Vs</span>
                                            <span class="date text-muted" style="font-weight: bold; font-size: 12px; line-height: 1; margin-top: 0;">{{ $fixture->play_date->format('d/m/Y') }}</span>
                                        </li>
                                        <li>
                                            <img style="width: 34px; height: 34px;" src="{{ asset($fixture->teamA->image) }}" alt="{{ $fixture->teamA->name }}">
                                            <span class="text-muted">{{ $fixture->teamA->name }}</span>
                                        </li>
                                    </ul>
                                @empty
                                    <p class="text-center" style="color: #333333; display: flex; align-items: center; justify-content: center;">No upcoming fixtures.</p>
                                @endforelse
                            </div>
                        </div>
                    </aside>
                    {{-- <h4>Points Table</h4>
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
                    </aside> --}}
                    {{-- <div class="content-widget top-story" style="background: url({{ asset('images/top-story-bg.jpg') }});">
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
                    </div> --}}
                </div>
                <div class="col-lg-8 col-sm-8 col-xs-12">
                    <h4>Group Standings</h4>
                    <aside id="sidebar" class="left-bar">
                        <div class="feature-matchs" style="position: relative;">
                            <div id="standings-carousel" class="carousel slide" data-ride="carousel" data-pause="hover">
                                <!-- Wrapper for slides -->
                                <div style="padding: 10px;" class="carousel-inner" role="listbox">
                                    @forelse($groups as $index => $group)
                                    <div class="item {{ $index === 0 ? 'active' : '' }}">
                                        <h5 style="text-align: center; font-size: 16px; font-weight: bold; margin-top: 5px; margin-bottom: 10px;">{{ $group['name'] }}</h5>
                                        <table class="table table-hover" style="margin-bottom: 0;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Team</th>
                                                    <th class="text-center">Play</th>
                                                    <th class="text-center">Win</th>
                                                    <th class="text-center">Draw</th>
                                                    <th class="text-center">Loss</th>
                                                    <th class="text-center">Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($group['teams'] as $teamIndex => $team)
                                                <tr>
                                                    <td class="text-center">{{ $teamIndex + 1 }}</td>
                                                    <td>
                                                        @if($team['image'])
                                                            <img src="{{ asset($team['image']) }}" alt="{{ $team['name'] }}" style="width: 24px; height: 24px; object-fit: contain; margin-right: 5px;">
                                                        @endif
                                                        {{ $team['name'] }}
                                                    </td>
                                                    <td class="text-center">{{ $team['points']['play'] }}</td>
                                                    <td class="text-center">{{ $team['points']['win'] }}</td>
                                                    <td class="text-center">{{ $team['points']['draw'] }}</td>
                                                    <td class="text-center">{{ $team['points']['lose'] }}</td>
                                                    <td class="text-center"><strong>{{ $team['points']['point'] }}</strong></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @empty
                                    <div class="item active">
                                        <h5 style="text-align: center; font-weight: bold; margin-top: 0; margin-bottom: 0; padding: 20px;">No Groups Available</h5>
                                    </div>
                                    @endforelse
                                </div>

                                <!-- Controls -->
                                @if(count($groups) > 1)
                                <a class="left carousel-control" href="#standings-carousel" role="button" data-slide="prev" style="background: none; width: 30px; display: flex; align-items: center; justify-content: flex-start; text-shadow: none;">
                                    <i class="fa fa-chevron-left" aria-hidden="true" style="color: #666;"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#standings-carousel" role="button" data-slide="next" style="background: none; width: 30px; display: flex; align-items: center; justify-content: flex-end; text-shadow: none;">
                                    <i class="fa fa-chevron-right" aria-hidden="true" style="color: #666;"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <div class="team-holder theme-padding">
        <div class="sponsor-holder container">
            <div class="main-heading-holder">
                <div class="main-heading sytle-2">
                    <h2>Our Sponsors</h2>
                    {{-- <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium<br>doloremque laudantium,
                        totam rem aperiam</p> --}}
                </div>
            </div>
            <div id="sponsor-slider">
                <div class="sponsor-container container">
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/GreenSM.png") }}" alt="">
                        <p class="sponsor-name">Green SM</p>
                    </div>
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/Yamaha.png") }}" alt="">
                        <p class="sponsor-name">Yamaha</p>
                    </div>
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/BankSampoerna.png") }}" alt="">
                        <p class="sponsor-name">Bank Sampoerna</p>
                    </div>
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/CocaCola.png") }}" alt="">
                        <p class="sponsor-name">Coca Cola</p>
                    </div>
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/FreshCare.jpeg") }}" alt="">
                        <p class="sponsor-name">Fresh Care</p>
                    </div>
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/CitraLand.png") }}" alt="">
                        <p class="sponsor-name">Citra Land</p>
                    </div>
                    <div class="sponsor-card">
                        <img class="sponsor-image" src="{{ asset("images/sponsors/Mixxi.png") }}" alt="">
                        <p class="sponsor-name">Mixxi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. Tunggu sampai struktur HTML selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.sponsor-container');
            const cards = Array.from(container.children);

            // Gandakan setiap kartu dan masukkan kembali ke dalam container
            cards.forEach(card => {
                const clone = card.cloneNode(true);
                // Aksesibilitas: Sembunyikan elemen duplikat dari Screen Reader
                clone.setAttribute('aria-hidden', 'true');
                container.appendChild(clone);
            });
        });
    </script>
@endsection
