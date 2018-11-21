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
									<a href="./index.html" class="homepage-link" title="Back to the frontpage">Home</a>								
									<span>/</span>
									<span class="page-title">Блог</span>
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
									<a href="{{route('blog', ['locale'=>$locale])}}">
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
											<article class="blogs-item">
											<div class="row">
												<div class="article-content col-md-24">
													<div class="article-content-inner">
														<div>
															<div class="date">
																<p>
																	<small>{{ $article->created_at->format('M') }}</small><span>{{ $article->created_at->format('d') }}</span>
																</p>
															</div>
															<h4>
																<a href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug])  }}">{{$article->title}}</a>
															</h4>
														</div>
														<div class="blogs-image">
															<ul class="list-inline">
																<li>
																	@if(!empty($lng))
																	<a href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug])  }}">
																		<div style="text-align: left;">
																			<img src="{{ asset("uploads/blog/" . $article->thumbnail) }}" alt="">
																		</div>
																	</a>
																	@endif
																</li>
															</ul>
														</div>
														<div class="intro">
                                                            {{$article->excerpt}}
														</div>
														<ul class="post list-inline">
															<li class="author">Jin Alkaid</li>
															<li>/</li>
															<li class="comment">
															<a href="/#">
															<span>2</span> Comment(s) </a>
															</li>
															<li class="post-action">
															<a class="btn btn-1 enable hidden-xs" href="{{ route('single_translated_article', ['locale'=>$lng, 'product' => $article->slug]) }}" title="Add your thoughts">Post Comment</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
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