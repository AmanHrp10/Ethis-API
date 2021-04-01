@component('mail::message')
# {{$data['title']}}

New Post from {{$data['userName']}}

@component('mail::button', ['url' => $data['url']])
Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
