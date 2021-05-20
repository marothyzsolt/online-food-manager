<footer class="footer">
    <div class="bg-shape-style"></div>
    <div class="container">
        <div class="footer-top">
            <div class="footer-area text-center">
                <div class="footer-menu">
                    <ul>
                        <li><a href="/">Főoldal</a></li>
                        <li><a href="/restaurants">Éttermek</a></li>
                        <li><a href="/register">Regisztráció</a></li>
                        <li><a href="/login">Bejelentkezés</a></li>
                    </ul>
                </div>
                <div class="w-100 text-center color-white">
                    Jelenlegi idő: {{ now()->format('Y. m. d. H:i:s') }}
                </div>
            </div>
        </div>
    </div>
</footer>