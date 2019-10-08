@extends('layouts.app')

@section('content')
    <section class="banner-area relative">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="banner-content col-lg-6">
					<h1>Kontakt</h1>
					
				</div>
			</div>
		</div>
    </section>
    
    <!--================ Contact Area =================-->
	<section class="contact-area section-gap">
		<div class="container">
            <div class="">
                <h2>Kontakt</h2>
                <p>Kontakt na osobu...</p>
            </div>
			<div class=" align-items-center">				
                <div class="section-title relative">
                    <h2>
                        Napište nám
                    </h2>
                    <div class="mb-40">
                        {{ Form::open( ['action' => 'EmailController@contact', 'class' => 'form-group']) }}
                            <div class="mb-10">
                                {{ Form::email('mail', '', ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required']) }}
                            
                            </div>
                            <div class="mb-10">
                                {{ Form::textarea('text', '', ['class' => 'form-control', 'placeholder' => 'Vaše zpráva...', 'required' => 'required']) }}
                            </div>
                            <div class="mb-10">
                                {{ Form::submit('Poslat', ['class' => 'form-control']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                    
                </div>				
			</div>
            <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1348.034989473965!2d15.812398719649572!3d50.20628156704734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1scs!2scz!4v1561625015467!5m2!1scs!2scz" frameborder="0" style="border:0; width:100%; height:400px" allowfullscreen></iframe>
            </div>
		</div>
	</section>
	<!--================ End Contact Area =================-->

@endsection