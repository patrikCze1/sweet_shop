@extends('layouts.app')

@section('content')
<div class="container">
    <div class=" align-items-center">				
        <div class="section-title relative">
            <h2 class="mb-40">
                Nová cukrovinka
            </h2>
            <div class="mb-40">
                {{ Form::open(['action' => 'SweetController@store', 'class' => 'form-group']) }}
                    <div class="mb-10">
                        Název
                        {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Název']) }}
                    
                    </div>
                    <div class="mb-10">
                        Počet
                        {{ Form::number('count', '', ['class' => 'form-control', 'placeholder' => 'Počet kusů']) }}
                    
                    </div>
                    <div class="mb-10">
                        Cena za ks (Kč)
                        {{ Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Cena']) }}
                    
                    </div>
                    <div class="mb-10">
                        {{ Form::submit('Vytvořit', ['class' => 'form-control genric-btn primary radius']) }}
                    </div>
                {{ Form::close() }}
            </div>
            <a href="{{ URL::previous() }}">Zpět</a>
        </div>				
    </div>
</div>
@endsection