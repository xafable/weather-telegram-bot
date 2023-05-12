
    <b>{{ Illuminate\Support\Carbon::createFromFormat('Y-m-d', $weather->dayDate)->locale('uk')->dayName }}</b>
    Температура: <b>{{ $weather->dayTemp }}</b>
    Вітер: <b>{{ $weather->dayTemp }}</b>
        @foreach($weather->hourly as $w)

    Час:<b>{{ \Illuminate\Support\Str::substr($w['time'],10) }}</b>
    Температура: <b>{{ $w['temp'] }}</b>
    Вітер: <b>{{ $w['windSpeed'] }}</b>
    Опис: <b>{{ $w['weatherDescription'] }}</b>

        @endforeach







