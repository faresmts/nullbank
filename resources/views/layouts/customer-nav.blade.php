<ul class="pt-4 mb-4 space-y-2 font-medium border-b border-gray-200 dark:border-gray-700">
    <li>
        <div class="flex items-center p-2 text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
            <i class="text-gray-500 fa-solid fa-circle-user"></i>
            <span class="ms-3">{{$customer->nome}}</span>
        </div>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('customers.transactions.index', $customer->cpf) }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('customers.transactions.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300">
            <i class="fa-solid fa-money-bill-transfer w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('customers.transactions.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Minhas Transações</span>
        </a>
    </li>
</ul>

<ul class="space-y-2 font-medium">
    <li>
        <a href=" {{ route('logout') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 {{ request()->routeIs('transactions.*') ? 'bg-gray-100' : '' }} dark:hover:bg-gray-700 group hover:scale-105 transition-transform duration-300">
            <i class="fa-solid fa-right-from-bracket w-5 h-5 ml-0.5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 {{ request()->routeIs('transactions.*') ? 'text-gray-900' : '' }} dark:group-hover:text-white"></i>
            <span class="ms-3">Logout</span>
        </a>
    </li>
</ul>

