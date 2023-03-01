{{-- The table select view.
     It's used to show the available table numbers in a select options element.
     It's included as table filter in the tables view to skim the results of the table listing 
     and in the cart proceed view to let the customer specify where he is sitting.    
    --}}
<div class="form-row">
    <div class="col form-group">
        <div class="row align-self-cenetr">
            <div class="col">
                <label for="table" class="d-block">Table</label>
                <select class="form-control" name="table">
                    <option value="">Select Table</option>
                    @foreach($tables as $table)
                    <option value="{{ $table->table_number }}">{{ $table->table_number }}</option>
                    @endforeach
                </select>
            </div>