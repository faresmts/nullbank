<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('accounts.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('accounts.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-sack-dollar w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('accounts.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Contas</span>
        </a>
    </li>
</ul>
