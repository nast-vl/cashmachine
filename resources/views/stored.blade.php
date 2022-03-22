@extends('layouts.default')

@section('content')
    <div class="ui container grid">
        <div class="sixteen wide column">
            @if(session()->has('transaction'))
                <div class="ui center aligned info message">
                    <div class="content">
                        <div class="header">
                            <i class="massive hand holding usd icon"></i>
                            <p>Your transaction has been saved.</p>
                        </div>
                        <pre style="text-align: initial">@json(session()->get('transaction.inputs'), JSON_PRETTY_PRINT)</pre>
                    </div>
                </div>
            @else
                <div class="ui center aligned warning message">
                    <div class="content">
                        <div class="header">
                            <i class="massive question circle outline icon"></i>
                            <p>When are you going to add a transaction?</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
