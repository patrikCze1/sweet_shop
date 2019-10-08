@extends('layouts.app')

@section('content')
    <!--================ Start banner Area =================-->
	<section class="banner-area relative">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="banner-content col-lg-6">
					<h1>Adminisrace</h1>					
				</div>
			</div>
		</div>
	</section>
    <!--================ End banner Area =================-->
    todo - osetrit pocet objednavek, ukladani objednavek, dodelat kosik, emaily
    zobrazit platbu, u cukrovinek nějaký alergeny?
    označení zboží nebo služby a popis jejich hlavních vlastností,
    dodání je jen na prodejně
    zrušení jen na prodejně?
    reklamační řád
    odstoupení od smlouvy
    <!--================ Order Area =================-->
	<section class="section-gap mb-40">
		<div class="container">
            <div class=" align-items-center">				
                <div class="section-title relative">
                    <h2 class="mb-40">
                        Dnešní objednávky ({{ count($orders) }})
                    </h2>
                    <div class="mb-40">
                        @if(count($orders) > 0)
                            <table class="table">
                                <tr>
                                    <th>Číslo objednávky</th>  
                                    <th>Jméno</th>
                                    <th>Telefon</th>
                                    <th>Vyzvednuto</th>
                                </tr>
                                
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="administrace/{{ $order->id }}">OBJ{{ $order->id }}</a>                                        
                                        </td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>
                                            @if($order->active == 1)
                                                Ne
                                            @else
                                                Ano
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>Žádné objednávky pro dnešek</p>
                        @endif
                    </div>
                    
                </div>				
			</div>
        
            smazat
            <!-- Objednavka --> 
			<div class=" align-items-center">				
                <div class="section-title relative">
                    <h2 class="mb-40">
                        Objednávka
                    </h2>
                    <div class="mb-40">
                        {{ Form::open(['action' => 'AdministrativeController@buy', 'class' => 'form-group']) }}
                            
                            @foreach($availableSweet as $sweet)
                                
                                {{ $sweet->name }} - {{ $sweet->price }} Kč
                                {{ Form::number($sweet->id, '', ['class' => 'form-control', 'placeholder' => 'Dostupný počet ' . $sweet->count, 'max' => $sweet->count, 'min' => 0, 'id' => $sweet->price, 'onChange' => 'calc(value, id)']) }}
                                {{ Form::hidden('id', $sweet->id) }}
                                                     
                            @endforeach
                            
                            
                                <p>Cena: <span id='price'></span> Kč</p> 
                                {{ Form::submit('Koupit', ['class' => 'form-control genric-btn primary radius']) }}
                            
                        {{ Form::close() }}
                    </div>
                    
                </div>				
			</div>
            <!-- Cukrovinky -->
            <div class=" align-items-center">				
                <div class="section-title relative">
                    <h2 class="mb-40">
                        Cukrovinky
                    </h2>
                    <div class="mb-10">
                        <a class="genric-btn primary radius" href="administrace/novy">Přidat cukrovinku</a>
                    </div>
                    <div class="mb-40">
                        <table class="table">
                            <tr>
                                <th>Název</th>
                                <th>Počet kusů na den</th>
                                <th>Cena</th>
                                <th>Akce</th>
                            </tr>
                            
                            @foreach ($sweets as $s)
                                <tr>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->count }} ks</td>
                                    <td>{{ $s->price }} Kč</td>
                                    <td>
                                        <a href="administrace/{{ $s->id }}/upravit">Upravit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        
                    </div>
                    
                </div>				
			</div>
		</div>
	</section>
    <script>
        var p = 0;
        function calc(number, price) {
            p += number * price;
            var el = document.getElementById('price');
            el.innerHTML = p;
            console.log(p);
        }        
    </script>
@endsection

