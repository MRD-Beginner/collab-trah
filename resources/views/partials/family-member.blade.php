<li>
    <a href="#">
        @if ($member->photo)
        <div class="d-flex"> 
            <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" 
                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" 
                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
        </div>
        @else
            @if ($member->gender == 'Laki-Laki')
                <img src="{{ asset('../img/male.png') }}" alt="Foto Default Laki-laki" 
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @elseif ($member->gender == 'Perempuan')
                <img src="{{ asset('../img/female.png') }}" alt="Foto Default Perempuan" 
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @endif
        @endif
        <span class="capitalize">{{ $member->name }}</span>
        {{-- <span class="capitalize">{{ $member->name }}</span> --}}
    </a>
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif
</li>