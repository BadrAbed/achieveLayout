

@foreach(auth()->user()->unreadNotifications as $value)
    @include('notification.'.snake_case(class_basename($value->type)))
@endforeach
<?php die();?>
{{dd($value->data['content']['id'])

}}
<?php auth()->user()->unreadNontifications->markAsRead(); ?>
<?php $value->markAsRead(); ?>
