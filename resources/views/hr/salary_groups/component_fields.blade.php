        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">components</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row mb-3">
                                @php
                                    $salaryGroupComponent = isset($salaryGroup) ? $salaryGroup->salaryGroupDetails()->pluck('component_id','component_id') : []; 
                                @endphp                                
                                @forelse ($components as $index => $groupComponents)
                                    <div class="col-md-6 mb-6">
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
                                            @foreach ($groupComponents as $item)
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="components[][component_id]" @if(isset($salaryGroupComponent[$item->id])) checked @endif value="{{ $item->id }}" class="form-check-input">
                                                        {{ $item->name }}
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
        <script>
            function checkAll(elm, parent){
                const _checked = $(elm).is(':checked') ? 1 : 0                
                $(elm).closest(parent).find(':checkbox').not(elm).prop('checked', _checked)
            }
        </script>