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
									<h1 id="page-title">Blog Grid 3 Columns</h1>
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
																	<small>June</small><span>30</span>
																</p>
															</div>
															<h4><a href="{{ route('single_article', ['product' => $article->id])  }}">{{$article->title}}</a></h4>
														</div>
														<div class="blogs-image">
															<ul class="list-inline">
																<li><a href="./article.html">
																<div style="text-align: left;">
																	<img src="./assets/images/demo_370x247.png" alt="">
																</div>
																</a></li>
															</ul>
														</div>
														<div class="intro">
                                                            {{$article->content}}
														</div>
														<ul class="post list-inline">
															<li class="author">Jin Alkaid</li>
															<li>/</li>
															<li class="comment">
															<a href="/#">
															<span>2</span> Comment(s) </a>
															</li>
															<li class="post-action">
															<a class="btn btn-1 enable hidden-xs" href="#" title="Add your thoughts">Post Comment</a>
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