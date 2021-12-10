@if (isset($errors) && $errors->any())
<div class="mb-4">
    <div class="alert alert-danger">
        <ul data-cy="validation-error" class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
