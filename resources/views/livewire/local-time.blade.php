<!-- in resources/views/components/local-time.blade.php -->
@props(['datetime'])
<span
    x-data="{
        datetime: '{{ $datetime->format('c') }}',
        language: document.querySelector('html').getAttribute('lang'),
    }"
    x-text="(new Date(datetime)).toLocaleString(language, { weekday:'long', year:'numeric', month:'long', day:'numeric', hour:'numeric', minute:'numeric', second:'numeric' })"
></span>


<!-- In your Livewire blade files -->
<x-local-time :datetime="now()->format('c')"/>