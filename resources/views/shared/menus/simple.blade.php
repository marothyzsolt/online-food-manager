<div class="post-item">
    <div class="post-inner">
        <div class="post-thumb">
            <a href="#">
                <img src="{{ $menu->media->link }}" alt="menu-img">
            </a>
        </div>
        <div class="post-content">
            <div class="">
                <div class="categori">
                    <span>{{ $menu->restaurant->style }} menü</span>
                </div>
            </div>
            <h6><a href="/restaurants/{{$menu->restaurant->slug}}/menus/{{$menu->id}}">{{ $menu->name }}</a></h6>
        </div>
    </div>
</div>