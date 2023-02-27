@props(['name'])

@error($name)
    <div class=" mx-2 text-danger"> {{ $message }} </div>
@enderror