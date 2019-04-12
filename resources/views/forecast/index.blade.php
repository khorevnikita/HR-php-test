@extends("layouts.app")
@section("content")
    <h3>Weather</h3>
    @foreach($forecast as $day)
        <div class="well well-lg">
            <h4>{{\Carbon\Carbon::parse($day->date)->format("d.m.Y")}}</h4>
            <ul class="list-unstyled">
                @foreach($day->parts as $key=>$day_part)
                    @if(isset($day_part->temp_avg))
                    <li>
                        <p>{{$key}}:</p>
                        <span class="label label-default">{{$day_part->temp_avg>0?"+ ".$day_part->temp_avg:$day_part->temp_avg}}</span>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endforeach
@endsection