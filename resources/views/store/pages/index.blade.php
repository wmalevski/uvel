@extends('store.layouts.app', ['bodyClass' => 'templateIndex'])

@section('content')
<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal"
 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>
<div id="content-wrapper-parent" class="home-page">
	<div id="content-wrapper">
		<form name="headerSearch" id="headerSearch" method="POST">
			<div class="row" id="homeSearch" style="background-image:url('{{ App\Setting::get('website_header') }}');">
				<div class='searchBox'>
					<div><input name="search_term" type="text" placeholder="Номер продукт или Модел" class="form-control" /></div>
					<button id="searchButton" class="btn btn-1" type="submit">ТЪРСИ</button>
				</div>
			</div>
		</form>

		<!-- Content -->
		<div id="content" class="clearfix">
			<section class="content">
				<div id="col-main" class="clearfix">

					{!! $latest_by_materials !!}

					@if(count($articles))
					<div class="home-blog">
						<div class="container">
							<div class="home-promotion-blog row">
								<h6 class="general-title">Последни новини</h6>
							</div>

							@foreach($articles as $article)
							<div class="row home-blog__article">
								<div class="home-bottom_banner_wrapper col-md-12">
									@foreach( $article->thumbnail as $thumb)
										<div id="home-bottom_banner" class="home-bottom_banner">
											<a  href="{{ route('single_translated_article', ['locale'=>app()->getLocale(), 'product' =>$article->slug])  }}">
												@if($thumb->language == 'bg')
													<div class="image-wrapper">
														<img src="{{ asset("uploads/blog/" . $thumb->photo) }}" alt="{{ $article->slug }}"/>
													</div>
												@endif
											</a>
										</div>
									@endforeach
								</div>
								<div class="home-blog-wrapper col-md-12">
									<div id="home_blog" class="home-blog">
										<div class="home-blog-item row">
											<div class="date col-md-4">
												<div class="date_inner">
													<p>
														<small>{{ $article->created_at->format('M') }}</small>
														<span>{{ $article->created_at->format('d') }}</span>
													</p>
												</div>
											</div>
											<div class="home-blog-content col-md-20">
												<h4>
													<a href="{{ route('single_translated_article', ['locale'=>app()->getLocale(), 'product' => $article->slug])  }}">
														{{ str_limit($article->title, 40) }}
													</a>
												</h4>
												<ul class="list-inline">
													<li class="author">
														<i class="fa fa-user"></i>
														{{$article->author()->name}}
													</li>
													<li>/</li>
													<li class="comment">
														<a href="{{ route('single_translated_article', ['locale'=>app()->getLocale(), 'product' => $article->slug])  }}">
															<span>
																<i class="fa fa-pencil-square-o"></i>
																{{count($article->comments())}}
															</span>
															@if(count($article->comments()) == 1) Коментар @else Коментарa @endif </a>
													</li>
												</ul>
												<div class="intro">
													{{ str_limit($article->excerpt, 220) }}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					@endif
				</div>
			</section>
		</div>
	</div>
</div>
@endsection