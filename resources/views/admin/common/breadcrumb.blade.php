@php
$breadcrumb = Route::current()->uri();
$breadcrumbs = [
    'admin/dashboard' => ['admin/dashboard' => 'Dashboard'],
    'admin/profile' => ['admin/profile' => 'Profile'],
    'admin/users' => ['admin/users' => 'Users'],
    'admin/add_user' => ['admin/users' => 'Users', 'admin/add_user' => 'Add User'],
    'admin/edit_user' => ['admin/users' => 'Users', 'admin/edit_user' => 'Edit User'],
];

$breadcrumb = isset($breadcrumbs[$breadcrumb]) ? $breadcrumbs[$breadcrumb] : '';
@endphp
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    @if (is_array($breadcrumb))
        @php
            $i = 1;
            $cnt = count($breadcrumb);
        @endphp
        @foreach ($breadcrumb as $key => $value)
            @if ($cnt == $i)
                <li class="active">{{ $value }}</li>
            @else
                <li><a href="{{ URL::to($key) }}">{{ $value }}</a></li>
            @endif
            @php $i++; @endphp
        @endforeach
    @endif
</ol>
