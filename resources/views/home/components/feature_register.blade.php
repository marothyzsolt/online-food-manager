<section class="contact-us">
    <div class="bg-shape-style"></div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="contact-from">
                    <h5>Regisztráció</h5>
                    <form action="/register" method="post">
                        @csrf
                        <input type="text" name="name" placeholder="Név*">
                        <input type="email" name="email" placeholder="E-mail cím*">
                        <input type="password" name="password" placeholder="Jelszó*">
                        <input type="password" name="password_confirm" placeholder="Jelszó mégegyszer*">
                        <select class="form-select block mt-1 w-full select" name="type" id="type" required>
                            <option selected disabled>Felhasználó típus</option>
                            @foreach (App\Models\User::TYPE_LIST as $type)
                                <option {{ old('type') == $type ? "selected" : "" }} value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="Regisztráció">
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 col-12">
                <div class="contact-home-chef">
                    <div class="section-header">
                        <h3>Regisztrálj hozzánk.</h3>
                        <p>Töltsd ki az űrt a csapatunkban, vagy ebédelj egy fantasztikusat...</p>
                    </div>
                    <div class="section-wrapper">
                        <div class="contact-count-item">
                            <div class="contact-count-inner">
                                <div class="contact-count-thumb">
                                    <img src="/assets/images/home/users.png" alt="food-contact" width="70">
                                </div>
                                <div class="contact-count-content">
                                    <h5><span class="counter">{{ \App\Models\User::count() }}</span>+</h5>
                                    <p>Felhasználó</p>
                                </div>
                            </div>
                        </div>
                        <div class="contact-count-item">
                            <div class="contact-count-inner">
                                <div class="contact-count-thumb">
                                    <img src="/assets/images/home/restaurant.png" alt="food-contact" width="70">
                                </div>
                                <div class="contact-count-content">
                                    <h5><span class="counter">{{ \App\Models\Restaurant::count() }}</span>+</h5>
                                    <p>Étterem</p>
                                </div>
                            </div>
                        </div>
                        <div class="contact-count-item">
                            <div class="contact-count-inner">
                                <div class="contact-count-thumb">
                                    <img src="/assets/images/home/food.png" alt="food-contact" width="70">
                                </div>
                                <div class="contact-count-content">
                                    <h5><span class="counter">{{ \App\Models\Item::count() }}</span>+</h5>
                                    <p>Étel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="contact-thumb">
                    <img src="assets/images/contac/01.png" alt="food-contact">
                </div>
            </div>
        </div>
    </div>
</section>