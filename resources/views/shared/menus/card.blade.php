<div class="p-food-item style-2">
    <div class="p-food-inner">
        <div class="p-food-thumb">
            <img src="{{ $menu->media->link }}" alt="p-food">
        </div>
        <div class="p-food-content">
            <h6><a href="/restaurants/{{$menu->restaurant->slug}}/menus/{{$menu->id}}">{{ $menu->name }}</a> - {{ $menu->restaurant->name }}</h6>
            <div class="p-food-group">
                <span>Stílus :</span>
                {{ $menu->restaurant->style }}
            </div>
            <div class="mt-1">
                <p class="font-italic">{{ $menu->description }}</p>
                <div class="mt-2 float-right pb-2">
                    <a href="/restaurants/{{$menu->restaurant->slug}}/menus/{{$menu->id}}" class="food-btn"><span>Tovább a menüre</span></a>
                </div>
            </div>
        </div>
    </div>
</div>