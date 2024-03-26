<x-layout>
    @include('partials._hero')
    @include('partials._search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-auto max-w-screen-xl">
        @unless ( count($listings) == 0 )

        @foreach ($listings as $listing)
        <x-listing-card :listing="$listing" />
        @endforeach


        @else
        <p>no listing found</p>
        @endunless


    </div>

</x-layout>