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
                            <a href="./index.html" class="homepage-link" title="Back to the frontpage">Начало</a>							
                            <span>/</span>
                            <a href="./blog.html" title="">Блог</a>
                            <span>/</span>
                            <span class="page-title">{{ $article->title }}</span>
                        </div>
                    </div>
                </div>
            </div>                
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title" class="large">{{ $article->title }}</h1>
                        </div>
                        <div id="col-main" class="blog article-page col-xs-24 col-sm-24 ">
                            <div class="article">
                                <article class="blogs-item">
                                    <div class="row">
                                        <div class="article-content col-md-24">
                                            <div>
                                                <div class="date">
                                                    <p>
                                                        <small>{{ $article->created_at->format('M') }}</small><span>{{ $article->created_at->format('d') }}</span>
                                                    </p>
                                                </div>
                                                <h4 class="blog-title">{{ $article->title }}</h4>
                                            </div>
                                            <div class="blogs-image">
                                                <ul class="list-inline">
                                                    <li><img src="{{ asset("uploads/blog/" . $article->thumbnail) }}" alt=""></li>
                                                </ul>
                                            </div>
                                            <div class="intro">
                                                <p>
                                                    {{ $article->content }}
                                                </p>
                                            </div>
                                            <footer class="article-extras clearfix">
                                            <ul class="post list-inline">
                                                <li class="author">Jin Alkaid</li>
                                                <li>/</li>
                                                <li class="comment">
                                                <a href="#">
                                                <span>3</span> Comment </a>
                                                </li>
                                                <li class="post-action hidden-xs">
                                                <a class="btn btn-prev br" href="#" title="Previous Article"><i class="fa fa-chevron-left"></i></a>
                                                <a class="btn btn-next" href="#" title="Next Article"><i class="fa fa-chevron-right"></i></a>
                                                </li>
                                            </ul>
                                            </footer>
                                            <form method="post" action="/blogs/blogs/44831939-vel-illum-qui-dolorem-eum-fugiat/comments" id="article-44831939-comment-form" class="comment-form" accept-charset="UTF-8">
                                                <input value="new_comment" name="form_type" type="hidden"><input name="utf8" value="✓" type="hidden">
                                                <div id="comment-form" class="comments">
                                                    <h6 class="general-title">Leave a comment</h6>
                                                    <ul class="contact-form row list-unstyled">
                                                        <li class="col-md-24">
                                                        <label for="comment_author" class="control-label">Your name <span class="req">*</span></label>
                                                        <input id="comment_author" name="comment[author]" class="form-control" type="text">
                                                        </li>
                                                        <li class="clearfix"></li>
                                                        <li class="col-md-24">
                                                        <label for="comment_email" class="control-label">Your email <span class="req">*</span></label>
                                                        <input id="comment_email" name="comment[email]" class="form-control" type="text">
                                                        </li>
                                                        <li class="clearfix"></li>
                                                        <li class="col-md-24">
                                                        <label for="comment_body" class="control-label">Your comment <span class="req">*</span></label>
                                                        <textarea id="comment_body" name="comment[body]" cols="40" rows="5" class="form-control"></textarea>
                                                        </li>
                                                        <li class="clearfix"></li>
                                                        <li class="col-md-24 unpadding-top unpadding-bottom">
                                                        <button type="submit" id="comment-submit" class="btn btn-1 unmargin">Post Comment</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div id="comments" class="comments">
                                <h6 class="title-comment">Comments (3)</h6>
                                <div class="row">
                                    <div class="comment-head clearfix">
                                        <div class="post">
                                            <span class="author">Post by <span class="bold">Jin 01</span></span>
                                            <span class="date">on 30 Jun, 2015</span>
                                        </div>
                                        <div class="post-reply">
                                            <button class="btn enable" onclick="window.location='#'" title="Add your thoughts">Reply</button>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo dolore voluptas nulla pariatur ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="comment-head clearfix">
                                        <div class="post">
                                            <span class="author">Post by <span class="bold">Jin 01</span></span>
                                            <span class="date">on 30 Jun, 2015</span>
                                        </div>
                                        <div class="post-reply">
                                            <button class="btn enable" onclick="window.location='#'" title="Add your thoughts">Reply</button>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>Shoe street style leather tote oversized sweatshirt A.P.C. Prada Saffiano crop slipper denim shorts spearmint. Braid skirt round sunglasses seam.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="comment-head clearfix">
                                        <div class="post">
                                            <span class="author">Post by <span class="bold">Jin 01</span></span>
                                            <span class="date">on 30 Jun, 2015</span>
                                        </div>
                                        <div class="post-reply">
                                            <button class="btn enable" onclick="window.location='#'" title="Add your thoughts">Reply</button>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection