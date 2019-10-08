<div>
    <h1>Nová objednávka.</h1>
    <p>Na jméno: {{ $name }} <br>
    Telefon: {{ $phone }} <br>
    </p>
    <p>Objednávka na {{ $date }} <br>
    
    <a href="{{ URL('/administrace/' . $id) }}">Detail objednávky</a></p>
</div>