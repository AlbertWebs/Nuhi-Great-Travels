@extends('layouts.master-page')

@section('title', 'Compare Fleets')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Compare Two Fleets</h2>

    <form action="{{ route('fleets.compare.result') }}" method="GET">
        <div class="mb-3">
            <label for="fleetA_id" class="form-label">Select First Fleet</label>
            <select name="fleetA_id" id="fleetA_id" class="form-select" required>
                <option value="" disabled selected>Choose first car</option>
                @foreach($fleets as $fleet)
                    <option value="{{ $fleet->id }}">{{ $fleet->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fleetB_id" class="form-label">Select Second Fleet</label>
            <select name="fleetB_id" id="fleetB_id" class="form-select" required>
                <option value="" disabled selected>Choose second car</option>
                @foreach($fleets as $fleet)
                    <option value="{{ $fleet->id }}">{{ $fleet->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Compare</button>
    </form>
</div>
@endsection
