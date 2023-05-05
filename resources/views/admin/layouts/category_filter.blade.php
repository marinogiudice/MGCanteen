{{-- 
    shows the html select element used for category selection in the create and edit operations for products and categories.
    It's also used for the category filter.
    Checks if category or products elements are in the page and behaves accordingly.
    It's included where required.
    --}}
<div class="form-row">
    <div class="col form-group">
        <label for="category" class="d-block">Category</label>
        <select class="form-control d-inline w-50" name="category">
            <option value="">Select Category</option>
            @if(isset($category))
                @if($category->parent_category === null)
                <option value="master" selected>Master</option>
                @endif
            
            @endif
            @if(isset($product))
                @if($product->product_category === null)
                    <option value="main" selected>Master</option>
                @endif
            @endif
            @if(!isset($category) && !isset($product))
                <option value='main'>Master</option>
            @endif
            
            @foreach ($categories as $categoryEl)
                 @php $ident= str_repeat('- ',$categoryEl->get_depth()); 
                $selected="";
                if(isset($category)) {
                    if($categoryEl->get_category_name() == $category->parent_category) {
                         $selected='selected';
                    }
                }
                if(isset($product)) {
                    if($categoryEl->get_category_name() == $product->product_category) {
                         $selected='selected';
                    }
                }
                
                @endphp
                @if(isset($children))
                @if(!($children->contains($categoryEl->get_category_name()) ) && (!($categoryEl->get_category_name() == $category->category_name)))
                    <option value="{{ $categoryEl->get_category_name() }}"  @if (old('category') == $categoryEl->get_category_name()) selected="selected" @endif {{ $selected }} >{{ $ident.$categoryEl->get_category_name() }}</option>
                @endif
                @else
                <option value="{{ $categoryEl->get_category_name() }}"  @if (old('category') == $categoryEl->get_category_name()) selected="selected" @endif {{ $selected }} >{{ $ident.$categoryEl->get_category_name() }}</option>
                @endif
            @endforeach
            
        </select>
    
        