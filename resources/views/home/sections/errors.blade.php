@if (count($errors)>0)
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li class="text-alert">{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
