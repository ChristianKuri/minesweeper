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
    </div>
</div>
@endsection
