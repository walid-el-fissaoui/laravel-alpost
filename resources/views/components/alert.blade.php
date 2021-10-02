@if (session()->has('status'))
<div class="alert alert-info">
    <strong>info: </strong> {{session()->get('status')}}
</div>
@endif