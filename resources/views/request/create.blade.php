@extends('layouts.app')

@section('title', 'Raise Blood Requisition')

@section('content')
<div class="form-page-container">
    <div class="form-header">
        <h2>Raise Blood Requisition</h2>
        <p>Submit details to search and alert matching donors in your locality.</p>
    </div>

    <div class="card">
        <form action="{{ route('request.store') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="requester_name">Patient / Requester Name</label>
                <input type="text" name="requester_name" id="requester_name" class="form-input @error('requester_name') is-invalid @enderror" value="{{ old('requester_name') }}" required>
                @error('requester_name')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid-2" style="gap: 1rem; margin-bottom: 1.25rem;">
                <div class="form-group">
                    <label for="blood_group">Required Blood Group</label>
                    <select name="blood_group" id="blood_group" class="form-select @error('blood_group') is-invalid @enderror" required>
                        <option value="">Select Group</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gp)
                            <option value="{{ $gp }}" {{ old('blood_group') == $gp ? 'selected' : '' }}>{{ $gp }}</option>
                        @endforeach
                    </select>
                    @error('blood_group')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="units_needed">Units Required</label>
                    <input type="number" name="units_needed" id="units_needed" class="form-input @error('units_needed') is-invalid @enderror" value="{{ old('units_needed', 1) }}" min="1" max="20" required>
                    @error('units_needed')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="hospital">Hospital / Medical Center Name</label>
                <input type="text" name="hospital" id="hospital" class="form-input @error('hospital') is-invalid @enderror" value="{{ old('hospital') }}" placeholder="e.g. Mercy General Hospital" required>
                @error('hospital')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid-2" style="gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="city">City / Locality</label>
                    <input type="text" name="city" id="city" class="form-input @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                    @error('city')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="urgency">Urgency Level</label>
                    <select name="urgency" id="urgency" class="form-select @error('urgency') is-invalid @enderror" required>
                        <option value="normal" {{ old('urgency') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="urgent" {{ old('urgency') == 'urgent' ? 'selected' : '' }}>Urgent (Alert Donors)</option>
                    </select>
                    @error('urgency')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="background-color: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 2rem; font-size: 0.85rem; color: var(--text-muted);">
                <strong>Note on Urgent Requests:</strong> Selecting "Urgent" triggers automatic real-time email alerts to all matching, available blood donors registered in your local city.
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px;">Submit Requisition</button>
        </form>
    </div>
</div>
@endsection
