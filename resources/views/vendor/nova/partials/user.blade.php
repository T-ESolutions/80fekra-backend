<dropdown-trigger class="h-9 flex items-center">
    {{--    @isset($user->email)--}}

    <img
        src="{{ url('/storage') .'/' . $user->image }}"
        class="rounded-full w-8 h-8 mr-3"
    />
    {{--    @endisset--}}

    <span class="text-90">
        {{ $user->f_name ." ". $user->l_name?? $user->email ?? __('80Fekra User') }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">

        <li>
            <nova-dark-theme-toggle
                label="{{ __('Dark Theme') }}"
            ></nova-dark-theme-toggle>
        </li>
        <li>
            <router-link :to="{
                name: 'edit',
                params: {
                    resourceName: 'admins',
                    resourceId: '{{ $user->id }}'
                }
            }" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Profile') }}
            </router-link>
        </li>

        <li>
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
