<ul class="pt-4 mb-4 space-y-2 font-medium border-b border-gray-200 dark:border-gray-700">
    <li>
        <div class="flex items-center p-2 text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
            <i class="text-gray-500 fa-solid fa-circle-user"></i>
            <span class="ms-3">Admin</span>
        </div>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('agencies.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('agencies.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('agencies.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white fa-solid fa-building-columns"></i>
            <span class="ms-3">Agências</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('employees.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('employees.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('employees.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white fa-solid fa-people-group"></i>
            <span class="ms-3">Funcionários</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('customers.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('customers.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-hand-holding-dollar w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('customers.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Clientes</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('accounts.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('accounts.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-sack-dollar w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('accounts.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Contas</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('dependants.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('dependants.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-people-roof w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('dependants.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Dependentes</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('addresses.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('addresses.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-house-chimney w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('addresses.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Endereços</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('transactions.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('transactions.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-money-bill-transfer w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('transactions.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Transações</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('logout') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('transactions.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300" wire:navigate>
            <i class="fa-solid fa-right-from-bracket w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('transactions.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Logout</span>
        </a>
    </li>
</ul>
