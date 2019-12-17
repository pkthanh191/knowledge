<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('messages.categories')</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <span class="label label-warning">@lang('messages.info_multi_select')</span>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <ul class="nav nav-stacked">
            @foreach($categories as $category)
                <li>
                    <a href="#">
                        @if(isset($selectedCategories) && in_array($category->id, $selectedCategories))
                            {{ Form::checkbox('categories[]', $category->id, true, ['class' => 'minimal']) }}
                        @else
                            {{ Form::checkbox('categories[]', $category->id, false, ['class' => 'minimal']) }}
                        @endif
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div><!-- /.box-body -->
</div><!-- /.box -->