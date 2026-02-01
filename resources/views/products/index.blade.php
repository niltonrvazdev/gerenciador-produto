<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ Auth::check() ? 'Gerenciamento de produtos' : 'Nossa Vitrine' }}
            </h2>
            @auth
                <!-- BOTÃO NOVO PRODUTO -->
                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Novo Produto
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- ALERTA DE SUCESSO -->
            @if (session('success'))
                <div id="success-alert"
                    class="mb-8 flex items-center bg-blue-600 text-white text-sm font-bold px-4 py-3 rounded-lg shadow-lg"
                    role="alert">

                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-4.742c.156-.627.103-.767-.103-.767-.349 0-1.619.643-2.181 1.054l-.546-.546c.928-1.077 2.378-2.14 3.421-2.14 1.058 0 1.258.825.928 2.14l-1.214 4.742c-.156.627-.103.767.103.767.349 0 1.619-.643 2.181-1.054l.546.546c-.928 1.077-2.378 2.14-3.421 2.14z" />
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 4000);
                </script>
            @endif

            <!-- FILTROS -->
            <div class="mb-8 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Buscar Produto</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nome do produto..." class="w-full border-gray-200 rounded-lg">
                    </div>
                    @auth
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Estoque Mín.</label>
                            <input type="number" name="min_stock" value="{{ request('min_stock') }}"
                                class="border-gray-200 rounded-lg w-32">
                        </div>
                    @endauth
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 h-[42px] shadow-sm">
                        <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Pesquisar
                    </button>
                </form>
            </div>

            @auth
                <!-- PAINEL DE GERENCIAMENTO DE PRODUTOS -->
                <div class="mb-12">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 uppercase tracking-widest">Gerenciamento</h3>
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-3 text-left">Foto</th>
                                    <th class="px-6 py-3 text-left">Produto</th>
                                    <th class="px-6 py-3 text-left">Preço</th>
                                    <th class="px-6 py-3 text-left">Estoque</th>
                                    <th class="px-6 py-3 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/100x100?text=Sem+Foto' }}"
                                                class="w-10 h-10 object-cover rounded-lg border">
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4 text-gray-600">R$
                                            {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td
                                            class="px-6 py-4 text-sm font-bold {{ $product->stock < 10 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $product->stock }} un.
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <!-- BOTÕES AGRUPADOS (EDIT | DELETE) -->
                                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                                <!-- EDIT -->
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="inline-flex items-center px-4 py-2 text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-50 hover:text-blue-600 focus:z-10 focus:ring-2 focus:ring-blue-500 transition">
                                                    <svg class="w-4 h-4 me-2 text-gray-500"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <!-- DELETE -->
                                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                    class="inline-flex" onsubmit="return confirm('Deseja excluir?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-50 hover:text-red-600 focus:z-10 focus:ring-2 focus:ring-red-500 transition">
                                                        <svg class="w-4 h-4 me-2 text-gray-500"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endauth

            <!-- VITRINE PÚBLICA - listagem de produtos-->
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-6 uppercase tracking-widest">Vitrine de Produtos</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
                    @foreach ($products as $product)
                        <div
                            style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div style="width: 100%; height: 180px; background-color: #f9fafb;">
                                <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/400x300?text=Sem+Foto' }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="padding: 15px; flex: 1;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                                    <h4
                                        style="font-weight: 800; color: #111827; text-transform: uppercase; font-size: 12px; margin: 0;">
                                        {{ $product->name }}</h4>
                                    <span style="color: #2563eb; font-weight: 900; font-size: 15px;">R$
                                        {{ number_format($product->price, 2, ',', '.') }}</span>
                                </div>
                                <p style="color: #6b7280; font-size: 11px; line-height: 1.4;">
                                    {{ $product->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
