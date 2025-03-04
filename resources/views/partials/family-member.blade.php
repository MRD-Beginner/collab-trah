{{-- <li>
    <a href="#">
        <img src="{{ $member->photo ?? 'images/1.jpg' }}" alt="{{ $member->name }}">
        <span>{{ $member->name }}</span>
    </a>
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif
</li> --}}

<li>
    <a href="#">
        {{-- <img src="{{ $member->photo ?? 'images/1.jpg' }}" alt="{{ $member->name }}"> --}}
        <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" 
        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
        <span>{{ $member->name }}</span>
    </a>
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif
</li>