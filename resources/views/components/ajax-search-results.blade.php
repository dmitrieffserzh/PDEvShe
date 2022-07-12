@if(count($results) > 0)
@foreach($results as $item)
    @include('components.profiles.item_list', ['item' => $item])
@endforeach
@else
<div class="no-result">По вашему запросу нет результатов!</div>
@endif