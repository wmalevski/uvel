@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div id="content-wrapper-parent">
		<div id="content-wrapper">
				<!-- Content -->
				<div id="content" class="clearfix">
					<div id="breadcrumb" class="breadcrumb">
						<div itemprop="breadcrumb" class="container">
							<div class="row">
								<div class="col-md-24">
									{{ Breadcrumbs::render('web_blog') }}
								</div>
							</div>
						</div>
					</div>
					<section class="content">
						<div class="container">
							<div class="row">
								<div id="page-header" class="col-md-24">
									<h1 id="page-title">Блог</h1>
								</div>
								<div class="col-md-12">
									@foreach(config('translatable.locales') as $locale => $language)
										<a href="{{route('translated_articles', ['locale'=>$locale])}}">
											<span>
												{{$language}}
												@if($loop->last) @else | @endif
											</span>
										</a>
									@endforeach
								</div>
								<div id="col-main" class="blog blog-page col-sm-24 col-md-24 blog-full-width blog-3-col ">
									<div class="blog-content-wrapper">
										@foreach($articles as $article)
										<div class="blogs col-sm-8 col-md-8 clearfix">
											<article class="blogs-item article-content">
												<div class="blogs-image">
													@if(!empty($lng))
													<a href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug])  }}">
														<img src="{{ asset("uploads/blog/" . $article->thumbnail) }}" >
													</a>
													@endif
												</div>
												<div class="title-container">
													<div class="date-container">
														<div class="date">
															<p>
																<small>{{ $article->created_at->format('M') }}</small>
																<span>{{ $article->created_at->format('d') }}</span>
															</p>
														</div>
													</div>
													<div class="article-title-container">
														<h4 class="article-title">
															<a href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug])  }}">
																{{ str_limit($article->title, 40) }}
															</a>
														</h4>
													</div>
												</div>
												<div class="intro">
													{{ str_limit($article->excerpt, 220) }}
												</div>
												<ul class="post list-inline">
													<li class="author">{{ $article->author()->name }}</li>
													<li>/</li>
													<li class="comment">
													<a href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug])  }}">
														<span>{{count($article->comments())}}</span>
														@if(count($article->comments()) == 1) Коментар @else Коментарa @endif
													</a>
													</li>
													<li class="post-action">
													<a class="btn btn-1 enable hidden-xs" href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug]) }}" title="Add your thoughts">Напиши коментар</a>
													</li>
												</ul>
											</article>
										</div>
										@endforeach
                </div>
								</div>

								<!-- End of layout -->
							</div>
						</div>
					</section>
				</div>
		</div>
    </div>
    @endsection