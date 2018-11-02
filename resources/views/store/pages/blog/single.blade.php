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
                                                    {!! $article->content !!}
                                                </p>
                                            </div>
                                            <footer class="article-extras clearfix">
                                            <ul class="post list-inline">
                                                <li class="author">Jin Alkaid</li>
                                                <li>/</li>
                                                <li class="comment">
                                                <a href="#">
                                                <span>{{count($article->comments())}}</span> Коментара </a>
                                                </li>
                                                <li class="post-action hidden-xs">
                                                <a class="btn btn-prev br" href="#" title="Previous Article"><i class="fa fa-chevron-left"></i></a>
                                                <a class="btn btn-next" href="#" title="Next Article"><i class="fa fa-chevron-right"></i></a>
                                                </li>
                                            </ul>
                                            </footer>
                                            @if($errors->any())
                                            <ul class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @auth
                                        <form method="post" action="{{ route('article_comment', ['article' => $article->id])  }}" id="article-44831939-comment-form" class="comment-form" accept-charset="UTF-8">
                                            {{ csrf_field() }}
                                                <input value="new_comment" name="form_type" type="hidden"><input name="utf8" value="✓" type="hidden">
                                                <div id="comment-form" class="comments">
                                                    <h6 class="general-title">Оставете коментар</h6>
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
                                                        <textarea id="comment_body" name="comment" cols="40" rows="5" class="form-control"></textarea>
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
                            <div id="comments" class="comments">
                                <h6 class="title-comment">Коментари ({{count($article->comments())}})</h6>
                                @foreach($article->comments() as $comment)
                                <div class1="row">
                                    <div class="comment-head clearfix">
                                        <div class="post">
                                            <span class="author">Добавено от <span class="bold">{{ $comment->author()->name }}</span></span>
                                            <span class="date">на {{ $article->created_at->format('d') }} {{ $article->created_at->format('M') }}, {{ $article->created_at->format('Y') }}</span>
                                        </div>
                                        
                                    </div>
                                    <div class="comment-content">
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                </div>
                                <hr>
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