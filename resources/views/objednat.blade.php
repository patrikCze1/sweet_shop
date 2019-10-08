@extends('layouts.app')

@section('content')
    <!--================ Start banner Area =================-->
	<section class="banner-area relative">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="banner-content col-lg-6">
					<h1>Objednat</h1>					
				</div>
			</div>
		</div>
	</section>
    <!--================ End banner Area =================-->
    
    <section class="contact-area section-gap mb-40">
		<div class="container">
            
			<div class=" align-items-center">				
                <div class="section-title relative">
                    <h2 class="mb-40">
                        Objednávka
                    </h2>
                    <div class="mb-40">
                        {{ Form::open(['action' => 'OrderController@prepare', 'class' => 'form-group']) }}
                            @if (Auth::user())
                                <div class="mb-10">
                                    Jméno                                
                                    {{ Form::text('name', 'Admin', ['class' => 'form-control', 'placeholder' => 'Jméno', 'required' => 'required']) }}
                                
                                </div>
                                <div class="mb-10">
                                    Telefon
                                    {{ Form::text('phone', '111222333', ['class' => 'form-control', 'placeholder' => 'Telefon', 'required' => 'required']) }}
                                
                                </div>
                            @else                            
                                <div class="mb-10">
                                    Jméno                                
                                    {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Jméno', 'required' => 'required']) }}
                                
                                </div>
                                <div class="mb-10">
                                    Telefon
                                    {{ Form::text('phone', '', ['class' => 'form-control', 'placeholder' => 'Telefon', 'required' => 'required']) }}
                                
                                </div>
                            @endif                            
                            <div class="mb-10">
                                Na kdy
                                {{ Form::date('date', $today, ['class' => 'form-control', 'required' => 'required', 'id' => 'date', 'onChange' => 'checkDay()']) }}
                            </div>
                            <div class="mb-10">
                                {{ Form::submit('Další', ['class' => 'form-control genric-btn primary radius', 'id' => 'orderBtn']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                    
                </div>				
			</div>

            
	</section>
	
@endsection
<script>
    function checkDay() {
        var input = document.getElementById("date").value;
        var date = new Date(input);

        if (date.getDay() == 0) { //sunday
            alert('Zvolené datum je neděle. Prosím zvolte jiný den.');
            document.getElementById("orderBtn").disabled = true;
        } else {
            document.getElementById("orderBtn").disabled = false;
        }
    }
</script>