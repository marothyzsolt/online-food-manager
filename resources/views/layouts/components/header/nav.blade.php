<ul>
    <li>
        <a class="active" href="{{ route('home') }}">Főoldal</a>
    </li>
    @auth
        @switch ($role)
            @case('admin')
                <li>
                    <a href="#">Éttermek</a>
                    <ul>
                        <li><a href="/restaurants">Összes elérhető étterem</a></li>
                        <li><a href="/admin/restaurants">Saját éttermek</a></li>
                        <li><a href="/admin/restaurants/create">Új étterem regisztrálása</a></li>
                    </ul>
                </li>
                <li>
                    <a class="" href="/admin/orders">Megrendelések</a>
                </li>
                <li>
                    <a class="" href="/admin/couriers">Futárok</a>
                </li>
                @break
            @case('guest')
                <li>
                    <a class="" href="/restaurants">Éttermek</a>
                </li>
                <li>
                    <a class="" href="/admin/orders">Megrendelések</a>
                </li>
                @break
            @case('courier')
            <li>
                <a class="" href="/courier/orders">Aktív megrendelések</a>
            </li>
            @break
        @endswitch

        <li>
            <a class="" href="/logout">Kijelentkezés</a>
        </li>
    @endauth

    @guest
        <li>
            <a class="" href="/restaurants">Éttermek</a>
        </li>
        <li>
            <a class="" href="/register">Regisztráció</a>
        </li>
    @endguest
</ul>