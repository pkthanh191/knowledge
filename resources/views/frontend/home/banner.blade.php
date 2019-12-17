<div class="suggestions image-carousel image-carousel-banner relative mine-slide" data-animation=""
     animation-duration="0s" data-animation-delay="0.1s" data-item-width="150">
    <ul class="slides slide-banners">
        @foreach($banners as $banner)
            <li style="margin-right: 10px;">
                <article class="box">
                    <figure>
                        <a title="" href="{{ $banner->url? $banner->url : '#' }}" target="_blank"><img alt=""
                                                                                                       data-original="{{$banner->image}}"
                                                                                                       class="img-banner"></a>
                    </figure>
                </article>
            </li>
        @endforeach
    </ul>
</div>
{{--<div class="owl-carousel owl-theme">--}}
{{--<div class="item">--}}
{{--<h4>1</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>2</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>3</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>4</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>5</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>6</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>7</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>8</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>9</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>10</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>11</h4>--}}
{{--</div>--}}
{{--<div class="item">--}}
{{--<h4>12</h4>--}}
{{--</div>--}}
{{--</div>--}}
{{--<a class="button secondary play">Play</a>--}}
{{--<a class="button secondary stop">Stop</a>--}}