        <div class="col-12 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Unit</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row mb-3">
                                @php
                                    $roleUnit = isset($role) ? $role->units->pluck('id','id') : []; 
                                @endphp                                
                                @forelse ($units as $index => $groupUnits)
                                    <div class="col-md-4">
                                        <div class="card border-primary">
                                            <div class="card-header">
                                                <div class="">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" onclick="checkAll(this,'.card')">
                                                        {{ $index }}                                                        
                                                    </label>
                                                </div>                                            
                                            </div>
                                            <div class="card-body">
                                            @foreach ($groupUnits as $unit)
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="units[]" @if(isset($roleUnit[$unit->id])) checked @endif value="{{ $unit->id }}" class="form-check-input">
                                                        {{ $unit->nama }} ( {{ $unit->divapp }}{{ $unit->unit }} )
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    ----
                                @endforelse                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        