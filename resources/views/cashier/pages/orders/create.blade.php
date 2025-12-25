@extends($layout ?? 'cashier.layouts.app')

@php($routePrefix = $routePrefix ?? 'cashier.')

@section('content')
    <section class="space-y-2">
        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif


        <form method="POST" action="{{ route($routePrefix . 'orders.store') }}" class="space-y-6">
            @csrf
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Каталог</p>
                        <h2 class="mt-1 text-lg font-semibold text-slate-900">Добавление по артикулу</h2>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <input id="product-search" type="text" placeholder="Введите артикул"
                            class="w-64 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">

                    </div>
                </div>

                <div id="product-grid"
                    class="mt-5 grid max-h-[360px] gap-4 overflow-y-auto pr-1 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($products as $product)
                        <article
                            class="product-card hidden rounded-2xl border border-slate-100 bg-slate-50/70 p-4 shadow-sm"
                            data-name="{{ strtolower($product->name) }}" data-code="{{ strtolower($product->code) }}"
                            data-price="{{ $product->display_price }}">
                            <p class="text-xs uppercase text-slate-400">Арт: {{ $product->code }}</p>
                            <h3 class="mt-2 line-clamp-2 text-sm font-semibold text-slate-900">{{ $product->name }}</h3>
                            <p class="mt-3 text-sm font-semibold text-slate-700">
                                {{ number_format($product->display_price, 2, '.', ' ') }} c</p>
                            <div class="mt-4 flex items-center gap-2">
                                <input type="number" min="1" value="1"
                                    class="qty-input w-20 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                <button type="button" data-add-product="{{ $product->id }}"
                                    class="rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold uppercase text-white">
                                    Добавить
                                </button>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
                            Товары не найдены.
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="grid gap-4 rounded-3xl bg-white p-6 shadow-sm sm:grid-cols-2">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Имя клиента</label>
                    <input name="customer_name" value="{{ old('customer_name') }}" required
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Телефон</label>
                    <input name="customer_phone" value="{{ old('customer_phone') }}" required
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Оплата</label>
                    <select name="payment"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        <option value="Наличными" @selected(old('payment', 'Наличными') === 'Наличными')>Наличными</option>
                        <option value="Душанбе сити" @selected(old('payment', 'Наличными') === 'Душанбе сити')>Душанбе сити</option>
                        <option value="Карта Милли" @selected(old('payment') === 'Карта Милли')>Карта Милли</option>
                        <option value="Алиф Моби" @selected(old('payment') === 'Алиф Моби')>Алиф Моби</option>
                        <option value="Рассрочка Карта Салом" @selected(old('payment') === 'Рассрочка Карта Салом')>Рассрочка Карта Салом</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Тип доставки</label>
                    <select name="delivery_type"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        <option value="Самовывоз" @selected(old('delivery_type', 'Самовывоз') === 'Самовывоз')>Самовывоз</option>
                        <option value="Доставка курьером" @selected(old('delivery_type') === 'Доставка курьером')>Доставка курьером</option>
                        <option value="Через таксисты" @selected(old('delivery_type') === 'Через таксисты')>Через таксисты</option>
                    </select>
                </div>
                <input type="hidden" name="city" value="Душанбе">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Адрес</label>
                    <input name="location" value="{{ old('location') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Курьер</label>
                    <select name="courier_id"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        <option value="">Не назначен</option>
                        @foreach ($couriers as $courier)
                            <option value="{{ $courier->id }}" @selected(old('courier_id') == $courier->id)>{{ $courier->name }} — +992
                                {{ $courier->phone }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Комментарий</label>
                    <textarea name="note" rows="3"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">{{ old('note') }}</textarea>
                </div>
            </div>

            <div class="grid gap-4 rounded-3xl bg-white p-6 shadow-sm sm:grid-cols-3">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Подытог (c)</label>
                    <input name="subtotal" value="{{ old('subtotal') }}" placeholder="0.00"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Скидка (c)</label>
                    <input name="discount" value="{{ old('discount') }}" placeholder="0.00"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Итог (c)</label>
                    <input name="total" value="{{ old('total') }}" placeholder="0.00"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                </div>
                <p class="sm:col-span-3 text-xs text-slate-400">Если товары не выбраны, можно ввести суммы вручную.</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Выбранные товары</h2>
                    <span class="text-xs font-semibold text-slate-500" id="selected-count">0 шт</span>
                </div>
                <div id="selected-list" class="mt-4 space-y-3 text-sm text-slate-600">
                    <p class="text-sm text-slate-400" data-empty>Товары пока не выбраны.</p>
                </div>
                <div id="selected-items" class="hidden"></div>
            </div>

            <button type="submit"
                class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">Создать заказ</button>
        </form>
    </section>
@endsection

@section('scripts')
    <script>
        const selectedItems = document.getElementById('selected-items');
        const selectedList = document.getElementById('selected-list');
        const selectedCount = document.getElementById('selected-count');
        const productGrid = document.getElementById('product-grid');
        const productSearch = document.getElementById('product-search');
        const subtotalInput = document.querySelector('input[name="subtotal"]');
        const discountInput = document.querySelector('input[name="discount"]');
        const totalInput = document.querySelector('input[name="total"]');

        const filterProducts = () => {
            const term = (productSearch?.value || '').toLowerCase().trim();
            const cards = Array.from(productGrid?.querySelectorAll('.product-card') || []);
            cards.forEach((card) => {
                const name = card.dataset.name || '';
                const code = card.dataset.code || '';
                const visible = term && (name.includes(term) || code.includes(term));
                card.classList.toggle('hidden', !visible);
            });
        };

        productSearch?.addEventListener('input', () => {
            filterProducts();
        });

        const addByCode = () => {
            const term = (productSearch.value || '').toLowerCase().trim();
            if (!term) return;
            const match = productGrid?.querySelector(`.product-card[data-code=\"${term}\"]`);
            if (match) {
                const button = match.querySelector('[data-add-product]');
                button?.click();
                productSearch.value = '';
                filterProducts();
            }
        };

        productSearch?.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter') return;
            event.preventDefault();
            addByCode();
        });

        document.getElementById('product-add')?.addEventListener('click', addByCode);

        const refreshSelectedCount = () => {
            const total = Array.from(selectedList?.querySelectorAll('[data-qty]') || []).reduce((sum, row) => {
                return sum + parseInt(row.getAttribute('data-qty') || '0', 10);
            }, 0);
            if (selectedCount) {
                selectedCount.textContent = `${total} шт`;
            }
        };

        const syncHiddenInputs = () => {
            if (!selectedItems) return;
            selectedItems.innerHTML = '';
            const rows = Array.from(selectedList?.querySelectorAll('[data-product-id]') || []);
            rows.forEach((row) => {
                const productId = row.getAttribute('data-product-id');
                const qty = row.getAttribute('data-qty') || '1';
                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                    <input type=\"hidden\" name=\"product_id[]\" value=\"${productId}\">
                    <input type=\"hidden\" name=\"quantity[]\" value=\"${qty}\">
                `;
                selectedItems.appendChild(wrapper);
            });
            refreshSelectedCount();
        };

        const upsertSelectedItem = (productId, name, price, qty) => {
            if (!selectedList) return;
            const existing = selectedList.querySelector(`[data-product-id=\"${productId}\"]`);
            if (existing) {
                const currentQty = parseInt(existing.getAttribute('data-qty') || '1', 10);
                const newQty = currentQty + parseInt(qty || '1', 10);
                existing.setAttribute('data-qty', newQty);
                existing.querySelector('[data-qty-label]').textContent = `${newQty} шт`;
                syncHiddenInputs();
                updateSubtotalFromItems();
                return;
            }

            if (selectedList.querySelector('[data-empty]')) {
                selectedList.innerHTML = '';
            }

            const row = document.createElement('div');
            row.className =
                'flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3';
            row.setAttribute('data-product-id', productId);
            row.setAttribute('data-qty', qty);
            row.setAttribute('data-price', price);
            row.innerHTML = `
                <div class=\"min-w-0\">
                    <p class=\"truncate font-semibold text-slate-900\">${name}</p>
                    <p class=\"text-xs text-slate-500\">${price} c</p>
                </div>
                <div class=\"flex items-center gap-2\">
                    <button type=\"button\" class=\"qty-minus rounded-xl border border-slate-200 px-2 py-1 text-xs\">-</button>
                    <span data-qty-label class=\"text-sm font-semibold\">${qty} шт</span>
                    <button type=\"button\" class=\"qty-plus rounded-xl border border-slate-200 px-2 py-1 text-xs\">+</button>
                    <button type=\"button\" class=\"remove-item rounded-xl border border-rose-200 px-2 py-1 text-xs text-rose-600\">✕</button>
                </div>
            `;
            selectedList.appendChild(row);
            syncHiddenInputs();
            updateSubtotalFromItems();
        };

        selectedList?.addEventListener('click', (event) => {
            const row = event.target.closest('[data-product-id]');
            if (!row) return;
            const productId = row.getAttribute('data-product-id');
            let qty = parseInt(row.getAttribute('data-qty') || '1', 10);

            if (event.target.classList.contains('qty-plus')) {
                qty += 1;
            } else if (event.target.classList.contains('qty-minus')) {
                qty = Math.max(1, qty - 1);
            } else if (event.target.classList.contains('remove-item')) {
                row.remove();
                if (!selectedList.querySelector('[data-product-id]')) {
                    selectedList.innerHTML =
                        '<p class=\"text-sm text-slate-400\" data-empty>Товары пока не выбраны.</p>';
                }
                syncHiddenInputs();
                updateSubtotalFromItems();
                return;
            } else {
                return;
            }

            row.setAttribute('data-qty', qty);
            row.querySelector('[data-qty-label]').textContent = `${qty} шт`;
            syncHiddenInputs();
            updateSubtotalFromItems();
        });

        productGrid?.addEventListener('click', (event) => {
            const button = event.target.closest('[data-add-product]');
            if (!button) return;
            const productId = button.getAttribute('data-add-product');
            const card = button.closest('.product-card');
            const qtyInput = card?.querySelector('.qty-input');
            const quantity = qtyInput?.value || '1';
            const name = card?.querySelector('h3')?.textContent?.trim() || 'Товар';
            const price = card?.dataset.price || '0';
            upsertSelectedItem(productId, name, price, quantity);
        });

        const parseNumber = (value) => {
            const normalized = (value || '').toString().replace(',', '.');
            const number = parseFloat(normalized);
            return Number.isFinite(number) ? number : 0;
        };

        const updateTotal = () => {
            if (!totalInput) return;
            const subtotal = parseNumber(subtotalInput?.value);
            const discount = parseNumber(discountInput?.value);
            const total = Math.max(0, subtotal - discount);
            totalInput.value = total.toFixed(2);
        };

        const updateSubtotalFromItems = () => {
            if (!subtotalInput || !selectedList) return;
            const rows = Array.from(selectedList.querySelectorAll('[data-product-id]'));
            const subtotal = rows.reduce((sum, row) => {
                const qty = parseInt(row.getAttribute('data-qty') || '0', 10);
                const price = parseNumber(row.getAttribute('data-price'));
                return sum + (qty * price);
            }, 0);
            subtotalInput.value = subtotal.toFixed(2);
            updateTotal();
        };

        subtotalInput?.addEventListener('input', updateTotal);
        discountInput?.addEventListener('input', updateTotal);
    </script>
@endsection
