@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Minesweeper</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <minesweeper
                        minesweeper-route="{{ route('minesweeper.index') }}"
                    ></minesweeper>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Instructions</div>
                <div class="card-body">
                    <ul>
                        <li>You can flag a field by right clicking into it.</li>
                        <li>You can remove the flag by right clicking into it again.</li>
                        <li>The size input accepts between 1 and 24</li>
                        <li>The dificulty accepts between 1 and 100 (higher is harder)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
