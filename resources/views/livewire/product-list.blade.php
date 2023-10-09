<!-- resources/views/livewire/product-list.blade.php -->

<div>
    <input type="text" wire:model="search" placeholder="検索...">
    
    <table>
        <thead>
            <tr>
                <th>商品名</th>
                <th>メーカー</th>
                <!-- 他の列を追加 -->
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->manufacturer }}</td>
                    <!-- 他の列の表示 -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
