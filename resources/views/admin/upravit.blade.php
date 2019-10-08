@extends('layouts.app')

@section('content')
<div class="container">
    <div class=" align-items-center">				
        <div class="section-title relative">
            <h2 class="mb-40">
                Upravit cukrovinku: {{ $sweet->name }}
            </h2>
            <div class="mb-40">
                {{ Form::open(['action' => 'SweetController@update', 'class' => 'form-group']) }}
                    {{ Form::hidden('id', $sweet->id) }}
                    <div class="mb-10">
                        Název
                        {{ Form::text('name', $sweet->name, ['class' => 'form-control']) }}
                    
                    </div>
                    <div class="mb-10">
                        Počet
                        {{ Form::number('count', $sweet->count, ['class' => 'form-control']) }}
                    
                    </div>
                    <div class="mb-10">
                        Cena za ks (Kč)
                        {{ Form::number('price', $sweet->price, ['class' => 'form-control']) }}
                    
                    </div>
                    <div class="mb-10">
                        {{ Form::submit('Upravit', ['class' => 'form-control genric-btn primary radius']) }}
                    </div>
                {{ Form::close() }}
            </div>
            {{ Form::open(['action' => 'SweetController@deactivate', 'class' => 'form-group']) }}
                    {{ Form::hidden('id', $sweet->id) }}
                    <div class="mb-10">
                        {{ Form::submit('Smazat', ['class' => 'form-control genric-btn danger radius']) }}
                    </div>
            {{ Form::close() }}
            <a href="{{ URL::previous() }}">Zpět</a>
            
        </div>				
    </div>
</div>
@endsection