@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                       <form action="/course" method="POST">
                           @csrf
                           <input name="valid_till" type="date" value="2020-11-01 23:59:59"/>
                           <input name="price" type="number"/>
                           <input name="name" type="text"/>
                           <input type="submit">
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
