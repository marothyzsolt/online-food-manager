<ul>
    <li>
        <a class="active" href="{{ route('home') }}">Főoldal</a>
    </li>
    @auth
        @switch ($role)
            @case('admin')
            @break
            @case('guest')
                <li>
                    <a class="" href="/restaurants">Éttermek</a>
                </li>
            @break
            @case('courier')
            @break
        @endswitch
        <li>
            <a href="#">Éttermek</a>
            <ul>
                <li><a href="{{ route('restaurants.index') }}">Összes elérhető étterem</a></li>
                <li><a href="{{ route('restaurants.create') }}">Új étterem regisztrálása</a></li>
            </ul>
        </li>
    @endauth

    @guest
        <li>
            <a class="" href="/restaurants">Éttermek</a>
        </li>
    @endguest
</ul>