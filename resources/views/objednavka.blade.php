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
    
    <section class="mb-40">
		<div class="container">
        <div id="modal" class="modal">
            <div class="modal-content">
                
                <div class="modal-header">
                    <p>// todo pokud ma vic jak pocet </p> 
                    <h2>Souhrn objednávky</h2>
                </div>               

                <div class="modal-body">
                    <?php $total = 0; ?>
                    @if (count(session('cart')) > 0)
                        <a href="#modal" onClick="showBtn()">Upravit</a>
                        <table class="table">
                            <tr>
                                <th>Cukrovinka</th>
                                <th>Počet</th>
                                <th>Cena</th>
                                <th class="sweet">Upravit</th>
                            </tr>                        

                            @foreach(session('cart') as $id => $row)
                                <?php $total += $row['price'] * $row['quantity']; ?>
                                <tr>     
                                    <td>{{ $row['name'] }}</td>
                                    <td>{{ $row['quantity'] }}</td>
                                    <td>{{ $row['quantity'] * $row['price'] }} Kč</td>   
                                    <td class="sweet">
                                        {{ Form::open(['action' => ['OrderController@removeFromCart', $id] , 'class' => 'form-group']) }}                                        
                                                {{ Form::submit('Odebrat', ['class' => 'genric-btn danger small']) }}                                        
                                            {{ Form::close() }}
                                    </td>
                                    
                                </tr>
                            @endforeach                        
                        </table>
                                        
                        <h3 class="mb-10">Celková cena: {{ $total }} Kč</h3>
                        
                        {{ Form::open(['action' => 'OrderController@order', 'class' => 'form-group']) }}
                            <div class="mb-10">
                                {{ Form::submit('Zaplatit', ['class' => 'form-control genric-btn primary radius']) }}
                            </div>
                        {{ Form::close() }}
                    @else
                        <p>V košíku není žádní zboží.</p>
                    @endif
                </div>
            </div>
        </div>

            <div class="text-right">
                <h2 onClick="openModal()">Košík <i class="fa fa-shopping-cart"></i></h2>

                @if(session('cart'))                
                    <p>Počet položek {{ count(session('cart')) }} </p>                                
                @else
                    <p>Váš košík je prázdný.</p>
                @endif
            </div>
            
			<div class="section-top-border">	
                <h2 class="text-heading">
                    Objednávka
                </h2>

                <!--================ Order Area =================-->
                @foreach($sweets as $sweet)
                    {{ Form::open(['action' => ['OrderController@addToCart', $sweet->id], 'class' => 'row']) }}
                    <div class="col-md-9">
                        {{ $sweet->name }} - {{ $sweet->price }} Kč
                        @if(session('cart'))
                            
                        @endif
                        {{ Form::number('number', '', ['class' => 'form-control', 'placeholder' => 'Dostupný počet ' . $sweet->count, 'max' => $sweet->count, 'min' => 0, 'required' => 'required']) }}
                        
                    </div>
                    <div class="col-md-3">
                        <br>
                        {{ Form::submit('+ do košíku', ['class' => 'genric-btn primary radius form-control']) }}
                            
                    </div>
                                                
                    {{ Form::close() }}
                
                @endforeach
                
			</div>
            <div>
                <div class="mb-10">
                    <button class="form-control genric-btn primary-border" onClick="openModal()">Dokončit objednávku</button>
                </div>
            </div>
        </div>  
    </section>
	
@endsection

<script>
    var bool = 0;
    function openModal() {
        var modal = document.getElementById('modal');

        modal.className = 'modal-open modal-backdrop show';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('modal');
        if (event.target == modal) {
            modal.className = 'modal ';
            modal.className += 'modal-backdrop ';
            modal.className += 'fade ';
        }
    }

    function showBtn() {
        var btns = document.querySelectorAll(".sweet");

        for (let i = 0; i < btns.length; i++) {
            if (bool % 2 == 0)
                btns[i].style.display = "block";
            else
                btns[i].style.display = "none";
        }
        bool++;
    }

</script>
