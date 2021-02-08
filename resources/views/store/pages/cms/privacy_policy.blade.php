@extends('store.layouts.app', ['bodyClass' => 'templatePage'])

@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<!-- Content -->
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('privacy_policy') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header">
							<h1 id="page-title">{{ $title }}</h1>
						</div>
					</div>
				</div>
				<div id="col-main" class="contact-page clearfix">
					<div class="group-contact clearfix">
						<div class="container">
							<div class="row">
								<div class="col-md-24">{!! $page_content !!}</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection