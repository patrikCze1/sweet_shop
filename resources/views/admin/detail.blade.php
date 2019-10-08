@extends('layouts.app')

@section('content')
<div class="container">
    <div class=" align-items-center">				
        <div class="section-title relative">
            <h2 class="mb-40">
                Detail objednávky {{ $order->id }}
            </h2>

            <div class="mb-40">
                <p> Na jméno: {{ $order->name }}<br>
                Telefon: {{ $order->phone }} <br>
                Vytvořeno: {{ date('d. m. Y.', strtotime($order->created_at)) }}</p>
                <div class="mb-10">
                    <h3>Seznam cukrovinek</h3>
                    <table class="table">
                        <tr>
                            <th>Cukrovinka</th>
                            <th>Počet</th>
                        </tr>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->sweet }}</td>
                                <td>{{ $item->count }}</td>
                            </tr>
                        @endforeach
                    </table>
                    
                    <p>Celková cena: {{ $order->price }} Kč</p>
                </div>
                @if($order->active == 1)
                    {{ Form::open(['action' => 'AdministrativeController@deactivate', 'class' => 'form-group']) }}
                        {{ Form::hidden('id', $order->id) }}
                        <div class="mb-10">
                            {{ Form::submit('Vyzvednuto', ['class' => 'form-control genric-btn info radius']) }}
                        </div>
                    {{ Form::close() }}
                @else
                    <p>Objednávka byla vyzvednuta.</p>
                @endif
            </div>
            <a href="{{ URL::previous() }}">Zpět</a>
            
        </div>				
    </div>
</div>
@endsection