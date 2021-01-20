@extends('app')
@section('content')
    <link type="text/css" href="{{ asset('./css/style.css') }}" rel="stylesheet">
    <section>
        <h1>Rappers List</h1>
        <div class="mb-2 p-2">
                <form id="filter" data-filter="" action="/" method="POST">
{{--                @csrf <!-- {{ csrf_field() }} -->--}}
<!--                    <select class="form-control form-control-sm" name="genre" id="genre">-->
                    <div class="form-inline">
                        <select name="genre" class="form-control">
                            <option value="freestyle">freestyle</option>
                            <option value="gangsta">gangsta</option>
                            <option value="hardcore">hardcore</option>
                            <option value="nerdcore">nerdcore</option>
                            <option value="any">any</option>
                        </select>
                        <select name="dead_baddy" class="form-control ml-2">
                            <option value="1">Killed in a fight</option>
                            <option value="0">Not killed in a fight</option>
                            <option value="any">any</option>
                        </select>
                        <div class="mb-2 mt-2 ml-4">
                            From <input type="date" name="date_after" class="form-control">
                            To <input type="date" name="date_before" class="form-control">
                        </div>
                    </div>
                    <div class="form-inline mt-2">
                        <div>
                            Cool Moves Count Range: <input type="number" name="moves_min" min="0" class="form-control">
                            – <input type="number"  name="moves_max" min="0" class="form-control">
                        </div>
                        <div class="ml-4">
                            Country: <input type="text" name="country" class="form-control">
                        </div>
                    </div>
                    <div class="form-inline mt-3">
                        Sort By:
                        <select name="sort_name" class="form-control ml-2">
                            <option value="name">Name</option>
                            <option value="genre">Genre</option>
                            <option value="label">Label</option>
                            <option value="country">Country</option>
                            <option value="from">From</option>
                            <option value="dead_baddy">Dead Baddy</option>
                            <option value="cool_moves_count">Cool Moves Count</option>
                            <option value="swearing_frequency">Swearing Frequency</option>
                            <option value="any">Default</option>
                        </select>
                        <select name="sort_dir" class="form-control ml-2">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                        <input type="submit" class="btn btn-warning ml-4" value="Filter">
                    </div>

                </form>
        </div>
        <table class="table table-bordered table-hover table-sm rappers">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Genre</th>
                <th scope="col">Label</th>
                <th scope="col">Country</th>
                <th scope="col">From</th>
                <th scope="col">Dead Baddy</th>
                <th scope="col">Cool Moves Count</th>
                <th scope="col">Swearing Frequency</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="pager"></div>
        <form id="generation" class="" action="/generate" method="POST">
        @csrf <!-- {{ csrf_field() }} -->
            <div class="form-inline">
                <label for="generation_count" class="mr-2">Count</label>
                <input class="form-control mr-2" type="number" min="1" value="1" name="generation_count">
                <input class="btn btn-primary" type="submit" value="Generate">
            </div>
            <a class="btn btn-primary mt-4" href="/create">Create rapper</a>
        </form>
        <script src="./js/app.js"></script>
    </section>
@endsection
