@props(['errors'])

@if ($errors->any())
<<<<<<< HEAD
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }}>
        <div class="font-medium text-red-600">
            Whoops! Something went wrong.
=======
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif