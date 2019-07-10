@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('single_translated_article', $article) }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="col-main" class="blog article-page col-xs-24 col-sm-24 ">
							<div class="article">
								<article class="blogs-item">
									<div class="row">
										<div class="article-content col-md-24">
											<div class="blog-article-title">
												<div class="date">
													<p>
														<small>
															{{ $article->created_at->format('M') }}
														</small>
														<span>
															{{ $article->created_at->format('d') }}
														</span>
													</p>
												</div>
												<h4 class="blog-title">
													{{ $article->translate($lng)->title }}
												</h4>
											</div>
											<div class="blogs-image">
												<ul class="list-inline">
													<li>
														@foreach($article->thumbnail as $thumb)
															@if($thumb->language == $lng)
																<img src="{{ asset("uploads/blog/" . $thumb->photo ) }}">
															@endif
														@endforeach

													</li>
												</ul>
											</div>
											<div class="intro">
												<p>
													{!! $article->translate($lng)->content !!}
												</p>
											</div>
											<footer class="article-extras clearfix">
												<ul class="post list-inline">
													<li class="author">
														{{ $article->author()->name }}
													</li>
													<li class="comment">
														<a href="#">
															<span>
																{{count($article->comments())}}
															</span>
															Коментара
														</a>
													</li>
												</ul>
											</footer>

											@auth
											<form method="post" data-form-captcha action="{{ route('article_comment', ['article' => $article->id])  }}" accept-charset="UTF-8">
												{{ csrf_field() }}
												<input value="new_comment" name="form_type" type="hidden">
												<input name="utf8" value="✓" type="hidden">
												<div 
													id="blog_captcha"
													data-size="invisible" data-captcha="blog_captcha" data-callback="formSubmit">
												</div>
												<div id="comment-form">
													<h6>Оставете коментар</h6>
													<ul class="contact-form row list-unstyled">
														{{-- <li class="col-md-24">
															<label for="comment_author" class="control-label">Your name <span class="req">*</span></label>
															<input id="comment_author" name="comment[author]" class="form-control" type="text">
														</li>
														<li class="clearfix"></li>
														<li class="col-md-24">
															<label for="comment_email" class="control-label">Your email <span class="req">*</span></label>
															<input id="comment_email" name="comment[email]" class="form-control" type="text">
														</li> --}}
														<li class="clearfix"></li>
														<li class="col-md-24">
															<label for="comment_body" class="control-label">Вашият коментар <span class="req">*</span></label>
															<textarea id="comment_body" name="comment" cols="40" rows="5"></textarea>
														</li>
														<li class="clearfix"></li>
														<li class="col-md-24 unpadding-top unpadding-bottom">
															<button type="submit" id="comment-submit" class="btn btn-1 unmargin">Добави</button>
														</li>
													</ul>
												</div>
											</form>
											@endauth
										</div>
									</div>
								</article>
							</div>
							<div id="comments">
								<h6 class="title-comment">
									Коментари ({{count($article->comments())}})
								</h6>
								@foreach($article->comments() as $comment)
								<div class="comment">
									<div class="comment-head clearfix">
										<div class="post">
											<span class="author bold">
												{{ $comment->author()->name }}
											</span>
											<span class="date">
												{{ $comment->created_at->format('d') }} {{ $comment->created_at->format('M') }}, {{ $comment->created_at->format('Y') }}
											</span>
										</div>
									</div>
									<div class="comment-content">
										<p>
											{{ $comment->comment }}
										</p>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection
