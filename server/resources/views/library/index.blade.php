@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
                @foreach ($items as $item)
                <h2>{{ $item['volumeInfo']['title']}}</h2>
                    @if (array_key_exists('imageLinks', $item['volumeInfo']))
                        <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}"><br>
                    @endif
                                    
                    @if (array_key_exists('description', $item['volumeInfo']))
                        著者：{{ $item['volumeInfo']['authors'][0]}}<br>
                    @endif
                    @if (array_key_exists('description', $item['volumeInfo']))
                        発売年月：{{ $item['volumeInfo']['publishedDate']}}<br>
                    @endif
                    <br>
                    {{-- @foreach ($item['volumeInfo']['industryIdentifiers'] as $industryIdentifier)
                        {{ $industryIdentifier['type'] }}&nbsp;：&nbsp;{{ $industryIdentifier['identifier'] }} <br>
                    @endforeach --}}
                    <br>
                    @if (array_key_exists('description', $item['volumeInfo']))
                        概要：{{ $item['volumeInfo']['description']}}<br>
                    @endif
                    <br>
                    <hr>
                @endforeach
                {{-- <script src="https://gist.github.com/t-nissie/021f09aa327f02d0a710.js"></script>
                <script src= {{ $gist }} "></script>
                {{ $gist }} --}}
                <p>配列arrayのソースコード</p>
                <pre class="prettyprint linenums">
                    <code>
                        $countries = ['Japan', 'America', 'China'];
                        echo $countries[0] . '<br>';
                        echo $countries[1] . '<br>';
                        echo $countries[2] . '<br>';
                    </code>
                </pre>
                <p>制御構文ifのソースコード</p>
                <pre class="prettyprint linenums">
                    <code>
                        $num = 11;
                        $prime = true;
                        
                        if ($num == 1 || $num == 0) {
                            $prime = false;
                        } else {
                            for ($i=2; $i<$num; $i++) {
                                if ($num % $i == 0) {
                                    $prime = false;
                                    break;
                                }
                            }
                        }
                        if ($prime) {
                            echo $num . ' は素数です';
                        } else {
                            echo $num . ' は素数ではありません';
                        }
                    </code>
                </pre>
                <p>制御構文ifのソースコード2</p>
                <pre class="prettyprint linenums">
                    <code>
                        $num1 = $_GET['num1'];
                        $num2 = $_GET['num2'];
                        $operator = $_GET['operator'];

                        if ($operator == 'addition') {
                            $add = $num1 + $num2;
                            echo $num1 . ' + ' . $num2 . ' = ' . $add;
                        } elseif ($operator == 'subtraction') {
                            $sub = $num1 - $num2;
                            echo $num1 . ' - ' . $num2 . ' = ' . $sub;
                        } elseif ($operator == 'multiplication') {
                            $mul = $num1 * $num2;
                            echo $num1 . ' * ' . $num2 . ' = ' . $mul;
                        } elseif ($operator == 'division') {
                            $div = $num1 / $num2;
                            echo $num1 . ' / ' . $num2 . ' = ' . $div;
                        } else {
                            echo '正しい演算子を指定して下さい';
                        }
                    </code>
                </pre>
        </div>
    </div>
</div>
@endsection
